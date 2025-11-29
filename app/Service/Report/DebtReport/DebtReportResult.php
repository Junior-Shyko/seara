<?php

declare(strict_types=1);

namespace Seara\Service\Report\DebtReport;

use Carbon\Carbon;
use DateTime;

class DebtReportResult
{
    /**
     * @var Carbon
     */
    private $effectiveDate;
    /**
     * @var string
     */
    private $description;
    /**
     * @var float
     */
    private $amount;

    public function __construct(
        Carbon $effectiveDate,
        string $description,
        float $amount
    ) {
        $this->effectiveDate = $effectiveDate;
        $this->description = $description;
        $this->amount = $amount;
    }

    /**
     * @return Carbon
     */
    public function getEffectiveDate(): Carbon
    {
        return $this->effectiveDate;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
}
