<?php

namespace Seara\Service\Financial;

use Seara\FinancialEntry;
use Seara\AccountLaunch;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Seara\Repository\SettingsBoxRepository;

class FinancialReportService
{
    /**
     * Gera relatório por categoria entre duas datas
     *
     * @param string $startDate Formato dd/mm/yyyy
     * @param string $endDate Formato dd/mm/yyyy
     * @param int $companyId
     * @return array
     */
    public function getReportByCategory($startDate, $endDate, $companyId)
    {
        $dateStart = SettingsBoxRepository::convertDateToFullYear($startDate);
        $dateEnd = SettingsBoxRepository::convertDateToFullYear($endDate);
        // Converter datas de dd/mm/yyyy para Y-m-d
        $start = Carbon::createFromFormat('d/m/Y', $dateStart)->startOfDay();
        $end = Carbon::createFromFormat('d/m/Y', $dateEnd)->endOfDay();

        // Query principal: Agrupa por categoria
        $reportData = FinancialEntry::select(
                'category_id',
                DB::raw('SUM(CASE 
                    WHEN type = "credit" THEN amount 
                    WHEN type = "debit" THEN -amount 
                    ELSE 0 
                END) as total')
            )
            ->with(['category:id,accountlaunch_name,accountlaunch_type'])
            ->whereBetween('entry_date', [$start, $end])
            ->where('company_id', $companyId)
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->orderBy('total', 'DESC')
            ->get();

        // Calcular totais gerais
        $totalIncome = 0;
        $totalExpense = 0;
           
        $categories = $reportData->map(function ($item) use (&$totalIncome, &$totalExpense, $start, $end, $companyId) {
            $isIncome = $item->total > 0;
           
            if ($isIncome) {
                $totalIncome += $item->total;
            } else {
                $totalExpense += abs($item->total);
            }

            return [
                'category_id' => $item->category_id,
                'category_name' => $item->category ? $item->category->accountlaunch_name : 'Sem Categoria',
                'total' => $item->total,
                'total_formatted' => 'R$ ' . number_format(abs($item->total), 2, ',', '.'),
                'type' => $isIncome ? 'income' : 'expense',
                'type_label' => $isIncome ? 'Receita' : 'Despesa',
                'count' => $this->getEntriesCountByCategory($item->category_id, $start, $end, $companyId)
            ];
        });

        // Saldo final
        $balance = $totalIncome - $totalExpense;

        return [
            'period' => [
                'start' => $start->format('d/m/Y'),
                'end' => $end->format('d/m/Y'),
                'start_carbon' => $start,
                'end_carbon' => $end
            ],
            'categories' => $categories,
            'totals' => [
                'income' => $totalIncome,
                'income_formatted' => 'R$ ' . number_format($totalIncome, 2, ',', '.'),
                'expense' => $totalExpense,
                'expense_formatted' => 'R$ ' . number_format($totalExpense, 2, ',', '.'),
                'balance' => $balance,
                'balance_formatted' => 'R$ ' . number_format($balance, 2, ',', '.'),
                'balance_class' => $balance >= 0 ? 'text-success' : 'text-danger'
            ],
            'summary' => [
                'total_entries' => $this->getTotalEntries($start, $end, $companyId),
                'total_categories' => $categories->count()
            ]
        ];
    }

    /**
     * Conta quantos lançamentos existem por categoria
     */
    private function getEntriesCountByCategory($categoryId, $start, $end, $companyId)
    {
        return FinancialEntry::where('category_id', $categoryId)
            ->whereBetween('entry_date', [$start, $end])
            ->where('company_id', $companyId)
            ->count();
    }

    /**
     * Total de lançamentos no período
     */
    private function getTotalEntries($start, $end, $companyId)
    {
        return FinancialEntry::whereBetween('entry_date', [$start, $end])
            ->where('company_id', $companyId)
            ->count();
    }

    /**
     * Relatório detalhado por categoria (com lançamentos individuais)
     */
    public function getDetailedReportByCategory($startDate, $endDate, $companyId)
    {
        $start = Carbon::createFromFormat('d/m/Y', $startDate)->startOfDay();
        $end = Carbon::createFromFormat('d/m/Y', $endDate)->endOfDay();

        $categories = AccountLaunch::whereHas('financialEntries', function ($query) use ($start, $end, $companyId) {
                $query->whereBetween('entry_date', [$start, $end])
                      ->where('company_id', $companyId);
            })
            ->with(['financialEntries' => function ($query) use ($start, $end, $companyId) {
                $query->whereBetween('entry_date', [$start, $end])
                      ->where('company_id', $companyId)
                      ->orderBy('entry_date', 'DESC');
            }])
            ->get();

        $report = [];
        $totalIncome = 0;
        $totalExpense = 0;

        foreach ($categories as $category) {
            $categoryTotal = 0;
            $entries = [];

            foreach ($category->financialEntries as $entry) {
                $value = $entry->type === 'credit' ? $entry->amount : -$entry->amount;
                $categoryTotal += $value;

                $entries[] = [
                    'id' => $entry->id,
                    'date' => $entry->entry_date->format('d/m/Y'),
                    'description' => $entry->description,
                    'type' => $entry->type,
                    'amount' => $entry->amount,
                    'amount_formatted' => 'R$ ' . number_format($entry->amount, 2, ',', '.'),
                    'value_signed' => $value,
                    'account' => $entry->account ? $entry->account->name : '-'
                ];
            }

            if ($categoryTotal > 0) {
                $totalIncome += $categoryTotal;
            } else {
                $totalExpense += abs($categoryTotal);
            }

            $report[] = [
                'category_id' => $category->id,
                'category_name' => $category->accountlaunch_name,
                'total' => $categoryTotal,
                'total_formatted' => 'R$ ' . number_format(abs($categoryTotal), 2, ',', '.'),
                'type' => $categoryTotal > 0 ? 'income' : 'expense',
                'entries' => $entries,
                'entries_count' => count($entries)
            ];
        }

        return [
            'period' => [
                'start' => $start->format('d/m/Y'),
                'end' => $end->format('d/m/Y')
            ],
            'categories' => $report,
            'totals' => [
                'income' => $totalIncome,
                'income_formatted' => 'R$ ' . number_format($totalIncome, 2, ',', '.'),
                'expense' => $totalExpense,
                'expense_formatted' => 'R$ ' . number_format($totalExpense, 2, ',', '.'),
                'balance' => $totalIncome - $totalExpense,
                'balance_formatted' => 'R$ ' . number_format($totalIncome - $totalExpense, 2, ',', '.')
            ]
        ];
    }
}