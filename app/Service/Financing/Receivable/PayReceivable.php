<?php

declare(strict_types=1);

namespace App\Service\Financing\Receivable;

use App\Service\Financing\Payment\CreatePayment;
use App\Service\Financing\Receivable\PendingReceivable\PendingReceivable;
use App\Service\Financing\Receivable\PendingReceivable\PendingReceivableQuery;

class PayReceivable
{
    /**
     * @var CreatePayment
     */
    private $createPayment;
    /**
     * @var ReceivableRepository
     */
    private $receivableRepository;
    /**
     * @var PendingReceivableQuery
     */
    private $pendingReceivableQuery;

    public function __construct(
        CreatePayment $createPayment,
        ReceivableRepository $receivableRepository,
        PendingReceivableQuery $pendingReceivableQuery
    ) {
        $this->createPayment = $createPayment;
        $this->receivableRepository = $receivableRepository;
        $this->pendingReceivableQuery = $pendingReceivableQuery;
    }

    public function execute(array $paymentData): void
    {
        $paymentData = collect($paymentData);
        $receivable = $this->receivableRepository->find($paymentData->get('receivable_id'));
        $pendingReceivables = $this->pendingReceivableQuery
            ->nextPendingReceivables($receivable);

        $payment = $paymentData->only('payment_date', 'amount')->toArray();

        $paymentParts = $this->generatePaymentParts(
            $payment['amount'],
            $pendingReceivables
        );

        $this->createPayment->execute($payment, $paymentParts);
    }

    /**
     * @param float $amount
     * @param PendingReceivable[] $pendingReceivables
     * @return array
     */
    private function generatePaymentParts(
        float $amount,
        array $pendingReceivables
    ): array {
        $parts = [];

        foreach ($pendingReceivables as $pendingReceivable) {
            if ($amount > $pendingReceivable->getPendingAmount()) {
                $parts[] = [
                    'receivable_id' => $pendingReceivable->getReceivableId(),
                    'amount' => $pendingReceivable->getPendingAmount(),
                ];
                $amount -= $pendingReceivable->getPendingAmount();
                continue;
            }

            if ($amount === $pendingReceivable->getPendingAmount()) {
                $parts[] = [
                    'receivable_id' => $pendingReceivable->getReceivableId(),
                    'amount' => $pendingReceivable->getPendingAmount(),
                ];
                break;
            }

            if ($amount < $pendingReceivable->getPendingAmount()) {
                $parts[] = [
                    'receivable_id' => $pendingReceivable->getReceivableId(),
                    'amount' => $amount,
                ];
                break;
            }
        }

        return $parts;
    }
}
