<?php

declare(strict_types=1);

namespace App\Service\Report\DebtReport;

class ResultSetToRowsConverter
{
    public function convert(DebtReportResultSet $resultSet, $initialRow): array
    {
        $rows = $this->convertResultSetToRows($resultSet, $initialRow);
        $rows = $this->fixFirstBalanceFormula($rows, $initialRow);
        return $this->addTotals($rows, $initialRow);
    }

    private function convertResultSetToRows(DebtReportResultSet $resultSet, $initialRow)
    {
        $rows = [];

        foreach ($resultSet as $idx => $result) {
            if ($result->getAmount() > 0) {
                $rows[] = $this->convertToPaidAmount($result, $idx + $initialRow);
                continue;
            }

            $rows[] = $this->convertToDebtAmount($result, $idx + $initialRow);
        }

        return $rows;
    }

    private function convertToPaidAmount(DebtReportResult $result, int $rowNumber): array
    {
        return [
            null,
            null,
            $result->getEffectiveDate()->format('d/m/Y'),
            $result->getDescription(),
            null,
            number_format(abs($result->getAmount()), 2),
            $this->buildBalance($rowNumber)
        ];
    }

    private function convertToDebtAmount(DebtReportResult $result, int $rowNumber): array
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
            $this->buildBalance($rowNumber)
        ];
    }

    private function fixFirstBalanceFormula(array $rows, int $initialRow): array
    {
        if (count($rows) == 0) {
            return $rows;
        }

        $rows[0][6] = "=E{$initialRow}-F{$initialRow}";
        return $rows;
    }

    private function addTotals(array $rows, int $initialRow): array
    {
        $lastRowNumber = $initialRow + count($rows) - 1;
        $totalRowNumber = $lastRowNumber + 1;

        $rows[] = [
            null,
            null,
            null,
            null,
            "=SUM(E4:E{$lastRowNumber})",
            "=SUM(F4:F{$lastRowNumber})",
            "=E{$totalRowNumber}-F{$totalRowNumber}",
        ];

        return $rows;
    }

    private function buildBalance(int $rowNumber): string
    {
        $lastRowNumber = $rowNumber - 1;
        return "=G{$lastRowNumber}+E{$rowNumber}-F{$rowNumber}";
    }
}
