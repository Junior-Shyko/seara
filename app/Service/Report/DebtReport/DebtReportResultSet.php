<?php

declare(strict_types=1);

namespace Seara\Service\Report\DebtReport;

use ArrayIterator;
use Countable;
use IteratorAggregate;

class DebtReportResultSet implements IteratorAggregate, Countable
{
    /**
     * @var string
     */
    private $companyName;
    /**
     * @var string
     */
    private $companyManager;
    /**
     * @var array
     */
    private $debtData;

    /**
     * @param string $companyName
     * @param string $companyManager
     * @param array<DebtReportResult> $debtData
     */
    public function __construct(
        string $companyName,
        string $companyManager,
        array $debtData
    ) {
        $this->companyName = $companyName;
        $this->companyManager = $companyManager;
        $this->debtData = $debtData;
    }

    /**
     * @return string
     */
    public function getCompanyManager(): string
    {
        return $this->companyManager;
    }

    /**
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->debtData);
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->debtData);
    }

    public function toArray(): array
    {
        return $this->debtData;
    }
}
