<?php

namespace Seara\Http\Controllers;

use Seara\Bank;
use Seara\Entry;
use Carbon\Carbon;
use Seara\AccountBank;
use Seara\Models\Company;
use Seara\Seara\Monetary;
use Illuminate\Http\Request;
use Seara\Traits\ActionTable;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Seara\Repository\BankRepository;
use Seara\Service\Launch\CreateLaunch;
use Seara\Permission as SearaPermission;
use Spatie\Permission\Models\Permission;
use Seara\Repository\AccountBankRepository;
use Seara\Service\TypeAccountBank\GetTypeAccountBank;

class AccountBankController extends Controller
{
    use ActionTable;
    const ENTRY = 1;
    const TRANSFER = 2;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //user atual logado é superAdmin?
        //se nao for, ele é da igreja do caixa?
        $user = Auth::user();
        $idCompany = $user->user_id_company;
        if (app('request')->input('company') !== null) {
            $idCompany = intval(app('request')->input('company'));
        }
        //Retorna todos os lançamentos dessa igreja
        AccountBankRepository::getAllAccountBankCompany($idCompany);
        //se tiver permissão ou acesso, então renderiza a view
        if(Auth::user()->hasRole('superAdmin') || $idCompany == Auth::user()->user_id_company ) {
           //DADOS DA IGREJA COMPLETO
           $company    = Company::getCompany($idCompany);
           $banks      = Bank::all();
           $types      = GetTypeAccountBank::getTyppeAccountBank();
           return view('accountBank.index', compact('types', 'banks', 'company'));
        }
 
        //Retorna aviso 
        return redirect('/')->with('error', 'Ops! Você não tem permissão para acessar essa página.');
        
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
        try {
            // unset($request['idAccontBank']);
            $request->request->remove('idAccontBank');
            if(is_null($request['balance'])){
                $request['balance'] = 0 ;
            };
            $balance = Monetary::money_real($request->balance);
            $request['balance'] = $balance;
            //dd($request->all());
            AccountBank::insert($request->all());
            return response()->json([
                'type' => 'success',
                'message' => 'Conta bancaria salva com sucesso'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'message' => 'Ocorreu um erro inesperado : '.$th->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Seara\AccountBank  $accountBank
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $accountBank = AccountBank::findOrFail($id);
            return response()->json($accountBank);
        } catch (\Exception $th) {
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Seara\AccountBank  $accountBank
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountBank $accountBank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Seara\AccountBank  $accountBank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //formatando o valor para ser salvo no banco
        $balance = Monetary::DataBRtoMySQL($request->balance);
        $request['balance'] = $balance;
        try {
            $account = AccountBankRepository::update($request->all());
            if($account)
                return response()->json(['message' => 'Conta bancaria alterada com sucesso', 'type' => 'success','status' => 200], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Seara\AccountBank  $accountBank
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            AccountBank::find($id)->delete();
            return response()->json(['message' => 'Conta bancaria excluida com sucesso', 'type' => 'success','status' => 200], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocorreu um erro : '.$th->getMessage(), 'type' => 'error','status' => 400], 400);
        }
    }

    public function getAccountBank($idCompany)
    {
        // //Retorna todos os lançamentos dessa igreja
        $accountBank = AccountBankRepository::getAccountBankAndTypeToCompany($idCompany);
        $datatable = DataTables::of($accountBank);
        $datatable->editColumn('balance', function($accountBank) {
                return number_format($accountBank->balance, 2, ',', '.');
            }
        );
        $datatable->addColumn('action', function ($account) {
            if(Auth::user()->hasRole('superAdmin|admin') ) {
                return $this->actionButtons($account->idAccountBank, [
                    ['Editar conta', 'editAccountBank', 'fa fa-edit'],
                    ['Excluir conta', 'archiveAccount', 'fa fa-trash', 'btn-danger']
                ]);
            }
           
        });
        return $datatable->make(true);
    }

    public function getInfoAccountBank($id)
    {
        $accountBank = AccountBankRepository::getInfoAccountBank($id);
        return response()->json($accountBank);
    }

    public function actionTransfer(Request $request)
    {
        $typeEntry = 0;
        $request['transaction_id'] == 1 ? $typeEntry = AccountBankController::ENTRY : $typeEntry = AccountBankController::TRANSFER;
        //PASSANDO O VALOR DA TRANSFERENCIA E O VALOR ATUAL DA DETERMINADA CONTA
        $transfer = AccountBankRepository::transfer($request->all());
       
        if($transfer->getStatusCode() == 400)
            return response()->json([
                'type' => 'error',
                'message' => $transfer->getData()->message
            ]);

        /**
         * ESSA CONDIÇÃO É QUANDO É UMA TRANSFERENCIA DO CAIXA PARA BANCO
         */
        if($typeEntry == 2 && $request['idAccountEnd'] == 0)
        {
            $launch = AccountBankRepository::fieldsEntry($request->all(), 'transferencia');
            CreateLaunch::create($launch);    
            //LANÇAMENTO DE RECEITA
            $launch2 = AccountBankRepository::fieldsEntry($request->all(), 'despesa');
            CreateLaunch::create($launch2);
        }
        //SE FOR TRANSFERENCIA DO BANCO PARA O CAIXA INTERNO
        elseif($typeEntry == 2 && $request['idAccountEnd'] > 0){
           if($request['bank_to_bank'] == "true")
           {
                $launch = AccountBankRepository::fieldsEntry($request->all(), 'transferencia');
                CreateLaunch::create($launch);    
                //LANÇAMENTO DE RECEITA
                $launch2 = AccountBankRepository::fieldsEntry($request->all(), 'transferencia');
                CreateLaunch::create($launch2);
           }elseif($request['bank_to_bank'] == "false"){
                $launch = AccountBankRepository::fieldsEntry($request->all(), 'receita');
                CreateLaunch::create($launch);    
                //LANÇAMENTO DE RECEITA
                $launch2 = AccountBankRepository::fieldsEntry($request->all(), 'transferencia');
                CreateLaunch::create($launch2);
           }
        }else{
            //LANCAMENTO DE DESPESA
            $launch = AccountBankRepository::fieldsEntry($request->all(), 'despesa');
            CreateLaunch::create($launch);    
            //LANÇAMENTO DE RECEITA
            $launch2 = AccountBankRepository::fieldsEntry($request->all(), 'receita');
            CreateLaunch::create($launch2);
        }   
       
        if($transfer)
            return response()->json(['message' => 'Transferência realizada com sucesso', 'type' => 'success','status' => 200], 200);
        else
            return response()->json(['message' => 'Ocorreu um erro : ', 'type' => 'error','status' => 400], 400);
    }
}