<?php

namespace Seara\Http\Controllers;

use Carbon\Carbon;
use Seara\Transaction;
use Seara\AccountLaunch;
use Seara\FinancialEntry;
use Seara\Models\Company;
use Seara\Seara\Monetary;
use Illuminate\Support\Str;
use Seara\FinancialAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Seara\Repository\SettingsBoxRepository;
use Seara\Repository\AccountLaunchRepository;

class FinancialEntryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idCompany = Company::getIdCompany();
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
            'totalBanks', 'totalCash', 'totalGeneral', 'idCompany', 'company', 'accounts', 'accountsBussines'
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
       
        // Validação
        // $validated = $request->validate([
        //     'entries_id_account' => 'required|exists:account_launches,id',
        //     // 'account_id' => 'required|exists:financial_accounts,id',
        //     'type' => 'required|in:income,expense',
        //     'entries_description' => 'required|string|max:255',
        //     'entries_value' => 'required|numeric|min:0.01',
        //     'entries_date_launch' => 'required|date_format:d/m/Y',
        //     'document_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        // ], [
        //     'entries_id_account.required' => 'Selecione uma categoria',
        //     'entries_id_account.exists' => 'Categoria inválida',
        //     // 'account_id.required' => 'Selecione uma conta',
        //     // 'account_id.exists' => 'Conta inválida',
        //     'type.required' => 'Selecione o tipo (Receita ou Despesa)',
        //     'type.in' => 'Tipo inválido',
        //     'entries_description.required' => 'Descrição é obrigatória',
        //     'entries_value.required' => 'Valor é obrigatório',
        //     'entries_value.numeric' => 'Valor deve ser numérico',
        //     'entries_value.min' => 'Valor deve ser maior que zero',
        //     'entries_date_launch.required' => 'Data é obrigatória',
        //     'entries_date_launch.date_format' => 'Data deve estar no formato dd/mm/yyyy',
        //     'document_file.mimes' => 'Arquivo deve ser PDF, JPG, JPEG ou PNG',
        //     'document_file.max' => 'Arquivo não pode ultrapassar 2MB'
        // ]);
        
        $companyId = Company::getIdCompany();
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
                'account_id' => 1,
                'category_id' => $request->entries_id_account,
                'type' => $entryType,
                'description' => $request->entries_description,
                'amount' => $numeric_value,
                'entry_date' => $entryDate,
                'document_file' => $documentPath,
                'company_id' => $companyId,
                'created_by_user_id' => $userId
            ]);
            
            // 4. Atualizar saldo da conta
            // Buscando conta financeira por empresa
            $account = FinancialAccount::byCompany($companyId)->get();
             
            if ($entryType === 'credit') {
                $financialAccount = FinancialAccount::getbankInternal($request, $account);
                $financialAccount->increment('current_balance', $numeric_value);
            } else {
                $financialAccount = FinancialAccount::getbankInternal($request, $account);
                $financialAccount->decrement('current_balance', $numeric_value);
            }
           
            DB::commit();
            return response()->json([
                'message' => 'Conta lançada',
                'status' => 'success',
                'id' => $entry->id,
                'typeAccount' => $entryType
            ], 200);
            
            
        } catch (\Exception $e) {
            DB::rollBack();
            // dd([
            //     'message' => $e->getMessage(),
            //     'file' => $e->getFile(),
            //     'line' => $e->getLine(),
            //     'trace' => $e->getTraceAsString()
            // ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Seara\FinancialEntry  $financialEntry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FinancialEntry $financialEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Seara\FinancialEntry  $financialEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinancialEntry $financialEntry)
    {
        //
    }

    /**
     * DataTables - Retorna dados em JSON
     */
    public function datatable(Request $request)
    {
        $companyId = Company::getIdCompany();

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
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->betweenDates($request->start_date, $request->end_date);
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
        
        $btnUserRole = '<button class="btn btn-success btn-xs" type="button" title="Informação do Registro"
            data-toggle="modal"
            data-id="' . $mov->id . '"
            data-day="' . ($firstEntry ? $firstEntry->entry_date->day : '') . '"
            data-his="' . $mov->description . '"
            data-val="' . $mov->total_amount . '"
            data-target="#modalInfoLaunch">
            <i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>';

        if (Auth::user()->hasRole('user')) {
            return $btnUserRole;
        }

        $disabled = $mov->isTransfer() ? 'disabled' : '';

        return '<button class="btn btn-primary btn-xs ' . $disabled . '" type="button" title="Editar do Registro"
            data-toggle="modal"
            data-id="' . $mov->id . '"
            data-date="' . $dtLauch . '"
            data-his="' . $mov->description . '"
            data-val="' . $mov->total_amount . '"
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
                ->rawColumns(['type_badge', 'amount_formatted', 'action'])
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
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }


}
