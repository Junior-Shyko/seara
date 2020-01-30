<?php

declare(strict_types=1);

namespace App\Service\Report\DebtReport;

use App\Models\Company;
use Carbon\Carbon;
use DB;

class EloquentDebtReportProvider implements DebtReportProvider
{
    /**
     * @inheritDoc
     */
    public function getResults(int $companyId): DebtReportResultSet
    {
        $company = Company::find($companyId);

        $results = DB::table('debt_report_view')
            ->where('company_id', '=', $companyId)
            ->orderBy('effective_date')
            ->get()
            ->unique('id')
            ->map(function ($rawResult) {
                return new DebtReportResult(
                    Carbon::createFromFormat('Y-m-d', $rawResult->effective_date),
                    $rawResult->description,
                    $rawResult->amount
                );
            })
            ->toArray();

        $companyName = $company->company_fantasy ?? $company->company_name;
        $companyManager = $company->company_manager;

        return new DebtReportResultSet($companyName, $companyManager, $results);
    }
}
