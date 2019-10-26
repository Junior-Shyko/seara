<?php

declare(strict_types=1);

namespace App\Service\Financing\Receivable;

use App\Service\Core\Util\UuidGenerator;
use Carbon\Carbon;

class CreateReceivable
{
    /**
     * @var ReceivableRepository
     */
    private $repository;

    public function __construct(ReceivableRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $receivableData)
    {
        $repeatFor = $receivableData['repeat_for'] ?? 0;
        if (0 === $repeatFor) {
            $receivableData['id'] = $this->repository->nextIdentity();
            $this->repository->save($receivableData);
            return;
        }
        $this->generateSequence($receivableData);
    }

    private function generateSequence(array $receivableData)
    {
        $count = $receivableData['repeat_for'];
        $sequenceId = UuidGenerator::generate();

        $firstDueDate = Carbon::createFromFormat(
            '!Y-m-d',
            $receivableData['due_date']
        );

        $receivables = [];
        for ($i = 0; $i < $count; $i++) {
            $receivables[] = [
                'sequence_id' => $sequenceId,
                'sequence_number' => $i + 1,
                'sequence_count' => $count,
                'amount' => $receivableData['amount'],
                'description' => $receivableData['description'],
                'income_category_id' => $receivableData['income_category_id'],
                'account_id' => $receivableData['account_id'],
                'company_id' => $receivableData['company_id'] ?? null,
                'due_date' => $this->calculateDueDate($i, $firstDueDate)
            ];
        }

        foreach ($receivables as $receivable) {
            $receivable['id'] = $this->repository->nextIdentity();
            $this->repository->save($receivable);
        }
    }

    private function calculateDueDate(int $i, Carbon $firstDueDate): string
    {
        $dueDate = clone $firstDueDate;

        if ($i === 0) {
            return $dueDate->format('Y-m-d');
        }

        if ($dueDate->format('t') === $dueDate->format('d')) {
            $dueDate->modify('last day of next month');
            return $dueDate->format('Y-m-d');
        }

        $dueDate->modify(sprintf('+%d month', $i));
        return $dueDate->format('Y-m-d');
    }
}
