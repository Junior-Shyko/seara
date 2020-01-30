<?php

declare(strict_types=1);

namespace App\Service\Report\DebtReport;

interface DebtReportProvider
{
    /**
     * Returns the debt report result data for the given company. The
     * data is expected to be already sorted by date
     *
     * @param int $companyId
     * @return DebtReportResultSet
     */
    public function getResults(int $companyId): DebtReportResultSet;
}
