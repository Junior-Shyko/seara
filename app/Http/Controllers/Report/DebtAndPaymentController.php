<?php

declare(strict_types=1);

namespace Seara\Http\Controllers\Report;

use Seara\Http\Controllers\AuthenticatedController;
use Seara\Models\Company;
use Seara\Service\Report\DebtReport\GenerateDebtReport;
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
