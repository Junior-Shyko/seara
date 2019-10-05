<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Requests\StoreAccount;
use App\Service\Financing\Account\CreateAccount;
use App\Traits\ActionTable;
use Carbon\Carbon;
use Datatables;
use Illuminate\Http\Request;
use DB;
use Throwable;

class AccountController extends Controller
{
    use ActionTable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('financing.account.index');
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
     * @param StoreAccount $request
     * @param CreateAccount $createAccount
     * @return void
     * @throws Throwable
     */
    public function store(StoreAccount $request, CreateAccount $createAccount)
    {
        try {
            DB::transaction(function () use ($request, $createAccount) {
                $createAccount->execute($request->all());
            });
            return response()->json([
                'status' => 'success',
                'message' => 'Conta salva com sucesso'
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível salvar a conta, tente novamente'
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function dataTable()
    {
        $query = DB::table('account')->select();
        $datatable = Datatables::of($query);

        $datatable->addColumn('balance', function () {
            return 0.00;
        });

        $datatable->addColumn('action', function ($account) {
            return $this->actionButtons($account->id, [
                ['Editar conta', 'editAccount', 'fa fa-pencil'],
                ['Arquivar conta', 'archiveAccount', 'fa fa-ban', 'btn-danger']
            ]);
        });

        $datatable->editColumn(
            'created_at',
            function($account) {
                $created_at = new Carbon($account->created_at);
                return $created_at->format('d/m/Y à\s H:i:s');
            }
        );

        $datatable->editColumn('type', function ($account) {
            switch ($account->type) {
                case 'money':
                    return 'Dinheiro';
                case 'checking_account':
                    return 'Conta corrente';
                case 'investment':
                    return 'Investimento';
                default:
                    return 'Outro';
            }
        });

        return $datatable->make(true);
    }
}
