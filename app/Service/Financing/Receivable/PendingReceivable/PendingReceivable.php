<?php

declare(strict_types=1);

namespace Seara\Service\Financing\Receivable\PendingReceivable;

class PendingReceivable
{
    /**
     * @var string
     */
    private $receivableId;
    /**
     * @var float
     */
    private $pendingAmount;

    /**
     * PendingReceivable constructor.
     * @param string $receivableId
     * @param float $pendingAmount
     */
    public function __construct(string $receivableId, float $pendingAmount)
    {
        $this->receivableId = $receivableId;
        $this->pendingAmount = $pendingAmount;
    }

    /**
     * @return string
     */
    public function getReceivableId(): string
    {
        return $this->receivableId;
    }

    /**
     * @return float
     */
    public function getPendingAmount(): float
    {
        return $this->pendingAmount;
    }
}
