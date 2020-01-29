<?php

declare(strict_types=1);

namespace App\Service\Report\DebtReport;

class ResultSetToRowsConverter
{
    private const BALANCE_FORMULA = '=INDIRECT("R[-1]C", 0) + INDIRECT("RC[-2]", 0) - INDIRECT("RC[-1]", 0)';

    private const FIRST_BALANCE_FORMULA = '=INDIRECT("RC[-2]", 0)';

    public function convert(DebtReportResultSet $resultSet): array
    {
        $rows = $this->convertResultSetToRows($resultSet);
        $rows = $this->fixFirstBalanceFormula($rows);
        return $this->addTotals($rows);
    }

    private function convertResultSetToRows(DebtReportResultSet $resultSet)
    {
        return array_map(function (DebtReportResult $result) {
            if ($result->getAmount() > 0) {
                return $this->convertToPaidAmount($result);
            }

            return $this->convertToDebtAmount($result);
        }, $resultSet->toArray());
    }

    private function convertToPaidAmount(DebtReportResult $result): array
    {
        return [
            null,
            null,
            $result->getEffectiveDate()->format('d/m/Y'),
            $result->getDescription(),
            null,
            number_format(abs($result->getAmount()), 2),
            self::BALANCE_FORMULA
        ];
    }

    private function convertToDebtAmount(DebtReportResult $result): array
    {
        $effectiveDate = $result->getEffectiveDate()->copy();
        $previousMonth = $result->getEffectiveDate()->subMonth();

        return [
            $previousMonth->format('m'),
            $previousMonth->format('Y'),
            $effectiveDate->format('d/m/Y'),
            $result->getDescription(),
            number_format(abs($result->getAmount()), 2),
            null,
            self::BALANCE_FORMULA
        ];
    }

    private function fixFirstBalanceFormula(array $rows): array
    {
        if (count($rows) == 0) {
            return $rows;
        }

        $rows[0][6] = self::FIRST_BALANCE_FORMULA;
        return $rows;
    }

    private function addTotals(array $rows): array
    {
        $rows[] = [
            null,
            null,
            null,
            null,
            '=SUM(E4:INDIRECT("R[-1]C", 0))',
            '=SUM(F4:INDIRECT("R[-1]C", 0))',
            '=INDIRECT("RC[-2]", 0) - INDIRECT("RC[-1]", 0)',
        ];

        return $rows;
    }
}
