<?php

declare(strict_types=1);

namespace Seara\Http\Controllers;

use Carbon\Carbon;
use Barryvdh\DomPDF\PDF;
use Seara\AccountLaunch;
use Seara\Models\Company;
use Seara\FinancialAccount;
use Seara\FinancialEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $request->validate([
            'month_financial' => 'required|integer|min:1|max:12',
            'year_financial' => 'required',
            'company_id' => 'required|integer'
        ]);

        $carbonDate = Carbon::createFromFormat('y', $request->year_financial);
        $fullYear = $carbonDate->year;

        $companyId = $request->company_id;

        // Usa $this->monthlyReportService 👈 NOVO SERVICE
        $report = $this->monthlyReportService->getMonthlyReport(
            $request->month_financial,
            $fullYear,
            $companyId
        );

        // Calcula saldo de bancos e caixa até o final do mês/ano especificado
        $endDate = Carbon::create($fullYear, $request->month_financial, 1)->endOfMonth()->endOfDay();

        $totalBanks = $this->calculateTotalBalanceByType($endDate, $companyId, 'bank');
        $totalCash = $this->calculateTotalBalanceByType($endDate, $companyId, 'cash');
        $totalGeneral = $totalBanks + $totalCash;

        // Buscar dados da empresa
        $company = Company::find($companyId);

        $pdf = \PDF::loadView('financial.reports.monthly-pdf', compact('report', 'company', 'totalBanks', 'totalCash', 'totalGeneral'));
        $pdf->setPaper('A4', 'portrait');

        $filename = 'relatorio-' . str_pad($request->month_financial, 2, '0', STR_PAD_LEFT) . '-' . $fullYear . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Calcula o saldo total de contas por tipo até uma data específica
     *
     * @param Carbon $endDate Data final para cálculo
     * @param int $companyId ID da empresa
     * @param string $accountType Tipo da conta ('bank' ou 'cash')
     * @return float Saldo calculado
     */
    private function calculateTotalBalanceByType($endDate, $companyId, $accountType)
    {
        $result = FinancialEntry::select(
                DB::raw('SUM(CASE WHEN financial_entries.type = "credit" THEN financial_entries.amount ELSE -financial_entries.amount END) as balance')
            )
            ->join('financial_accounts', 'financial_entries.account_id', '=', 'financial_accounts.id')
            ->where('financial_accounts.company_id', $companyId)
            ->where('financial_accounts.type', $accountType)
            ->where('financial_entries.entry_date', '<=', $endDate)
            ->first();

        return $result->balance ?? 0;
    }
}