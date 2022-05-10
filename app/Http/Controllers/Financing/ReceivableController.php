<?php

declare(strict_types=1);

namespace Seara\Http\Controllers\Financing;

use Seara\Account;
use Seara\Http\Controllers\Controller;
use Seara\Http\Requests\PayReceivableRequest;
use Seara\Http\Requests\StoreReceivableRequest;
use Seara\Http\Requests\UpdateReceivableRequest;
use Seara\IncomeCategory;
use Seara\Models\Company;
use Seara\Payment;
use Seara\PaymentPart;
use Seara\Receivable;
use Seara\Service\Core\Transformation\ArrayTransformer;
use Seara\Service\Core\Transformation\Operations\FloatToMoney;
use Seara\Service\Core\Transformation\Operations\UsaDateToBr;
use Seara\Service\Financing\IncomeCategory\IncomeCategoryRepository;
use Seara\Service\Financing\Payment\CreatePayment;
use Seara\Service\Financing\Receivable\CreateReceivable;
use Seara\Service\Financing\Receivable\GenerateReceiptReceivable;
use Seara\Service\Financing\Receivable\PayReceivable;
use Seara\Service\Financing\Receivable\ReceivableRepository;
use Seara\Service\Financing\Receivable\ReceivableTableFactory;
use Seara\Traits\ActionTable;
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
            $paymentPart = PaymentPart::query()
                ->where('receivable_id', '=', $id)
                ->first();

            if ($paymentPart) {
                Payment::destroy($paymentPart->payment_id);
            }

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
        PayReceivable $createPayment
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
