<?php

declare(strict_types=1);

namespace Seara\Service\Financing\Payment;

use Seara\Payment;
use Seara\PaymentPart;
use Seara\Service\Core\Util\UuidGenerator;

class CreatePayment
{
    public function execute(array $paymentData, array $parts = []): void
    {
        $paymentData['id'] = UuidGenerator::generate();
        $payment = Payment::create($paymentData);

        $parts = collect($parts)
            ->map(function (array $part) use ($payment) {
                $part['payment_id'] = $payment->id;
                $part['payment_date'] = $payment->payment_date;
                return $part;
            });

        foreach ($parts as $part) {
            PaymentPart::create($part);
        }
    }
}
