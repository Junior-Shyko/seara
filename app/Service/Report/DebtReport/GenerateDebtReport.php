<?php

declare(strict_types=1);

namespace Seara\Service\Report\DebtReport;

use SplFileInfo;

class GenerateDebtReport
{
    /**
     * @var DebtReportProvider
     */
    private $provider;
    /**
     * @var DebtReportFormatter
     */
    private $formatter;

    public function __construct(
        DebtReportProvider $provider,
        DebtReportFormatter $formatter
    ) {
        $this->provider = $provider;
        $this->formatter = $formatter;
    }

    public function generate(int $companyId): SplFileInfo
    {
        $resultSet = $this->provider->getResults($companyId);
        return $this->formatter->format($resultSet);
    }
}
