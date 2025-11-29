<?php

namespace Seara\Service;

use Seara\FinancialEntry;
use Seara\FinancialAccount;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MonthlyFinancialReportService
{
    /**
     * Gera relatório mensal
     * 
     * @param int $month Mês (1-12)
     * @param int $year Ano (ex: 2023)
     * @param int $companyId
     * @return array
     */
    public function getMonthlyReport($month, $year, $companyId)
    {
        // Validar mês e ano
        if ($month < 1 || $month > 12) {
            throw new \InvalidArgumentException('Mês inválido. Deve estar entre 1 e 12.');
        }
        
        if ($year < 2000 || $year > 2100) {
            throw new \InvalidArgumentException('Ano inválido.');
        }
        
        // Datas do período
        $startDate = Carbon::create($year, $month, 1)->startOfDay();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth()->endOfDay();
       
        // Saldo anterior (até o último dia do mês anterior)
        $previousBalance = $this->getPreviousBalance($startDate, $companyId);
        
        // Buscar RECEITAS agrupadas por categoria
        $receitas = $this->getIncomeByCategory($startDate, $endDate, $companyId);
        
        // Buscar DESPESAS agrupadas por categoria
        $despesas = $this->getExpensesByCategory($startDate, $endDate, $companyId);
        
        // Totais
        $totalReceitas = $receitas->sum('total');
        $totalDespesas = $despesas->sum('total');
        $saldoPeriodo = $totalReceitas - $totalDespesas;
        $saldoFinal = $previousBalance + $saldoPeriodo;
        
        return [
            'period' => [
                'month' => $month,
                'month_name' => $this->getMonthName($month),
                'year' => $year,
                'start' => $startDate,
                'end' => $endDate,
                'formatted' => strtoupper($this->getMonthName($month)) . ' DE ' . $year
            ],
            'previous_balance' => $previousBalance,
            'receitas' => $receitas,
            'despesas' => $despesas,
            'totals' => [
                'receitas' => $totalReceitas,
                'receitas_formatted' => 'R$ ' . number_format($totalReceitas, 2, ',', '.'),
                'despesas' => $totalDespesas,
                'despesas_formatted' => 'R$ ' . number_format($totalDespesas, 2, ',', '.'),
                'saldo_periodo' => $saldoPeriodo,
                'saldo_periodo_formatted' => 'R$ ' . number_format($saldoPeriodo, 2, ',', '.'),
                'saldo_final' => $saldoFinal,
                'saldo_final_formatted' => 'R$ ' . number_format($saldoFinal, 2, ',', '.')
            ],
            'summary' => [
                'total_receitas_count' => $receitas->sum('quantidade'),
                'total_despesas_count' => $despesas->sum('quantidade')
            ]
        ];
    }
    
    /**
     * Busca saldo anterior ao período
     */
    private function getPreviousBalance($startDate, $companyId)
    {
        $result = FinancialEntry::select(
                DB::raw('SUM(CASE WHEN type = "credit" THEN amount ELSE -amount END) as balance')
            )
            ->whereHas('transaction', function($q) use ($companyId) {
                $q->where('company_id', $companyId)
                  ->whereIn('type', ['income', 'expense']);
            })
            ->where('entry_date', '<', $startDate)
            ->first();
        
        return $result->balance ?? 0;
    }
    
    /**
     * Busca receitas agrupadas por categoria
     */
    private function getIncomeByCategory($startDate, $endDate, $companyId)
    {
        return FinancialEntry::select(
                'category_id',
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as quantidade')
            )
            ->with(['category:id,accountlaunch_name'])
            ->whereHas('transaction', function($q) use ($companyId) {
                $q->where('company_id', $companyId)
                  ->where('type', 'income');
            })
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->where('type', 'credit')
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->orderBy('total', 'DESC')
            ->get()
            ->map(function($item) {
                return [
                    'category_id' => $item->category_id,
                    'historico' => $item->category ? $item->category->accountlaunch_name : 'Sem Categoria',
                    'total' => $item->total,
                    'total_formatted' => number_format($item->total, 2, ',', '.'),
                    'quantidade' => $item->quantidade
                ];
            });
    }
    
    /**
     * Busca despesas agrupadas por categoria
     */
    private function getExpensesByCategory($startDate, $endDate, $companyId)
    {
        return FinancialEntry::select(
                'category_id',
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as quantidade')
            )
            ->with(['category:id,accountlaunch_name'])
            ->whereHas('transaction', function($q) use ($companyId) {
                $q->where('company_id', $companyId)
                  ->where('type', 'expense');
            })
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->where('type', 'debit')
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->orderBy('total', 'DESC')
            ->get()
            ->map(function($item) {
                return [
                    'category_id' => $item->category_id,
                    'historico' => $item->category ? $item->category->accountlaunch_name : 'Sem Categoria',
                    'total' => $item->total,
                    'total_formatted' => number_format($item->total, 2, ',', '.'),
                    'quantidade' => $item->quantidade
                ];
            });
    }
    
    /**
     * Retorna nome do mês em português
     */
    private function getMonthName($month)
    {
        $months = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março',
            4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
            7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro',
            10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ];
        
        return $months[$month];
    }
}