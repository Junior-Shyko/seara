<?php

namespace Seara\Http\Controllers;

use Carbon\Carbon;
use Seara\Transaction;
use Seara\AccountLaunch;
use Seara\FinancialEntry;
use Seara\Models\Company;
use Seara\Seara\Monetary;
use Seara\TransferDetail;
use Illuminate\Support\Str;
use Seara\FinancialAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Logging\Log;
use Yajra\DataTables\Facades\DataTables;
use Seara\Repository\SettingsBoxRepository;
use Seara\Repository\AccountLaunchRepository;
use function app;
use function dd;

class FinancialEntryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Valida e retorna o ID da empresa com base nas permissões do usuário
     *
     * @return int|null ID da empresa ou null se redirecionamento for necessário
     * @throws \Illuminate\Http\RedirectResponse
     */
    private function validateAndGetCompanyId()
    {
        $user = Auth::user();
        $idCompany = $user->user_id_company;

        if (app('request')->input('company') !== null) {
            $idCompany = intval(app('request')->input('company'));
        }
        // CASO O USUARIO NÃO SEJA UM SUPER ADMIN, ENTRA NA CONDIÇÃO PARA VERIFICAÇÃO
        if (!$user->hasRole('superAdmin')) {
            // verifica se o id das empresas são iguais
            if ($idCompany !== $user->user_id_company) {
                abort(403, 'Você não tem permissão de acesso a esta empresa.');
            }
        }

        return $idCompany;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idCompany = $this->validateAndGetCompanyId();

        $company = Company::getCompany($idCompany);
        // Calcular totais

        $totalBanks = FinancialAccount::byCompany($idCompany)
            ->banks()
            ->sum('current_balance');
        $totalCash = FinancialAccount::byCompany($idCompany)
            ->cash()
            ->sum('current_balance');

        $totalGeneral = $totalBanks + $totalCash;
        //TODAS CONTAS
        $accountsBussines = FinancialAccount::byCompany($idCompany)->get();
        $accounts = AccountLaunch::get();
        return view('entry.index', compact(
            'totalBanks',
            'totalCash',
            'totalGeneral',
            'idCompany',
            'company',
            'accounts',
            'accountsBussines'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Salva novo lançamento (Receita ou Despesa)
     */
    public function store(Request $request)
    {
        $companyId = $this->validateAndGetCompanyId();
        $userId = auth()->id();

        DB::beginTransaction();

        try {
            $dateStart = SettingsBoxRepository::convertDateToFullYear($request->entries_date_launch);

            // Converter data
            $entryDate = \Carbon\Carbon::createFromFormat('d/m/Y', $dateStart);

            // Upload de arquivo (se houver)
            $documentPath = null;
            if ($request->hasFile('document_file')) {
                $file = $request->file('document_file');
                $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $documentPath = $file->storeAs('financial_documents', $filename, 'public');
            }
            // Busca o tipo de conta (Receita ou Despesa)
            $typeAccount  = AccountLaunchRepository::getTypeAccount($request->entries_id_account);
            // Alterando para novoo padrao (income, expense ou transfer)
            $type = $this->getReturnTypeAccount($typeAccount);

            $numeric_value = Monetary::money_real($request->entries_value);
            // ========================================
            // DETERMINAR A CONTA FINANCEIRA
            // ========================================
            $accountId = null;

            if ($request->filled('entries_bank') && $request->entries_bank > 0) {
                // Banco foi selecionado
                $accountId = $request->entries_bank;
            } else {
                // Caixa Interno - Buscar o caixa interno da empresa
                $caixaInterno = FinancialAccount::where('company_id', $companyId)
                    ->where('type', 'cash')
                    ->first();

                if (!$caixaInterno) {
                    throw new \Exception('Caixa interno não encontrado para esta empresa. Por favor, cadastre uma conta de caixa.');
                }

                $accountId = $caixaInterno->id;
            }

            // Validar se a conta existe
            $account = FinancialAccount::find($accountId);

            if (!$account) {
                throw new \Exception('Conta financeira não encontrada (ID: ' . $accountId . ')');
            }

            // Validar se a conta pertence à empresa
            if ($account->company_id != $companyId) {
                throw new \Exception('Esta conta não pertence à sua empresa.');
            }
            // 1. Criar Transaction (cabeçalho)
            $transaction = Transaction::create([
                'uuid' => $this->generateUuid(),
                'type' => $type,
                'status' => 'completed',
                'description' => $request->entries_description,
                'total_amount' => $numeric_value,
                'from_account_id' => null,
                'to_account_id' => null,
                'company_id' => $companyId,
                'created_by_user_id' => $userId
            ]);

            // 2. Determinar tipo de entry (credit ou debit)
            $entryType = $type === 'income' ? 'credit' : 'debit';

            // 3. Criar Financial Entry

            $entry = FinancialEntry::create([
                'transaction_id' => $transaction->id,
                'account_id' => $accountId,
                'category_id' => $request->entries_id_account,
                'type' => $entryType,
                'description' => $request->entries_description,
                'amount' => $numeric_value,
                'entry_date' => $entryDate,
                'document_file' => $documentPath,
                'company_id' => $companyId,
                'created_by_user_id' => $userId
            ]);

            // ========================================
            // 4. ATUALIZAR SALDO DA CONTA
            // ========================================
            if ($entryType === 'credit') {
                // Receita: aumenta saldo
                $account->increment('current_balance', $numeric_value);
            } else {
                // Despesa: diminui saldo

                // Validar se tem saldo suficiente (opcional)
                if ($account->current_balance < $numeric_value) {
                    // Pode optar por lançar exceção ou apenas avisar
                    // throw new \Exception('Saldo insuficiente na conta ' . $account->name);

                    // Ou permitir saldo negativo:
                    $account->decrement('current_balance', $numeric_value);
                } else {
                    $account->decrement('current_balance', $numeric_value);
                }
            }

            DB::commit();
            return response()->json([
                'message' => 'Conta lançada',
                'status' => 'success',
                'id' => $entry->id,
                'typeAccount' => $entryType,
                'account_name' => $account->name,
                'new_balance' => $account->fresh()->current_balance
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            dd([
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            // Se houve upload, deletar arquivo
            // if ($documentPath && \Storage::disk('public')->exists($documentPath)) {
            //     \Storage::disk('public')->delete($documentPath);
            // } 
            return response()->json([
                'message' => 'Ocorreu um erro ao cadastrar lançamento: ' . $e->getMessage(),
                'status' => 'error',
                'id' => $entry->id,
                'typeAccount' => $entryType
            ], 200);
            return back()
                ->withInput()
                ->withErrors(['error' => 'Erro ao cadastrar lançamento: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Seara\FinancialEntry  $financialEntry
     * @return \Illuminate\Http\Response
     */
    public function show(FinancialEntry $financialEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Seara\FinancialEntry  $financialEntry
     * @return \Illuminate\Http\Response
     */
    public function edit(FinancialEntry $financialEntry)
    {
        //
    }

    /**
     * Atualiza um lançamento existente
     * 
     * @param Request $request
     * @param int $id ID da Transaction
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $companyId = $this->validateAndGetCompanyId();
        $userId = auth()->id();

        DB::beginTransaction();

        try {
            // ========================================
            // 1. BUSCAR TRANSACTION E VALIDAR
            // ========================================
            $transaction = Transaction::with(['entries.account'])
                ->findOrFail($id);

            // Verificar se pertence à empresa do usuário
            if ($transaction->company_id != $companyId) {
                return response()->json([
                    'message' => 'Você não tem permissão para editar este lançamento.',
                    'status' => 'error',
                    'type' => 'error',
                ], 403);
            }

            // Não permitir editar transferências (são criadas em par)
            if ($transaction->type === 'transfer') {
                return response()->json([
                    'message' => 'Transferências não podem ser editadas. Exclua e crie uma nova.',
                    'status' => 'error',
                    'type' => 'error',
                ], 400);
            }

            // ========================================
            // 2. VALIDAR DADOS
            // ========================================
            $dateStart = SettingsBoxRepository::convertDateToFullYear($request->entries_date_launch);
            $entryDate = \Carbon\Carbon::createFromFormat('d/m/Y', $dateStart);

            // Buscar tipo da categoria
            $typeAccount = AccountLaunchRepository::getTypeAccount($request->entries_id_account);
            $type = $this->getReturnTypeAccount($typeAccount);
            $entryType = $type === 'income' ? 'credit' : 'debit';

            // Converter valor
            $numeric_value = Monetary::money_real($request->entries_value);

            // ========================================
            // 3. PEGAR ENTRY ORIGINAL (só tem 1 para receitas/despesas)
            // ========================================
            $originalEntry = $transaction->entries->first();

            if (!$originalEntry) {
                throw new \Exception('Entry original não encontrada');
            }

            // Guardar valores antigos para reverter saldo
            $oldAmount = $originalEntry->amount;
            $oldAccountId = $originalEntry->account_id;
            $oldType = $originalEntry->type;

            // ========================================
            // 4. DETERMINAR NOVA CONTA (se mudou)
            // ========================================
            $newAccountId = $oldAccountId; // Por padrão, mantém a mesma

            // Se o request tiver informação de conta, usar ela
            if ($request->filled('entries_bank')) {
                $newAccountId = $request->entries_bank;
            } elseif ($request->filled('account_id')) {
                $newAccountId = $request->account_id;
            }
            // Senão, mantém a conta original

            // Validar se a nova conta existe
            $newAccount = FinancialAccount::find($newAccountId);

            if (!$newAccount) {
                throw new \Exception('Conta financeira não encontrada (ID: ' . $newAccountId . ')');
            }

            // ========================================
            // 5. REVERTER SALDO DA CONTA ANTIGA
            // ========================================
            $oldAccount = FinancialAccount::find($oldAccountId);

            if ($oldAccount) {
                if ($oldType === 'credit') {
                    // Era receita: diminui o saldo antigo
                    $oldAccount->decrement('current_balance', $oldAmount);
                } else {
                    // Era despesa: aumenta o saldo antigo (revertendo)
                    $oldAccount->increment('current_balance', $oldAmount);
                }
            }

            // ========================================
            // 6. ATUALIZAR TRANSACTION
            // ========================================
            $transaction->update([
                'type' => $type,
                'description' => $request->entries_description,
                'total_amount' => $numeric_value,
                'updated_at' => now()
            ]);

            // ========================================
            // 7. ATUALIZAR ENTRY
            // ========================================
            $originalEntry->update([
                'account_id' => $newAccountId,
                'category_id' => $request->entries_id_account,
                'type' => $entryType,
                'description' => $request->entries_description,
                'amount' => $numeric_value,
                'entry_date' => $entryDate,
                'updated_at' => now()
            ]);

            // ========================================
            // 8. APLICAR NOVO SALDO NA CONTA NOVA
            // ========================================
            if ($entryType === 'credit') {
                // Nova receita: aumenta saldo
                $newAccount->increment('current_balance', $numeric_value);
            } else {
                // Nova despesa: diminui saldo
                $newAccount->decrement('current_balance', $numeric_value);
            }

            DB::commit();

            return response()->json([
                'message' => 'Lançamento atualizado com sucesso',
                'status' => 'success',
                'id' => $transaction->id,
                'typeAccount' => $entryType,
                'new_balance' => $newAccount->fresh()->current_balance
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Lançamento não encontrado.',
                'status' => 'error'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();

            // Log do erro
            // \Log::error('Erro ao atualizar lançamento ID ' . $id, [
            //     'message' => $e->getMessage(),
            //     'file' => $e->getFile(),
            //     'line' => $e->getLine(),
            //     'user_id' => $userId,
            //     'company_id' => $companyId
            // ]);

            return response()->json([
                'message' => 'Ocorreu um erro ao atualizar lançamento: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    /**
     * Exclui um lançamento (Transaction + Entries + Atualiza Saldos).
     *
     * @param int $id ID da Transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $companyId = $this->validateAndGetCompanyId();

            // 1. BUSCAR E VALIDAR TRANSACTION
            $transaction = Transaction::with(['entries.account'])
                ->findOrFail($request->id);

            if ($transaction->company_id != $companyId) {
                return response()->json([
                    'title' => 'Erro',
                    'message' => 'Você não tem permissão para excluir este lançamento.',
                    'status' => '403',
                    'type' => 'error'
                ], 403);
            }
            // 2. REVERTER SALDOS DAS CONTAS
            // A lógica é a mesma para TODAS as transactions (incluindo transferências)
            // porque as entries já guardam corretamente debit/credit
            foreach ($transaction->entries as $entry) {
                $account = $entry->account;

                if (!$account) {
                    \Log::warning("Conta não encontrada para entry {$entry->id}");
                    continue; // Pula se a conta foi deletada
                }
                // Reverter o lançamento:
                // - Se foi CRÉDITO (entrada de dinheiro), DIMINUI o saldo (remove a entrada)
                // - Se foi DÉBITO (saída de dinheiro), AUMENTA o saldo (remove a saída)
                if ($entry->type === 'credit') {
                    $account->decrement('current_balance', $entry->amount);

                    \Log::info("Revertendo CRÉDITO de R$ {$entry->amount} na conta {$account->name} (ID: {$account->id})");
                } else {
                    $account->increment('current_balance', $entry->amount);

                    \Log::info("Revertendo DÉBITO de R$ {$entry->amount} na conta {$account->name} (ID: {$account->id})");
                }
            }
            // 3. DELETAR ARQUIVOS ANEXADOS (se houver)
            foreach ($transaction->entries as $entry) {
                if ($entry->document_file && \Storage::disk('public')->exists($entry->document_file)) {
                    \Storage::disk('public')->delete($entry->document_file);
                    \Log::info("Arquivo deletado: {$entry->document_file}");
                }
            }
            // 4. DELETAR A TRANSACTION
            // Com ON DELETE CASCADE configurado:
            // - financial_entries serão deletadas automaticamente
            // - transfer_details serão deletados automaticamente (se existir)
            $transactionId = $transaction->id;
            $transactionType = $transaction->type;
            $transaction->delete();

            DB::commit();

            \Log::info("Transaction {$transactionId} (tipo: {$transactionType}) deletada com sucesso");

            return back()->with('success', 'Lançamento excluído com sucesso!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();

            \Log::error('Transaction não encontrada: ' . $request->id);

            return response()->json([
                'title' => 'Erro',
                'message' => 'Lançamento não encontrado.',
                'status' => '404',
                'type' => 'error'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Erro ao excluir lançamento ID ' . $request->id, [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
                'company_id' => $companyId ?? null
            ]);

            return response()->json([
                'title' => 'Erro',
                'message' => 'Erro ao excluir lançamento: ' . $e->getMessage(),
                'status' => '500',
                'type' => 'error'
            ], 500);
        }
    }

    /**
     * DataTables - Retorna dados em JSON
     */
    public function datatable(Request $request, $company)
    {
        // Usar o route parameter ao invés de depender apenas do validateAndGetCompanyId
        $user = Auth::user();

        // Se não for superAdmin, validar se pode acessar essa empresa
        if (!$user->hasRole('superAdmin')) {
            if (intval($company) !== $user->user_id_company) {
                abort(403, 'Você não tem permissão de acesso a esta empresa.');
            }
        }

        $companyId = intval($company);

        $query = Transaction::with([
            'entries.account',
            'entries.category',
            'createdBy',
            'fromAccount',
            'toAccount'
        ])
            ->byCompany($companyId);

        // Filtro por tipo
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtro por período
        if ($request->filled('dtIni') && $request->filled('dtEnd')) {
            $dtInitCarbon = Carbon::createFromFormat('y-m-d', $request->dtIni);
            $dtEndCarbon = Carbon::createFromFormat('y-m-d', $request->dtEnd);
            $query->whereHas('entries', function ($q) use ($dtInitCarbon, $dtEndCarbon) {
                $q->whereBetween('entry_date', [$dtInitCarbon, $dtEndCarbon]);
            });
        }

        return DataTables::of($query)
            ->addColumn('created_at', function ($transaction) {
                $firstEntry = $transaction->entries->first();
                return $firstEntry ? $firstEntry->entry_date->format('d/m/Y') : '-';
            })
            ->addColumn('date_sort', function ($transaction) {
                $firstEntry = $transaction->entries->first();
                return $firstEntry ? $firstEntry->entry_date->timestamp : 0;
            })
            ->addColumn('type_badge', function ($transaction) {
                return $transaction->type_formatted;
            })
            ->addColumn('amount_formatted', function ($transaction) {
                return $transaction->amount_formatted;

            })
            ->addColumn('total_amount', function ($transaction) {
                return $transaction->total_amount;
            })
            ->addColumn('total_amount_formatted', function ($transaction) {
                return number_format($transaction->total_amount, 2, ',', '.');
            })
            ->addColumn('description', function ($transaction) {
                return $transaction->description;
            })

            ->addColumn('account_info', function ($transaction) {
                if ($transaction->isTransfer()) {
                    return $transaction->transfer_description;
                }

                $firstEntry = $transaction->entries->first();
                return $firstEntry && $firstEntry->account
                    ? $firstEntry->account->name
                    : '-';
            })
            ->addColumn('user', function ($transaction) {
                return $transaction->createdBy ? $transaction->createdBy->name : '-';
            })
            ->addColumn('action', function ($mov) {
                $firstEntry = $mov->entries->first();
                $dtLauch = $firstEntry ? $firstEntry->entry_date->format('d/m/Y') : '';

                $btnUserRole = '';

                if (Auth::user()->hasRole('user')) {
                    return $btnUserRole;
                }

                // $disabled = $mov->isTransfer() ? 'disabled' : '';
                $disabled = '';

                return '<button class="btn btn-primary btn-xs ' . $disabled . '" type="button" title="Editar do Registro"
                data-toggle="modal"
                data-id="' . $mov->id . '"
                data-date="' . $dtLauch . '"
                data-his="' . $mov->description . '"
                data-company_id="' . Auth::user()->user_id_company . '"
                data-val="' . number_format($mov->total_amount, 2, ',', '.')   . '"
                data-typ="' . ($firstEntry && $firstEntry->category ? $firstEntry->category->accountlaunch_name : '') . '"
                data-idlau="' . ($firstEntry ? $firstEntry->category_id : '') . '"
                data-namel="' . ($firstEntry && $firstEntry->account ? $firstEntry->account->name : '') . '"
                data-target="#modalEditLauch">
                <i class="fa fa-edit" aria-hidden="true"></i></button>
                ' . $btnUserRole . '
                <button class="btn btn-danger btn-xs" ' . $disabled . ' type="button" title="Excluir Registro"
                data-toggle="modal"
                data-id="' . $mov->id . '"
                data-name="' . $mov->description . '"
                data-parent="' . ($mov->isTransfer() ? '1' : '0') . '"
                data-type="' . $mov->type . '"
                data-target="#modalDeleteComponent">
                <i class="fa fa-trash"></i></button>';
            })
            ->filterColumn('description', function($query, $keyword) {
                $query->where('description', 'like', "%{$keyword}%");
            })
            ->filterColumn('total_amount', function($query, $keyword) {
                // Remove formatação para buscar pelo valor
                $keyword = str_replace(['.', ','], ['', '.'], $keyword);
                $query->where('total_amount', 'like', "%{$keyword}%");
            })
            ->filterColumn('account_info', function($query, $keyword) {
                $query->whereHas('entries.account', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('user', function($query, $keyword) {
                $query->whereHas('createdBy', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('type_badge', function($query, $keyword) {
                $query->where('type', 'like', "%{$keyword}%");
            })
            ->filterColumn('created_at', function($query, $keyword) {
                // Busca por data no formato dd/mm/yyyy ou yyyy-mm-dd
                $query->whereHas('entries', function($q) use ($keyword) {
                    $q->where('entry_date', 'like', "%{$keyword}%");
                });
            })
            ->rawColumns(['type_badge', 'amount_formatted', 'action', 'total_amount_formatted'])
            ->make(true);
    }

    protected function getReturnTypeAccount($typeAccount)
    {
        switch ($typeAccount) {
            case 'Receita':
                return 'income';
            case 'Despesa':
                return 'expense';
            default:
                return 'transfer';
        }
    }

    private function generateUuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    public function transfer(Request $request)
    {
        $companyId = $this->validateAndGetCompanyId();
        $userId = auth()->id();
    
    // Buscar contas
    $fromAccount = FinancialAccount::find($request->idAccountEnd);
    $toAccount = FinancialAccount::find($request->idAccountEntry);
    
    // Validações
    if (!$fromAccount || !$toAccount) {
        return response()->json([
            'title' => 'Erro',
            'message' => 'Conta de origem ou destino não encontrada.',
            'status' => '404',
            'type' => 'error'
        ], 404);
    }
    
    if ($fromAccount->id === $toAccount->id) {
        return response()->json([
            'title' => 'Erro',
            'message' => 'Conta de origem e destino não podem ser iguais.',
            'status' => '400',
            'type' => 'error'
        ], 400);
    }
    
    $numeric_value = Monetary::money_real($request->value);
    
    // Validar saldo
    if ($fromAccount->current_balance < $numeric_value) {
        return response()->json([
            'title' => 'Erro',
            'message' => 'Saldo insuficiente na conta de origem. Disponível: R$ ' . number_format($fromAccount->current_balance, 2, ',', '.'),
            'status' => '400',
            'type' => 'error'
        ], 400);
    }

    DB::beginTransaction();
    
    try {
        // ========================================
        // 1. CRIAR TRANSACTION
        // ========================================
        $transaction = Transaction::create([
            'uuid' => $this->generateUuid(),
            'type' => 'transfer',
            'status' => 'completed',
            'description' => 'Transferência: ' . $fromAccount->name . ' → ' . $toAccount->name,
            'total_amount' => $numeric_value,
            'from_account_id' => $fromAccount->id, // 👈 Usar objeto, não request
            'to_account_id' => $toAccount->id,     // 👈 Usar objeto, não request
            'company_id' => $companyId,
            'created_by_user_id' => $userId
        ]);
        
        // ========================================
        // 2. CRIAR ENTRY DE DÉBITO (Saída da origem)
        // ========================================
        $debitEntry = FinancialEntry::create([
            'transaction_id' => $transaction->id,
            'account_id' => $fromAccount->id, // 👈 CONTA DE ORIGEM
            'category_id' => null,
            'type' => 'debit', // 👈 SAÍDA
            'description' => 'Transferência enviada para ' . $toAccount->name,
            'amount' => $numeric_value,
            'entry_date' => Carbon::now(),
            'document_file' => null,
            'company_id' => $companyId,
            'created_by_user_id' => $userId
        ]);
        
        // ========================================
        // 3. CRIAR ENTRY DE CRÉDITO (Entrada no destino)
        // ========================================
        $creditEntry = FinancialEntry::create([
            'transaction_id' => $transaction->id,
            'account_id' => $toAccount->id, // 👈 CORRIGIDO: CONTA DE DESTINO
            'category_id' => null,
            'type' => 'credit', // 👈 ENTRADA
            'description' => 'Transferência recebida de ' . $fromAccount->name,
            'amount' => $numeric_value,
            'entry_date' => Carbon::now(),
            'document_file' => null,
            'company_id' => $companyId,
            'created_by_user_id' => $userId
        ]);
        
        // ========================================
        // 4. ATUALIZAR SALDOS
        // ========================================
        // Origem: diminui
        $fromAccount->decrement('current_balance', $numeric_value);
        
        // Destino: aumenta
        $toAccount->increment('current_balance', $numeric_value);
        
        // ========================================
        // 5. CRIAR transfer_details
        // ========================================
        TransferDetail::create([
            'transfer_group_id' => $transaction->uuid,
            'from_account_id' => $fromAccount->id, // 👈 Usar objeto
            'to_account_id' => $toAccount->id,     // 👈 Usar objeto
            'amount' => $numeric_value,
            'debit_entry_id' => $debitEntry->id,
            'credit_entry_id' => $creditEntry->id,
            'transfer_date' => Carbon::now(),
            'notes' => 'Transferência entre contas',
        ]);
        
        DB::commit();
        
        // Log de sucesso
        \Log::info("Transferência criada: {$fromAccount->name} → {$toAccount->name} | R$ {$numeric_value}");
        
        return response()->json([
            'title' => 'Sucesso',
            'message' => 'Transferência realizada com sucesso!',
            'status' => '200',
            'type' => 'success',
            'data' => [
                'transaction_id' => $transaction->id,
                'from_account' => $fromAccount->name,
                'to_account' => $toAccount->name,
                'amount' => 'R$ ' . number_format($numeric_value, 2, ',', '.'),
                'new_balance_from' => 'R$ ' . number_format($fromAccount->fresh()->current_balance, 2, ',', '.'),
                'new_balance_to' => 'R$ ' . number_format($toAccount->fresh()->current_balance, 2, ',', '.')
            ]
        ], 200);
        
    } catch (\Exception $e) {
        DB::rollBack();
        
        \Log::error('Erro ao criar transferência', [
            'message' => $e->getMessage(),
            'from' => $fromAccount->name ?? 'N/A',
            'to' => $toAccount->name ?? 'N/A',
            'amount' => $numeric_value ?? 'N/A'
        ]);
        
        return response()->json([
            'title' => 'Erro',
            'message' => 'Erro ao realizar transferência: ' . $e->getMessage(),
            'status' => '500',
            'type' => 'error'
        ], 500);
    }
    }
}
