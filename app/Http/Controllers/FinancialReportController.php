<?php

declare(strict_types=1);

namespace Seara\Http\Controllers;

use Carbon\Carbon;
use Barryvdh\DomPDF\PDF;
use Seara\AccountLaunch;
use Seara\Models\Company;
use Seara\FinancialAccount;
use Illuminate\Http\Request;
use Seara\Http\Controllers\Controller;
use Seara\Service\MonthlyFinancialReportService;
use Seara\Service\Financial\FinancialReportService;

class FinancialReportController extends Controller
{
    protected $reportService;
    protected $monthlyReportService;

    public function __construct(
        FinancialReportService $reportService,
        MonthlyFinancialReportService $monthlyReportService
    ) {
        $this->reportService = $reportService;
        $this->monthlyReportService = $monthlyReportService;
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

        $companyId = $request->company_id ?? auth()->user()->user_company_id;
        $company = Company::getCompany($companyId);
        try {
            $report = $this->reportService->getReportByCategory(
                $startDate,
                $endDate,
                $companyId,
                $request->entries_id_account
            );
           return view('financial.reports.by-category', compact('report', 'company'));
            
        } catch (\Exception $e) {

            return back()
                ->withErrors(['error' => 'Erro ao gerar relatório: ' . $e->getMessage()])
                ->withInput();
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

    
    /**
     * Gera PDF do relatório mensal
     */
    public function monthlyReportPdf(Request $request)
    {
        // $request->validate([
        //     'month_financial' => 'required|integer|min:1|max:12',
        //     'year_financial' => 'required|integer|min:2000|max:2100'
        // ]);
        // $startDate = $this->normalizeDate($request->dateInitial);
        // $endDate = $this->normalizeDate($request->dateEnd);
        
        $carbonDate = Carbon::createFromFormat('y', $request->year_financial);

        // Extrai o ano completo como inteiro
        $fullYear = $carbonDate->year; // 2025

        $companyId = auth()->user()->user_id_company ?? 406;
       
        // Usa $this->monthlyReportService 👈 NOVO SERVICE
        $report = $this->monthlyReportService->getMonthlyReport(
            $request->month_financial,
            $fullYear,
            $companyId
        );
        $totalBanks = FinancialAccount::byCompany($companyId)
            ->banks()
            ->sum('current_balance');
        $totalCash = FinancialAccount::byCompany($companyId)
            ->cash()
            ->sum('current_balance');

        $totalGeneral = $totalBanks + $totalCash;
       
        // Buscar dados da empresa
        $company = Company::find($companyId);
        // dd($report);
        $pdf = \PDF::loadView('financial.reports.monthly-pdf', compact('report', 'company', 'totalBanks', 'totalCash', 'totalGeneral'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('relatorio-mensal.pdf');
        // $filename = 'relatorio-' . str_pad($request->month_financial, 2, '0', STR_PAD_LEFT) . '-' . $fullYear . '.pdf';
        
        // return $pdf->download($filename);
    }
}