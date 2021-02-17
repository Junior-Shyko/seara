<?php

namespace App\Http\Controllers;

use App\AccountLaunch;
use Illuminate\Http\Request;
use Datatables, DB;
use Carbon\Carbon;

class AccountLaunchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('launch.index');
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
        if(empty($request['accountlaunch_type']) || empty($request['accountlaunch_name'])) {
            return response( ['status' => 'error', 'message' => 'Todos os campos são obrigatórios'], 422 );
        }
        try {
            AccountLaunch::create($request->all());
            return response( ['status' => 'success', 'message' => 'Conta cadastrada com sucesso'], 200 );
        } catch (\Throwable $th) {
            //throw ;
            dump($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AccountLaunch  $accountLaunch
     * @return \Illuminate\Http\Response
     */
    public function show(AccountLaunch $accountLaunch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AccountLaunch  $accountLaunch
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountLaunch $accountLaunch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AccountLaunch  $accountLaunch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, AccountLaunch $accountLaunch)
    {
        try {
            $launch = AccountLaunch::find($id);
            $launch->update($request->all());
            return response()->json([
                        'status' => 'success',
                        'message' => 'Conta alterada com sucesso',
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro inesperado',
            ],500);
        }
        // $launch = $accountLaunch->update($request->all());
        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Conta salva com sucesso',
        //     ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $_REQUEST
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       $deleteAccount = AccountLaunch::find($request->id);
       try {
        $deleteAccount->delete();
        return redirect()->back()->with('success' , 'Conta Excluida com sucesso.');
       } catch (\Throwable $th) {
        return redirect()->back()->with('error' , 'Não deu para excluir essa conta, tente novamente mais tarde.');
       }
    }

    public function getDataTable() {
        //$accountLaunch = AccountLaunch::get();
        $accountLaunch = DB::table('account_launches')
        ->join('users', 'account_launches.accountlaunch_id_user', '=', 'users.id')
        ->select('account_launches.*', 'users.id as id_user', 'users.name')
        ->get();

        return Datatables::of($accountLaunch)
        ->editColumn('accountlaunch_type', function ($accountLaunch) {
            $type = "";
            if($accountLaunch->accountlaunch_type == 1){
                return "Receita";
            }else{
                return "Despesa";
            }
        })
        ->editColumn('accountlaunch_id_user', function ($accountLaunch) {
            return $accountLaunch->name;
        })
        ->editColumn('created_at', function ($accountLaunch) {
            $created_at = new Carbon( $accountLaunch->created_at );
              return $created_at->format('d/m/Y á\s H:i:s');
        })
        ->editColumn('accountlaunch_history', function ($accountLaunch) {
            return strtr($accountLaunch->accountlaunch_history, 0, 20);
        })
        ->addColumn('action', function ($accountLaunch) {
            return '<button class="btn btn-primary" type="button" title="Editar esse registro" data-toggle="modal"
            data-id="'.$accountLaunch->id.'"
            data-name="'.$accountLaunch->accountlaunch_name.'"
            data-type="'.$accountLaunch->accountlaunch_type.'"
            data-history="'.$accountLaunch->accountlaunch_history.'"
            data-target="#modalEditAccountLaunch"><i class="fa fa-edit"></i> Editar</button>
                    <button class="btn btn-danger" type="button" title="Excluir esse registro" 
            data-toggle="modal"
            data-id="'.$accountLaunch->id.'"
            data-name="'.$accountLaunch->accountlaunch_name.'"
            data-type="'.$accountLaunch->accountlaunch_type.'"
            data-target="#modalDeleteComponent">
                    <i class="fa fa-trash"> Excluir</i>
                    </button>';
        })->make(true);
    }

    public function search($id) {
        try {
            $account = AccountLaunch::findOrFail($id);
            return response()->json($account);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
