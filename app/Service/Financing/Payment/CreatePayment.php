<?php

declare(strict_types=1);

namespace App\Service\Financing\Payment;

use App\Payment;
use App\PaymentPart;
use App\Service\Core\Util\UuidGenerator;

class CreatePayment
{
    public function execute(array $paymentData): void
    {
        $paymentData['id'] = UuidGenerator::generate();
        $payment = Payment::create($paymentData);

        PaymentPart::create([
            'payment_id' => $paymentData['id'],
            'amount' => $payment->amount,
            'payment_date' => $payment->payment_date,
            'receivable_id' => $payment->receivable_id,
        ]);
    }
}
