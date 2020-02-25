<?php

declare(strict_types=1);

namespace App\Http\Controllers\Financing;

use App\Http\Controllers\Controller;
use App\Service\Financing\Payment\PaymentTableFactory;

class PaymentController extends Controller
{
    public function index()
    {
        return view('financing.payment.index', [
            'title' => 'Pagamentos',
        ]);
    }

    public function dataTable(PaymentTableFactory $factory)
    {
        return $factory->make();
    }
}
