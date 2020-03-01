<?php

declare(strict_types=1);

namespace App\Http\Controllers\Financing;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Payment;
use App\Service\Financing\Payment\PaymentTableFactory;
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
