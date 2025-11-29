<?php

namespace Seara\Http\Controllers;

use Seara\TypeBank;
use Seara\FinancialAccount;
use Illuminate\Http\Request;
use Seara\FinancialEntry;
use Seara\Repository\BankRepository;
use Yajra\DataTables\Facades\DataTables;

class FinancialAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validated = $request->validate([
            'bank_id' => 'required|integer|exists:banks,id', // Assumindo tabela 'banks' para Bank model
            'typeBank_id' => 'required|integer|exists:type_banks,id', // Assumindo tabela 'type_banks' para TypeBank
            'number' => 'required|string|max:255',
            'agency_number' => 'required|string|max:255',
            'company_id' => 'required|integer|exists:companies,company_id', // Baseado no relacionamento no model
            'owner' => 'nullable|integer', // Campo 'owner' não existe no model, então ignorado ou tratado separadamente
            'idAccontBank' => 'nullable|string', // Campo vazio na requisição, ignorado se não necessário
        ]);

        // Buscar o TypeBank pelo ID fornecido na requisição
        $typeBank = TypeBank::findOrFail($request->typeBank_id);
        $bank = BankRepository::getBank($request->bank_id);

        // Criar uma nova instância de FinancialAccount
        $financialAccount = new FinancialAccount();

        // Adicionar (definir ou concatenar) o nome do TypeBank ao campo 'name' da FinancialAccount
        // Aqui, assumi que "adicione" significa definir o name como o nome do TypeBank.
        // Se for para concatenar com algo existente, ajuste conforme necessário (ex: $financialAccount->name = 'Conta ' . $typeBank->name;)
        $financialAccount->name = $bank->name . ' - ' . $typeBank->name;

        // Preencher os outros campos da requisição
        $financialAccount->bank_id = $request->bank_id;
        $financialAccount->agency_number = $request->agency_number;
        $financialAccount->account_number = $request->number; // Assumindo que 'number' é 'account_number'
        $financialAccount->company_id = $request->company_id;

        // Campos não fornecidos na requisição: definir defaults
        $financialAccount->type = 'bank'; // Assumindo 'bank' baseado no contexto (ajuste se necessário)
        $financialAccount->current_balance = 0.00; // Saldo inicial zero
        $financialAccount->is_active = true; // Ativo por default

        // Campos extras na requisição mas não no model (ex: owner, idAccontBank) são ignorados.
        // Se precisar adicionar colunas ao model para esses campos, faça a migração primeiro.

        // Salvar no banco de dados
        $financialAccount->save();

        // Retornar uma resposta (ex: JSON com o objeto criado)
        return response()->json([
            'message' => 'FinancialAccount criada com sucesso!',
            'data' => $financialAccount,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Seara\FinancialAccount  $financialAccount
     * @return \Illuminate\Http\Response
     */
    public function show(FinancialAccount $financialAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Seara\FinancialAccount  $financialAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(FinancialAccount $financialAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Seara\FinancialAccount  $financialAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FinancialAccount $financialAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Seara\FinancialAccount  $financialAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinancialAccount $financialAccount)
    {
        //
    }

    public function getAllAccount($id)
    {
        $accounts = FinancialAccount::where('company_id', $id)->get();
        // return response()->json($accounts);
        return DataTables::of($accounts)
            ->addColumn('type', function ($accounts) {
               if($accounts->type == 'bank'){
                   return 'Banco';
               } else {
                   return 'Caixa';
               }
            })
            ->addColumn('current_balance', function ($accounts) {
                return number_format($accounts->current_balance, 2, ',', '.');
            })
            ->addColumn('action', function ($accounts) {
                $isFinancialEntries = FinancialEntry::where('account_id', $accounts->id)->count() > 0;
                if ($isFinancialEntries) {  
                    return '<button class="btn btn-sm btn-danger disabled" 
                    title="Não pode excluir conta que tenha lançamento" 
                    onclick="deleteAccount(' . $accounts->id . ')">
                    <i class="fa fa-trash"></i> Excluir </button>';                
                }
                return '<button class="btn btn-sm btn-danger " title="Excluir conta" 
                onclick="deleteAccount(' . $accounts->id . ')">
                <i class="fa fa-trash"></i> Excluir </button>';                
                
            })
            ->rawColumns(['action']) // Permitir HTML na coluna 'action'
            ->make(true);
    }
}
