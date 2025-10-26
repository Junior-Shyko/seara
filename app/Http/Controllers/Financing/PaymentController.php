<?php

declare(strict_types=1);

namespace Seara\Http\Controllers\Financing;

use Seara\Http\Controllers\Controller;
use Seara\Models\Company;
use Seara\Payment;
use Seara\Service\Financing\Payment\PaymentTableFactory;
use Throwable;

class PaymentController extends Controller
{
    public function index()
    {
        return view('financing.payment.index', [
            'title' => 'Pagamentos',
            'companies' => Company::all(),
        ]);
    }

    public function show(string $id)
    {
    }

    public function destroy(string $id)
    {
        try {
            Payment::destroy($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Pagamento removido com sucesso'
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível remover o pagamento, tente novamente'
            ], 500);
        }
    }

    public function dataTable(PaymentTableFactory $factory)
    {
        return $factory->make();
    }
}
