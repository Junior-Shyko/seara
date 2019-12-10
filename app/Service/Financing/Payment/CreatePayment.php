<?php

declare(strict_types=1);

namespace App\Service\Financing\Payment;

use App\Payment;
use App\PaymentPart;
use App\Service\Core\Util\UuidGenerator;
use Carbon\Carbon;

class CreatePayment
{
    public function execute(array $paymentData, array $parts = []): void
    {
        $paymentData['id'] = UuidGenerator::generate();
        $payment = Payment::create($paymentData);

        $parts = collect($parts)
            ->map(function (array $part) use ($payment) {
                $part['payment_id'] = $payment->id;
                $part['payment_date'] = Carbon::now();
                return $part;
            });

        foreach ($parts as $part) {
            PaymentPart::create($part);
        }
    }
}
