<?php

declare(strict_types=1);

namespace Seara\Service\Report\DebtReport;

use SplFileInfo;

interface DebtReportFormatter
{
    /**
     * Outputs a report result set into a file and returns the file reference
     *
     * @param DebtReportResultSet $resultSet
     * @return SplFileInfo
     */
    public function format(DebtReportResultSet $resultSet): SplFileInfo;
}
