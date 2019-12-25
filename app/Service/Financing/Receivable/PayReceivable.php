<?php

declare(strict_types=1);

namespace App\Service\Financing\Receivable;

use App\Receivable;
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

        $this->handleLateFeeAmount(
            $pendingReceivables,
            $receivable,
            $paymentData['late_fee_amount'] ?? 0.0
        );

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

    private function handleLateFeeAmount(
        array &$pendingReceivables,
        Receivable $receivable,
        float $lateFeeAmount
    ) {
        if ($lateFeeAmount <= 0) {
            return;
        }

        $lateFeeReceivableId = $this->receivableRepository->nextIdentity();
        $this->receivableRepository->save([
            'id' => $lateFeeReceivableId,
            'amount' => $lateFeeAmount,
            'due_date' => $receivable->due_date,
            'description' => 'Juros/multa',
            'income_category_id' => $receivable->income_category_id,
            'account_id' => $receivable->account_id,
            'company_id' => $receivable->company_id
        ]);

        array_unshift(
            $pendingReceivables,
            new PendingReceivable($lateFeeReceivableId, $lateFeeAmount)
        );
    }
}
