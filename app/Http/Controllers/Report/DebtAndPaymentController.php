<?php

declare(strict_types=1);

namespace App\Http\Controllers\Report;

use App\Http\Controllers\AuthenticatedController;
use App\Models\Company;
use App\Service\Report\DebtReport\GenerateDebtReport;
use Illuminate\Http\Request;

class DebtAndPaymentController extends AuthenticatedController
{
    public function index()
    {
        return view('report/debt-and-payment/index', [
            'title' => 'Relatório - Dívidas e Pagamentos',
            'companies' => Company::all(),
        ]);
    }

    public function generateReport(Request $request, GenerateDebtReport $generateDebtReport)
    {
        $companyId = intval($request->get('company_id'));
        $report = $generateDebtReport->generate($companyId);

        return response()
            ->download($report->getRealPath(), 'relatorio.xlsx')
            ->deleteFileAfterSend(true);
    }
}
