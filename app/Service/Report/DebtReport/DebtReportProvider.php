<?php

declare(strict_types=1);

namespace App\Service\Report\DebtReport;

interface DebtReportProvider
{
    /**
     * Returns the debt report result data for the given company
     *
     * @param int $companyId
     * @return DebtReportResultSet
     */
    public function getResults(int $companyId): DebtReportResultSet;
}
