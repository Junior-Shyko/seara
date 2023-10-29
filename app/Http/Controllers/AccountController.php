<?php

namespace Seara\Http\Controllers;

use DB;
use Throwable;
use DataTables;
use Carbon\Carbon;
use Seara\AccountLaunch;
use Illuminate\Http\Response;
use Seara\Traits\ActionTable;
use Illuminate\Http\JsonResponse;
use Seara\Account;
use Seara\Http\Requests\StoreAccount;
use Seara\Http\Requests\UpdateAccountRequest;
use Seara\Service\Financing\Account\CreateAccount;
use Seara\Service\Financing\Account\ArchiveAccount;
use Seara\Service\Financing\Account\AccountRepository;

class AccountController extends Controller
{
    use ActionTable;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('financing.account.index');
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
     * @param int $id
     * @param AccountRepository $accountRepository
     * @return JsonResponse
     */
    public function show($id, AccountRepository $accountRepository)
    {
        $account = $accountRepository->find($id)->jsonSerialize();
        return response()->json($account);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAccountRequest $request
     * @param int $id
     * @param AccountRepository $repository
     * @return void
     */
    public function update(UpdateAccountRequest $request, $id, AccountRepository $repository)
    {
        try {
            $repository->update($id, $request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Conta salva com sucesso',
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível atualizar conta, tente novamente'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @param ArchiveAccount $archiveAccount
     * @return void
     */
    public function destroy($id, ArchiveAccount $archiveAccount)
    {
        try {
            DB::transaction(function () use ($id, $archiveAccount) {
                $archiveAccount->execute($id);
            });
            return response()->json([
                'status' => 'success',
                'message' => 'Conta arquivada com sucesso'
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível arquivar a conta, tente novamente'
            ]);
        }
    }

    public function dataTable()
    {
        $query = DB::table('account')
            ->select()
            ->whereNull('archived_at');

        $datatable = DataTables::of($query);

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

    public function reportAccount()
    {
         //TODAS CONTAS
         $accounts = AccountLaunch::get();
        return view('report.account.index', compact('accounts'));
    }

    public function getReportAccount($company_id)
    {
        // dump($company_id);
        $accountGroup = AccountLaunch::join('entries', 'account_launches.id' , '=', 'entries.entries_id_account')
                            ->where('entries.entries_id_company',$company_id)
                            ->groupBy('entries.entries_id_account')->get();
        $AccountLaunch = AccountLaunch::join('entries', 'account_launches.id' , '=', 'entries.entries_id_account')
                            ->join('users', 'entries.entries_id_user', '=', 'users.id')
                            ->join('account_types' , 'account_launches.accountlaunch_type' ,'=', 'account_types.id')
                            ->select(
                                'users.id as userId', 'users.name', 'entries.*', 'account_launches.*',
                                'account_types.id as typeAccountId', 'account_types.account_types_name'
                            )
                            ->where('entries.entries_id_company',$company_id)
                            ->get();
                            $br = "<br/>";
                            $idAccount = 0;
        foreach ($accountGroup as $keyGroup => $valueGroup) {
            // echo $valueGroup->accountlaunch_name.$br;
            foreach ($AccountLaunch as $key => $value) {
               if($valueGroup->id == $value->id){
                // dump($value->entries_description);
               }
            }
        }
        return view('report.account.accountLaunchAll', compact('accounts', 'accountGroup', 'AccountLaunch'));
    }
}
