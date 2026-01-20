<?php

namespace Seara\Http\Controllers;

use Validator;
use Seara\Entry;
use Auth, DB, PDF, Storage;
use Carbon\Carbon;
use Seara\FileLaunch;
use Seara\AccountType;
use Seara\AccountLaunch;
use Seara\FinancialEntry;
use Seara\Models\Company;
use Seara\Seara\Monetary;
use Seara\FunctionGeneral;
use Seara\FinancialAccount;
use Illuminate\Http\Request;
use Seara\Relation_launch_bank;
use Seara\Repository\EntryRepository;
use Spatie\Permission\Traits\HasRoles;
use Seara\Service\Launch\LaunchService;
use Seara\Permission as SearaPermission;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Seara\Repository\AccountBankRepository;
use GuzzleHttp\Exception\BadResponseException;
use Seara\Repository\AccountInternalRepository;
use function count;
use function dd;

class EntryController extends Controller
{
    use HasRoles;

    public function __construct()
    {
        // $this->middleware('checkBox')->only(['store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $idCompany = Auth::user()->user_id_company;
        if (app('request')->input('company') !== null) {
            $idCompany = intval(app('request')->input('company'));
        }
        //CASO O USUARIO NÃO SEJA UM SUPER ADMIN, ENTRA NA CONDIÇÃO PARA VERIFICAÇÃO
        if (!$user->hasRole('superAdmin')) {
            //verifica se o id das empresas são iguais
            if ($idCompany !== $user->user_id_company) {
                return redirect('/')->withErrors('Você não tem permissão de acesso.')->withInput();
            }
        }
        //TODAS CONTAS
        $accounts = AccountLaunch::get();
        $accounts = FinancialAccount::byCompany($idCompany)->get();

        //DADOS DA IGREJA COMPLETO
        $company = Company::getCompany($idCompany);
        // RETORNO DA SOMA DOS VALORES DO CAIXA BANCO
        $balanceBank = new AccountBankRepository();
        $generalBalnaceBank = $balanceBank->getBalanceBank($idCompany);
        // RETORNO DA SOMA DOS VALORES DO CAIXA BANCO
        $balanceInternal = new AccountInternalRepository();
        $interInternal = $balanceInternal->getInternalInternal($idCompany);
        // Valor total do caixa banco + caixa interno
        $balanceGeneral = ($generalBalnaceBank + $interInternal);
        //VERIFICANDO AUTORIZAÇÃO
        $entry = Entry::where('entries_id_company', $idCompany)->get();
        //todas as contas bancarias
        $accountBank = AccountBankRepository::getAccountBankAndTypeToCompany($idCompany);
        return view('entry.index', compact(
            'accounts',
            'interInternal',
            'company',
            'generalBalnaceBank',
            'balanceGeneral',
            'accountBank',
            'idCompany',
            'entry',
            'user'
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validando as datas permitidas
        $dateValid = EntryRepository::verifyLastDayMounth($request);
        $res = json_decode($dateValid->getContent(), true);

        if ($dateValid->getStatusCode() !== 200) {
            return response([
                'status' => 'error',
                'message' => $res['error']
            ], 422);
        }

        $rules = [
            'entries_description' => 'required',
            'entries_id_account' => 'required',
            'entries_value' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $validator->errors()->all();
            return response(['status' => 'error', 'message' => "Todos os campos são obrigatórios"], 422);
        }

        $date_launch = FunctionGeneral::DataBRtoMySQL($request->entries_date_launch);
        $request['entries_date_launch'] = $date_launch;

        $date_launch = FunctionGeneral::DataBRtoMySQL($request->entries_date_launch);
        //Data do lançamento
        $request['entries_date_launch'] = $request->entries_date_launch;
        try {
            //por padrão 
            $request['entries_bank'] = 0;
            $reques = Monetary::money_real($request['entries_value']);
            $request['entries_value'] = $reques;
            //recebendo o id do registro da conta bancária

            if (!empty($request['idAccountBank']) || !is_null($request['idAccountBank'])) {
                $request['entries_bank'] = $request['idAccountBank'];
            }

            $entry = Entry::create($request->all());
            $name = AccountType::getNameType($request['entries_id_account']);
            return response()->json([
                'message' => 'Conta lançada',
                'status' => 'success',
                'id' => $entry->entries_id,
                'typeAccount' => $name
            ], 200);
        } catch (BadResponseException $e) {
            dump($e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $launch =  Entry::join('account_launches', 'entries.entries_id_account', '=', 'account_launches.id')
            ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
            ->join('users', 'entries.entries_id_user', '=', 'users.id')
            ->where('entries.entries_id', '=', $id)
            ->select('entries.*', 'account_launches.*', 'account_types.id', 'account_types.account_types_name', 'entries.created_at as createEntry', 'users.name as nameUser')
            ->get();

        $files = FileLaunch::where('file_launches_id_entry', '=', $id)->get();
        $accounts = AccountLaunch::get();
        return view('entry.edit', compact('id', 'launch', 'files', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $val = Monetary::money_real($request['entries_value']);
        $request['entries_value'] = $val;
        $rules = [
            'entries_description' => 'required',
            'entries_id_account' => 'required',
            'entries_value' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $validator->errors()->all();
            return response(['status' => 'error', 'message' => "Todos os campos são obrigatórios"], 422);
        }
        $date_launch = FunctionGeneral::DataBRtoMySQL($request['entries_date_launch']);
        $request['entries_date_launch'] = $date_launch;

        $input = $request->all();
        $input = $request->except('_method', '_token');
        try {

            Entry::where('entries_id', $id)->update($input);
            return response()->json(['message' => 'success'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'error'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Excluindo os arquivo do lançamento
        EntryRepository::deleteFile($request->id);
        try {
            //Instanciando o lançamento
            $entry = Entry::where('entries_id', $request->id)->first();
            //LANÇAMENTO DIRETO NO CAIXA INTERNO
            if ($entry->entries_parent == 0 && $entry->entries_bank == 0) {
                $type = EntryRepository::typeAccount($entry->entries_id_account);
                $entry->delete();
                return redirect()->back()->with('success', 'Lançamento Excluído com sucesso');
            } elseif (is_null($entry->entries_parent) && $entry->entries_bank > 0) {
                //LANÇAMENTO DIRETO NA CONTA BANCARIA
                //CONSULTAR A CONTA E VERIFICAR SE É RECEITA OU DESPESA
                $type = EntryRepository::typeAccount($entry->entries_id_account);
                //SE FOR RECEITA REDUZ O VALOR, SE FOR DESPESA AUMENTA O VALOR
                $alter = EntryRepository::alterBalanceEntry($type->account_types_name, $entry);
                if ($alter->original['status'] == 200) {
                    $entry->delete();
                    return redirect()->back()->with('success', 'Lançamento Excluído com sucesso');
                }
            } else {
                // LANÇAMENTO DE TRANFERENCIA
                //                $accountBank = AccountBank::find($entry->entries_bank);
                //                //reduzindo o valor da conta
                //                $accountBank->balance += $entry->entries_value;//remove valor da conta bancaria
                //                $accountBank->save();

                //EXCLUINDO O REGISTRO DE LANÇAMENTO FILHO
                $entriesChild = Relation_launch_bank::where('entries_child', $request->id)->first();

                $entriesParent = Entry::find($entriesChild->entries_parent);
                //excluindo o lançamentos
                $entriesParent->delete();
                $entry->delete();
                return redirect()->back()->with('success', 'Lançamento Excluído com sucesso');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro!');
        }
    }

    public function upload(Request $request)
    {
        $user = Auth::user();
        $total = count($_FILES['file']['name']);
        $totalFile = 0;
        $uploadSuccess = false;
        // // Loop through each file
        for ($i = 0; $i < ($total); $i++) {
            $totalFile++;
            //Get the temp file path
            $tmpFilePath = $_FILES['file']['tmp_name'][$i];

            //Make sure we have a file path
            if ($tmpFilePath != "") {
                $ext = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
                $datetime = Carbon::now();
                $newNameFile = base64_encode($datetime . '-' . $_FILES['file']['name'][$i]);
                $fileName = $newNameFile . '.' . $ext;

                $fileData = [
                    'file_launches_name' => $fileName,
                    'created_at' => $datetime,
                    'updated_at' => $datetime
                ];

                // Novos uploads usam transaction_id
                if ($request->filled('transactionId')) {
                    $fileData['transaction_id'] = $request->transactionId;
                } else {
                    // Fallback para compatibilidade com uploads antigos
                    $fileData['file_launches_id_entry'] = $request->idEntry;
                }

                $file = FileLaunch::insert($fileData);
                Storage::disk('public')->put('images/' . $fileName, file_get_contents($tmpFilePath));
                if ($file) {
                    $uploadSuccess = true;
                }
            }
        }
        // die;
        if ($uploadSuccess) {
            return response()->json(['message' => 'Arquivo enviado com sucesso', 'status' => 'success'], 200);
            // return redirect()->back()->with('success' , 'Upload alterado com sucesso');
        } else {
            return response()->json(['message' => 'Ocorreu um erro inesperado, tente novamente mais tarde', 'status' => 'error'], 500);
            // return redirect()->back()->with('Error' , 'Ocorreu um erro inesperado, tente novamente mais tarde');
        }
    }

    public function getAll(Request $request, $idCompany)
    {
        $dtIni = $request->dtIni;
        $dtEnd = $request->dtEnd;

        // Configuração das datas padrão
        if (empty($request->dtIni) || !isset($request->dtIni)) {
            $startDate = Carbon::now();
            $dtIni = $startDate->startOfMonth();
        }

        if (empty($request->dtEnd) || !isset($request->dtEnd)) {
            $endDate = Carbon::now();
            $dtEnd = $endDate->lastOfMonth();
        }

        // Construção da query base
        $query = Entry::join('users', 'entries.entries_id_user', '=', 'users.id')
            ->join('account_launches', 'entries.entries_id_account', '=', 'account_launches.id')
            ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
            ->where('entries.entries_id_company', '=', $idCompany)
            ->select(
                'users.id as idUser',
                'users.name',
                'entries.*',
                'account_types.*',
                'account_launches.accountlaunch_type',
                'account_types.account_types_name',
                'account_launches.id as idAccontLaunch',
                'account_launches.accountlaunch_name'
            );

        // Adicionar condições de data apenas se ambas existirem
        if (!empty($request->dtIni) && !empty($request->dtEnd)) {
            $query->where('entries.entries_date_launch', '>=', $dtIni)
                ->where('entries.entries_date_launch', '<=', $dtEnd);
        }

        // Executar a query com ordenação
        $mov = $query->orderBy('entries.entries_date_launch', 'desc')
            ->get();
        return DataTables::of($mov)->addIndexColumn()
            ->editColumn('entries_date_launch', function ($mov) {
                $date = new Carbon($mov->entries_date_launch);
                return $date->format('d/m/Y');
            })
            ->editColumn('entries_id_user', function ($mov) {
                return $mov->name;
            })
            ->editColumn('entries_value', function ($mov) {
                return number_format($mov->entries_value, 2, ',', '.');
            })
            ->editColumn('entries_id_account', function ($mov) {
                $badge = '';
                $icon = '';
                switch ($mov->account_types_name) {
                    case "Receita":
                        $badge = 'text-success';
                        $icon = 'fa-check-square';
                        break;
                    case "Despesa":
                        $badge = 'text-danger';
                        $icon = 'fa-times';
                        break;
                    case "Transferência":
                        $badge = 'text-primary';
                        $icon = 'fa-retweet';
                        break;
                }
                return '<span>
                        <i class="fa ' . $icon . ' ' . $badge . '" aria-hidden="true"></i> '
                    . $mov->account_types_name .
                    '</span>';
            })
            ->editColumn('entries_bank', function ($mov) {
                return $mov->entries_bank == 0 ? 'Caixa Interno' : 'Caixa Banco';
            })
            ->addColumn('action', function ($mov) {
                $dtLauch = Carbon::parse($mov->entries_date_launch)->format('d/m/Y');
                $btnUserRole = '<button class="btn btn-success btn-xs" type="button" title="Informação do Registro"
                data-toggle="modal"
                data-id="' . $mov->entries_id . '"
                data-day="' . $mov->entries_day . '"
                data-his="' . $mov->entries_description . '"
                data-val="' . $mov->entries_value . '"
                data-target="#modalInfoLaunch">
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>';

                if (Auth::user()->hasRole('user')) {
                    return $btnUserRole;
                }

                $disabled = $mov->entries_parent == -1 ? 'disabled' : '';
                $disabledTransfer = $mov->transaction_id == 1 ? 'disabled' : '';

                return '<button class="btn btn-primary btn-xs ' . $disabledTransfer . '" type="button" title="Editar do Registro"
                data-toggle="modal"
                data-id="' . $mov->entries_id . '"
                data-date="' . $dtLauch . '"
                data-his="' . $mov->entries_description . '"
                data-val="' . $mov->entries_value . '"
                data-typ="' . $mov->account_types_name . '"
                data-idlau="' . $mov->idAccontLaunch . '"
                data-namel="' . $mov->accountlaunch_name . '"
                data-target="#modalEditLauch">
                <i class="fa fa-edit" aria-hidden="true"></i></button>
                ' . $btnUserRole . '
                <button class="btn btn-danger btn-xs" ' . $disabled . ' type="button" title="Excluir Registro"
                data-toggle="modal"
                data-id="' . $mov->entries_id . '"
                data-name="' . $mov->entries_description . '"
                data-parent="' . $mov->entries_parent . '"
                data-type="' . $mov->account_types_name . '"
                data-target="#modalDeleteComponent">
                <i class="fa fa-trash"></i></button>';
            })
            ->rawColumns(['entries_description', 'entries_id_account', 'action'])
            ->make(true);
    }

    public function info(Request $request)
    {
        // Data de corte: antes = entries, depois = financial_entries com transaction_id
        $dateFile = new Carbon('2025-12-02');

        // Primeiro, tentar buscar na tabela entries (registros antigos)
        $entries = EntryRepository::getFiles($request);
        if ($entries->count() > 0 && $entries->first()->entries_date_launch <= $dateFile) {
            return FileLaunch::where('file_launches_id_entry', $entries->first()->entries_id)->get();
        }

        // Buscar na tabela financial_entries (registros novos)
        $financialEntries = FinancialEntry::where([
            'description' => $request->desc,
            'amount' => FunctionGeneral::converterStringToFloat($request->value),
            'entry_date' => FunctionGeneral::DataBRtoMySQL($request->date),
            'company_id' => (int) $request->comp
        ])->get();

        $files = [];
        foreach ($financialEntries as $financialEntry) {
            // Primeiro tenta buscar por transaction_id (novos uploads)
            $transactionFiles = FileLaunch::where('transaction_id', $financialEntry->transaction_id)->get();

            if ($transactionFiles->count() > 0) {
                foreach ($transactionFiles as $file) {
                    $files[] = $file;
                }
            } else {
                // Fallback: buscar por file_launches_id_entry (uploads antigos pós-migração)
                $legacyFiles = FileLaunch::where('file_launches_id_entry', $financialEntry->id)
                    ->where('created_at', '>', $dateFile)
                    ->get();

                foreach ($legacyFiles as $file) {
                    $files[] = $file;
                }
            }
        }

        return $files;
    }

    public function deleteFile(Request $request)
    {
        $file = FileLaunch::find($request->id);
        $file->delete();
        $storagePath = 'images/' . $file->file_launches_name;
        if (Storage::disk('public')->exists($storagePath)) {
            Storage::disk('public')->delete($storagePath);
        }
        return redirect()->back()->with('success', 'Arquivo Excluído com sucesso');
    }

    public function bank($idCompany)
    {
        return FinancialAccount::byCompany($idCompany)
            ->banks()
            ->sum('current_balance');
    }

    public function internal($idCompany)
    {
        $internal = LaunchService::getBoxInternal($idCompany);
        return response()->json($internal);
    }

    public function general($idCompany)
    {
        //SALDO DO CAIXA INTERNO
        // $internal = LaunchService::getBoxInternal($idCompany);
        // //SALDO GERAL
        // $balanceBank = new AccountBankRepository();
        // $generalBalnaceBank = $balanceBank->getBalance($idCompany);
        // $balanceGeneral = ($internal + $generalBalnaceBank);
        return 0;
    }

    public function reportBox(Request $request, $dateInit = null, $dateEnd = null, $idCompany = null)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);
        $dateInit  = $request->route('dateInit');
        $dateEnd   = $request->route('dateEnd');
        $idCompany = $request->route('idCompany');
        $perInitial = null;
        $perEnd = null;

        // Processa e valida as datas do período
        $dtInitialConverted = null;
        $dtEndConverted = null;
        if ($dateInit && $dateEnd) {
            $perInitial = base64_decode($dateInit);
            $perEnd = base64_decode($dateEnd);

            $dtInitialConverted = FunctionGeneral::convertTwoDigitYearToFourDateBR($perInitial);
            $dtEndConverted = FunctionGeneral::convertTwoDigitYearToFourDateBR($perEnd);

            // Se alguma conversão falhar, ignora o filtro de datas
            if (!$dtInitialConverted || !$dtEndConverted) {
                $dtInitialConverted = null;
                $dtEndConverted = null;
            }
        }

        // Constrói a query base
        $query = FinancialEntry::query();

        // Filtra por empresa se fornecido
        if ($idCompany) {
            $query->where('company_id', $idCompany);
        }

        // Filtra por intervalo de datas apenas se válido
        if ($dtInitialConverted && $dtEndConverted) {
            $query->whereBetween('entry_date', [$dtInitialConverted, $dtEndConverted]);
        }

        // Ordena e busca as entradas
        $entries = $query->orderBy('entry_date', 'asc')->get();

        // Calcula o saldo anterior (apenas se houver período válido e empresa)
        $priorBalance = $this->calculatePriorBalance($idCompany, $dtInitialConverted);
        
        // Calcula totais de créditos e débitos, e o saldo acumulado
        [$totalCredits, $totalDebits, $entries] = $this->calculateTotalsAndRunningBalance($entries, $priorBalance);

        // Busca a empresa se aplicável
        $company = $idCompany ? Company::getCompany($idCompany) : null;
        return view('report.financial.box',
            compact('entries', 'company',
                'perInitial', 'perEnd', 'priorBalance', 'totalCredits', 'totalDebits'));
    }

    /**
     * Calcula o saldo anterior ao período inicial, somando créditos e subtraindo débitos antes da data.
     *
     * @param int|null $idCompany
     * @param string|null $dtInitialConverted
     * @return float
     */
    private function calculatePriorBalance($idCompany, $dtInitialConverted): float
    {
        if (!$idCompany || !$dtInitialConverted) {
            return 0; // Sem período ou empresa, saldo anterior é zero
        }

        $priorEntries = FinancialEntry::where('company_id', $idCompany)
            ->where('entry_date', '<', $dtInitialConverted)
            ->selectRaw("SUM(CASE WHEN type = 'credit' THEN amount ELSE 0 END) - SUM(CASE WHEN type = 'debit' THEN amount ELSE 0 END) as prior_balance")
            ->first();

        return $priorEntries->prior_balance ?? 0;
    }

    /**
     * Calcula totais de créditos/débitos e adiciona o saldo acumulado a cada entrada.
     *
     * @param Collection $entries
     * @param float $priorBalance
     * @return array [totalCredits, totalDebits, entries com running_balance]
     */
    private function calculateTotalsAndRunningBalance($entries, float $priorBalance): array
    {
        $totalCredits = 0;
        $totalDebits = 0;
        $runningBalance = $priorBalance;

        foreach ($entries as $entry) {
            if ($entry->type === 'credit') {
                $runningBalance += $entry->amount;
                $totalCredits += $entry->amount;
            } elseif ($entry->type === 'debit') {
                $runningBalance -= $entry->amount;
                $totalDebits += $entry->amount;
            }
            $entry->running_balance = $runningBalance; // Atributo temporário para saldo acumulado
        }

        return [$totalCredits, $totalDebits, $entries];
    }
    /**
     * Retorno para modal de edição de lançamento
     *
     * @return void
     */
    public function showApi($id)
    {
        $launch =  Entry::join('account_launches', 'entries.entries_id_account', '=', 'account_launches.id')
            ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
            ->join('users', 'entries.entries_id_user', '=', 'users.id')
            ->where('entries.entries_id', '=', $id)
            ->select('entries.*', 'account_launches.*', 'account_types.id', 'account_types.account_types_name', 'entries.created_at as createEntry', 'users.name as nameUser')
            ->get();
        return $launch;
    }

    /**
     * Excluir arquivos
     */
    public function deleteFilesLaunch(Request $request)
    {
        foreach ($request->checkFilesLaunch as $key => $value) {
            $fil = FileLaunch::where('id', $value)->delete();
        }
        if ($fil) {
            return response()->json(['message' => 'success', 'status' => 200], 200);
        } else {
            return response()->json(['message' => 'Ocorreu um erro inexperado'], 500);
        }
    }

    public function allLauch()
    {
        return view('entry.all');
    }

    public function alterValueLauch(Request $request)
    {
        $alterValur = new AccountBankRepository;
        $save = $alterValur->updateAccountToLauch($request->all());

        if (isset($save->original['status']) && $save->original['status'] == 400) {
            return response()->json(['message' => 'error'], 400);
        }

        return response()->json(['message' => 'success', 'value' => $save->original['value']], 200);
    }
}
