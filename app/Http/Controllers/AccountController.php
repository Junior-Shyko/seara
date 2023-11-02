<?php

namespace Seara\Http\Controllers;

use DB;
use Throwable;
use DataTables;
use Carbon\Carbon;
use Seara\Account;
use Seara\AccountLaunch;
use Seara\Models\Company;
use Seara\Seara\Monetary;
use Seara\FunctionGeneral;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Seara\Traits\ActionTable;
use Illuminate\Http\JsonResponse;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Seara\Http\Requests\StoreAccount;
use Seara\Repository\AccountBankRepository;
use Seara\Http\Requests\UpdateAccountRequest;
use Seara\Repository\AccountLaunchRepository;
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
         $company    = Company::getCompany(Auth::user()->user_id_company);
         $companyAll = Company::get();
        //inicio do mes e final do mes atual
        $startMonth = Carbon::now()->startOfMonth();
        $endMonth = Carbon::now()->endOfMonth();
        $startMonthFormated = $startMonth->format('d/m/Y');
        $endMonthFormated = $endMonth->format('d/m/Y');
        return view('report.account.index', 
            compact('accounts', 'company', 'companyAll','startMonthFormated', 'endMonthFormated' )
        );
    }

    public function getReportAccount(Request $request)
    {
        $idAccount = $request->entries_id_account;
        $company_id = 0;
        if($request->company_id == null || !isset($request->company_id))
        {
            $company_id = Auth::user()->user_company_id;
        }else{
            $company_id = $request->company_id;
        };
        
        $accountLaunch = new AccountLaunchRepository;
        $dtinit = FunctionGeneral::DataBRtoMySQL($request->dateInitial);
        $dtend  = FunctionGeneral::DataBRtoMySQL($request->dateEnd);
        //Total de lançamentos por grupo
        $accountGroup = $accountLaunch->getAccountLaunchEntryGroup($company_id, $dtinit, $dtend, $idAccount);
        //Todos os lançamentos
        $accountLaunchAll = $accountLaunch->getAccountLaunchEntry($company_id, $dtinit, $dtend, $idAccount);
        $dtInitReport = $request->dateInitial;
        $dtEndReport = $request->dateEnd;
        //saldo anterior
        $prevBalan = Monetary::previousBalance($dtinit, $company_id);
        $balance = ($prevBalan['receitas'] - $prevBalan['despesas']);

        //RETORNO DA SOMA DOS VALORES DO CAIXA BANCO
        $balanceBank = AccountBankRepository::getBalance($company_id);
        
        //Se nao tiver registro
        if(count($accountGroup) == 0 && count($accountLaunchAll) == 0)
        {
            return back()->with('error', 'Não existe lançamento nesse período ou verifique a sua pesquisa.');
        }


        $pdf = PDF::loadView('report.account.accountLaunchAll', 
            compact('accounts', 'accountGroup',  'accountLaunchAll', 'dtInitReport', 'dtEndReport', 'balance', 'balanceBank'));
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultPaperSize' =>  'a4'
        ]);
        
        return $pdf->stream();

        // return view('report.account.accountLaunchAll', compact('accounts', 'accountGroup', 'accountLaunchAll', 
        // 'dtInitReport', 'dtEndReport', 'balance', 'balanceBank'));
    }
}
