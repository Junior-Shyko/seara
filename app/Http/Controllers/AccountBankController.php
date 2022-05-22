<?php

namespace Seara\Http\Controllers;

use Seara\Bank;
use Carbon\Carbon;
use Seara\AccountBank;
use Illuminate\Http\Request;
use Seara\Traits\ActionTable;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Seara\Repository\AccountBankRepository;
use Seara\Service\TypeAccountBank\GetTypeAccountBank;

class AccountBankController extends Controller
{
    use ActionTable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::all();
        $types = GetTypeAccountBank::getTyppeAccountBank();
        return view('accountBank.index', compact('types', 'banks'));
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
            unset($request['idAccontBank']);
            if(is_null($request['balance'])){
                $request['balance'] = 0 ;
            };
            AccountBank::create($request->all());
            return response()->json([
                'type' => 'success',
                'message' => 'Conta bancaria salva com sucesso'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'message' => 'Ocorreu um erro inesperado'
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
    public function update(Request $request, AccountBank $accountBank)
    {
        dd('update');
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

    public function getAccountBank()
    {
        //Relacionamento com as tabelas
        $accountBank = AccountBankRepository::getRelationAccountBank();
        $datatable = DataTables::of($accountBank);
        $datatable->addColumn('action', function ($account) {
            return $this->actionButtons($account->idAccountBank, [
                ['Editar conta', 'editAccountBank', 'fa fa-edit'],
                ['Excluir conta', 'archiveAccount', 'fa fa-trash', 'btn-danger']
            ]);
        });
        return $datatable->make(true);
    }


}
