<?php

declare(strict_types=1);

namespace Seara\Http\Controllers;

use Seara\Service\Financial\FinancialReportService;
use Illuminate\Http\Request;
use Seara\AccountLaunch;
use Seara\Http\Controllers\Controller;

class FinancialReportController extends Controller
{
    protected $reportService;

    public function __construct(FinancialReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Exibe formulário do relatório
     */
    public function index()
    {
        $categories = AccountLaunch::where('account_launches_status', 'AT')
            ->orderBy('accountlaunch_name')
            ->get();

        return view('financial.reports.index', compact('categories'));
    }

    /**
     * Gera relatório por categoria
     */
    public function byCategory(Request $request)
    {
        
        $request->validate([
            'dateInitial' => ['required', function ($attribute, $value, $fail) {
                // Tenta converter com 2 dígitos
                $date = \Carbon\Carbon::createFromFormat('d/m/y', $value);
                if (!$date) {
                    // Tenta com 4 dígitos
                    $date = \Carbon\Carbon::createFromFormat('d/m/Y', $value);
                }
                
                if (!$date) {
                    $fail('A data inicial deve estar no formato dd/mm/yy ou dd/mm/yyyy');
                }
            }],
            'dateEnd' => ['required', function ($attribute, $value, $fail) {
                $date = \Carbon\Carbon::createFromFormat('d/m/y', $value);
                if (!$date) {
                    $date = \Carbon\Carbon::createFromFormat('d/m/Y', $value);
                }
                
                if (!$date) {
                    $fail('A data final deve estar no formato dd/mm/yy ou dd/mm/yyyy');
                }
            }],
        ]);

        // Normalizar as datas antes de enviar ao Service
        $startDate = $this->normalizeDate($request->dateInitial);
        $endDate = $this->normalizeDate($request->dateEnd);

        $companyId = auth()->user()->company_id ?? 406;

        try {
            $report = $this->reportService->getReportByCategory(
                $startDate,
                $endDate,
                $companyId
            );

           return view('financial.reports.by-category', compact('report'));
            
        } catch (\Exception $e) {
            dd($e->getMessage());
            // return back()
            //     ->withErrors(['error' => 'Erro ao gerar relatório: ' . $e->getMessage()])
            //     ->withInput();
        }
    }

    /**
 * Normaliza data para formato dd/mm/yyyy
 */
private function normalizeDate($date)
{
    // Tenta converter com 2 dígitos primeiro
    $carbonDate = \Carbon\Carbon::createFromFormat('d/m/y', $date);
    
    if (!$carbonDate) {
        // Se falhar, tenta com 4 dígitos
        $carbonDate = \Carbon\Carbon::createFromFormat('d/m/Y', $date);
    }
    
    return $carbonDate->format('d/m/Y');
}

    /**
     * Gera relatório detalhado
     */
    public function detailed(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date_format:d/m/Y',
            'end_date' => 'required|date_format:d/m/Y|after_or_equal:start_date',
        ]);

        $companyId = auth()->user()->company_id ?? 406;

        $report = $this->reportService->getDetailedReportByCategory(
            $request->start_date,
            $request->end_date,
            $companyId
        );

        return view('financial.reports.detailed', compact('report'));
    }

    /**
     * Exportar para PDF
     */
    public function exportPdf(Request $request)
    {
        $companyId = auth()->user()->company_id ?? 406;

        $report = $this->reportService->getReportByCategory(
            $request->start_date,
            $request->end_date,
            $companyId
        );

        $pdf = \PDF::loadView('financial.reports.pdf', compact('report'));
        
        return $pdf->download('relatorio-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Exportar para Excel
     */
    public function exportExcel(Request $request)
    {
        $companyId = auth()->user()->company_id ?? 406;

        $report = $this->reportService->getReportByCategory(
            $request->start_date,
            $request->end_date,
            $companyId
        );

        return \Excel::download(
            new \App\Exports\FinancialReportExport($report), 
            'relatorio-' . date('Y-m-d') . '.xlsx'
        );
    }
}