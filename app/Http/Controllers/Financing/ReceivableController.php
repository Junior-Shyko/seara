<?php

declare(strict_types=1);

namespace App\Http\Controllers\Financing;

use App\Account;
use App\Http\Controllers\Controller;
use App\Http\Requests\PayReceivableRequest;
use App\Http\Requests\StoreReceivableRequest;
use App\Http\Requests\UpdateReceivableRequest;
use App\IncomeCategory;
use App\Models\Company;
use App\Receivable;
use App\Service\Core\Transformation\ArrayTransformer;
use App\Service\Core\Transformation\Operations\FloatToMoney;
use App\Service\Core\Transformation\Operations\UsaDateToBr;
use App\Service\Financing\IncomeCategory\IncomeCategoryRepository;
use App\Service\Financing\Payment\CreatePayment;
use App\Service\Financing\Receivable\CreateReceivable;
use App\Service\Financing\Receivable\GenerateReceiptReceivable;
use App\Service\Financing\Receivable\ReceivableRepository;
use App\Service\Financing\Receivable\ReceivableTableFactory;
use App\Traits\ActionTable;
use Carbon\Carbon;
use Datatables;
use DB;
use Illuminate\Http\Request;
use Throwable;

class ReceivableController extends Controller
{
    use ActionTable;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(IncomeCategoryRepository $incomeCategoryRepository)
    {
        return view('financing.receivable.index', [
            'title' => 'Contas a Receber',
            'incomeCategories' => IncomeCategory::all(),
            'accounts' => Account::all(),
            'companies' => Company::all(),
        ]);
    }

    public function store(
        StoreReceivableRequest $request,
        CreateReceivable $createReceivable
    ) {
        try {
            $createReceivable->execute($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Conta a receber salva com sucesso'
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível salvar, tente novamente'
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            Receivable::destroy($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Conta removida com sucesso!'
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível remover essa conta'
            ], 500);
        }
    }

    public function show(string $id, ReceivableRepository $repository, ArrayTransformer $transformer)
    {
        $receivable = $repository->find($id)
            ->jsonSerialize();
        $receivable = $transformer->transform($receivable, [
            'due_date' => [new UsaDateToBr()],
            'amount' => [new FloatToMoney()]
        ]);
        return response()->json($receivable);
    }

    public function update(string $id, UpdateReceivableRequest $request, ReceivableRepository $repository)
    {
        try {
            $repository->update($id, $request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Conta salva com sucesso'
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível atualizar a conta'
            ]);
        }
    }

    public function payReceivable(
        string $id,
        PayReceivableRequest $request,
        CreatePayment $createPayment
    ) {
        try {
            $paymentData = $request->all();
            $paymentData['receivable_id'] = $id;
            $createPayment->execute($paymentData);
            return response()->json([
                'status' => 'success',
                'message' => 'Conta efetivada com sucesso'
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível efetivar a conta'
            ]);
        }
    }

    public function generateReceipt(string $id, GenerateReceiptReceivable $generateReceiptReceivable)
    {
        try {
            $receipt = $generateReceiptReceivable->execute($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Recibo gerado com sucesso!',
                'location' => url("receipt-company/{$receipt->receipt_id}/pdf?vias=2")
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível gerar o recibo, tente novamente'
            ]);
        }
    }

    public function dataTable(ReceivableTableFactory $receivableTable)
    {
        return $receivableTable->make();
    }
}
