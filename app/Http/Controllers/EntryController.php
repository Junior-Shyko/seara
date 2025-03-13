<?php

namespace Seara\Http\Controllers;

use Validator;
use Seara\Entry;
use Auth, DB, PDF;
use Carbon\Carbon;
use Seara\FileLaunch;
use Seara\AccountType;
use Seara\AccountLaunch;
use Seara\Models\Company;
use Seara\Seara\Monetary;
use Seara\FunctionGeneral;
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

class EntryController extends Controller
{
    use HasRoles;

    public function __construct()
    {
        $this->middleware('checkBox')->only(['store']);
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
        if(!$user->hasRole('superAdmin'))
        {
             //verifica se o id das empresas são iguais
            if($idCompany !== $user->user_id_company)
            {
                return redirect('/')->withErrors('Você não tem permissão de acesso.')->withInput();
            }
        }
        //TODAS CONTAS
        $accounts = AccountLaunch::get();
        //DADOS DA IGREJA COMPLETO
        $company = Company::getCompany($idCompany);
        // RETORNO DA SOMA DOS VALORES DO CAIXA BANCO
        $balanceBank = new AccountBankRepository();
        $generalBalnaceBank = $balanceBank->getBalanceBank($idCompany);

        // RETORNO DA SOMA DOS VALORES DO CAIXA BANCO
        $balanceInternal = new AccountInternalRepository();
        $interInternal = $balanceInternal->getInternalInternal($idCompany);
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
            
            if(!empty($request['idAccountBank']) || !is_null($request['idAccountBank'])){
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
            if($entry->entries_parent == 0 && $entry->entries_bank == 0)
            {
                $type = EntryRepository::typeAccount($entry->entries_id_account); 
                $entry->delete();
                return redirect()->back()->with('success', 'Lançamento Excluído com sucesso');

            }elseif(is_null($entry->entries_parent) && $entry->entries_bank > 0){
                //LANÇAMENTO DIRETO NA CONTA BANCARIA
                //CONSULTAR A CONTA E VERIFICAR SE É RECEITA OU DESPESA
                $type = EntryRepository::typeAccount($entry->entries_id_account); 
                //SE FOR RECEITA REDUZ O VALOR, SE FOR DESPESA AUMENTA O VALOR
                $alter = EntryRepository::alterBalanceEntry($type->account_types_name, $entry);
                if($alter->original['status'] == 200){
                    $entry->delete();
                    return redirect()->back()->with('success', 'Lançamento Excluído com sucesso');
                }
            }else{
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

                if (!file_exists($tmpFilePath)) {
                    mkdir($tmpFilePath, 777);
                }
                //Setup our new file path
                $newFilePath = "./img/images/" . $_FILES['file']['name'][$i];
                $ext = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);

                // //Upload the file into the temp dir
                $datetime = Carbon::now();
                $ext = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
                $newNameFile = base64_encode($datetime . '-' . $_FILES['file']['name'][$i]);
                $file = FileLaunch::insert([
                    'file_launches_name' => $newNameFile . '.' . $ext,
                    'file_launches_id_entry' => $request->idEntry,
                    'created_at' => $datetime,
                    'updated_at' => $datetime
                ]);
                move_uploaded_file($tmpFilePath, "./img/images/" . $newNameFile . '.' . $ext);
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
        if (isset($request->dtIni) && empty($request->dtIni)) {
            $startDate = Carbon::now();
            $dtIni = $startDate->startOfMonth();
        } elseif (!isset($request->dtIni)) {
            $startDate = Carbon::now();
            $dtIni = $startDate->startOfMonth();
        }
        if (isset($request->dtEnd) && empty($request->dtEnd)) {
            $endDate = Carbon::now();
            $dtEnd = $endDate->startOfMonth();
        } elseif (!isset($request->dtEnd)) {
            $endDate = Carbon::now();
            $dtEnd = $endDate->lastOfMonth();
        }
        // DB::enableQueryLog();
        $mov = Entry::join('users', 'entries.entries_id_user', '=', 'users.id')
            ->join('account_launches', 'entries.entries_id_account', '=', 'account_launches.id')
            ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
            // ->join('account_banks', 'entries.entries_bank', '=', 'account_banks.id')
            // ->join('banks', 'account_banks.bank_id', '=', 'banks.id')
            ->where('entries.entries_date_launch', '>=', $dtIni)
            ->where('entries.entries_date_launch', '<=', $dtEnd)
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
                // 'banks.name as nomeBanco'
            )
            ->orderBy('entries.entries_date_launch', 'asc')
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
                return  '<span>
                            <i class="fa '.$icon.' '.$badge.'" aria-hidden="true"></i> '
                            .$mov->account_types_name.
                        '</span>';
            })
            ->editColumn('entries_bank', function ($mov) {
                if($mov->entries_bank == 0)
                {
                    return 'Caixa Interno';
                }else{
                    return 'Caixa Banco';
                }
            })
            ->addColumn('action', function ($mov) {
                $dtLauch = Carbon::parse($mov->entries_date_launch)->format('d/m/Y');

                //botão da visualização de role User
                $btnUserRole = '<button class="btn btn-success btn-xs" type="button" title="Informação do Registro"
                data-toggle="modal"
                data-id="' . $mov->entries_id . '"
                data-day="' . $mov->entries_day . '"
                data-his="' . $mov->entries_description . '"
                data-val="' . $mov->entries_value . '"
                data-target="#modalInfoLaunch">
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>';

                if(Auth::user()->hasRole('user') ) {
                    return $btnUserRole;
                }
                //desabilitanco exclusao para lancamentos filhos
                $disabled = '';
                if($mov->entries_parent == -1){
                    $disabled = 'disabled';
                }
                $disabledTransfer = '';
                if($mov->transaction_id == 1){
                    $disabledTransfer = 'disabled';
                }
                //qualquer outro nivel de acesso
                return '<button class="btn btn-primary btn-xs '.$disabledTransfer.'" type="button" title="Editar do Registro"
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
                '.$btnUserRole.'
                <button class="btn btn-danger btn-xs" '.$disabled.' type="button" title="Excluir Registro"
                data-toggle="modal"
                data-id="' . $mov->entries_id . '"
                data-name="' . $mov->entries_description . '"
                data-parent="'. $mov->entries_parent .'"
                data-type="' . $mov->account_types_name . '"
                data-target="#modalDeleteComponent">
                <i class="fa fa-trash"></i></button>
                ';
            })
            ->rawColumns(['entries_description','entries_id_account', 'action'])
            ->make(true);
    }

    public function info($id)
    {
        $file = FileLaunch::where('file_launches_id_entry', $id)->get();

        if (count($file) > 0) {
            $info = Entry::join('account_launches', 'entries.entries_id_account', '=', 'account_launches.id')
                ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
                ->join('users', 'entries.entries_id_user', '=', 'users.id')
                ->join('file_launches', 'file_launches.file_launches_id_entry', '=', 'entries.entries_id')
                ->where('entries.entries_id', '=', $id)
                ->select('entries.*', 'file_launches.*', 'account_launches.*', 'account_types.id', 'account_types.account_types_name', 'entries.created_at as createEntry', 'users.name as nameUser', 'file_launches.created_at as createadFiles', 'file_launches.id as idFileLaunch')
                ->get();
        } else {
            $info = Entry::join('account_launches', 'entries.entries_id_account', '=', 'account_launches.id')
                ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
                ->join('users', 'entries.entries_id_user', '=', 'users.id')
                ->where('entries.entries_id', '=', $id)
                ->select('entries.*',  'account_launches.*', 'account_types.id', 'account_types.account_types_name', 'entries.entries_date_launch as createEntry', 'users.name as nameUser')->get();
        }

        return $info;
    }

    public function deleteFile(Request $request)
    {
        $file = FileLaunch::find($request->id);
        $file->delete();
        $filename = public_path('img/images/' . $file->file_launches_name);
        if (file_exists($filename)) {
            if (unlink($filename)) {
                return redirect()->back()->with('success', 'Arquivo Excluído com sucesso');
            }
        }
    }

    public function bank($idCompany)
    {
        return LaunchService::getBoxBank($idCompany);
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

    public function reportBox($dateInit, $dateEnd, $idCompany)
    {

        $dtinit = FunctionGeneral::DataBRtoMySQL(base64_decode($dateInit));
        $dtend  = FunctionGeneral::DataBRtoMySQL(base64_decode($dateEnd));
        $per    = Monetary::getValueBoxPerPeriodo($dtinit, $dtend, $idCompany);
        $total  = ($per['receitas'] - $per['despesas']);

        $perInitial = base64_decode($dateInit);
        $perEnd = base64_decode($dateEnd);
        //VALOR DO SALDO ANTERIOR
        $prevBalan = Monetary::previousBalance($dtinit, $idCompany);
        $previousBalance = ($prevBalan['receitas'] - $prevBalan['despesas']);

        $entries = Entry::join('companies', 'entries.entries_id_company', '=', 'companies.company_id')
            ->join('account_launches', 'entries.entries_id_account', '=', 'account_launches.id')
            ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
            ->where('entries_date_launch', '>=', $dtinit)
            ->where('entries_date_launch', '<=', $dtend)
            ->where('companies.company_id', '=', $idCompany)
            ->orderBy('entries_date_launch', 'asc')->get();
        //Se não tiver registro de lançamento, só cria um objeto company
        if(count($entries) == 0){
            $entries = Company::where('company_id',$idCompany)->get();
        }

        $balanceBank = new AccountBankRepository();
        $generalBalnaceBank = $balanceBank->getBalanceBank($idCompany);

        // RETORNO DA SOMA DOS VALORES DO CAIXA BANCO
        $balanceInternal = new AccountInternalRepository();
        $interInternal = $balanceInternal->getInternalInternal($idCompany);
        $balanceBank = ($generalBalnaceBank + $interInternal);
   
        $pdf = PDF::loadView('entry.report.perPeriod', compact('entries', 'perInitial', 'perEnd', 'total', 
        'previousBalance','balanceBank'));
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultPaperSize' =>  'a4'
        ]);
        
        //return $pdf->stream();
        //dd($entries);
        return view('entry.report.perPeriod', 
          compact('entries', 'perInitial', 'perEnd',  'total' , 'previousBalance','balanceBank'));
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
        
        if(isset($save->original['status']) && $save->original['status'] == 400) {
            return response()->json(['message' => 'error'] , 400);
        }

        return response()->json(['message' => 'success', 'value' => $save->original['value']] , 200);
    }

}