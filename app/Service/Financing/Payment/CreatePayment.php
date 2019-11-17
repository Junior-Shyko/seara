<?php

declare(strict_types=1);

namespace App\Service\Financing\Payment;

use App\Payment;
use App\Service\Core\Util\UuidGenerator;

class CreatePayment
{
    public function execute(array $paymentData): void
    {
        $paymentData['id'] = UuidGenerator::generate();
        $payment = new Payment();
        $payment->fill($paymentData);
        $payment->save();
    }
}
