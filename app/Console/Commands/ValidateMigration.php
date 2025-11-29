<?php

namespace Seara\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ValidateMigration extends Command
{
    protected $signature = 'entries:validate {company}';
    protected $description = 'Valida a migração comparando dados antigos vs novos';

    public function handle()
    {
        $companyId = $this->argument('company');
        
        $this->info("🔍 Validando migração da empresa {$companyId}...\n");
        
        // 1. Comparar totais
        $old = DB::table('entries as e')
            ->join('account_launches as al', 'e.entries_id_account', '=', 'al.id')
            ->join('account_types as at', 'al.accountlaunch_type', '=', 'at.id')
            ->where('e.entries_id_company', $companyId)
            ->whereIn('at.id', [1, 2])
            ->where(function($q) {
                $q->where('e.transaction_id', '!=', 1)
                  ->orWhereNull('e.entries_parent');
            })
            ->selectRaw('
                SUM(CASE WHEN at.id = 1 THEN e.entries_value ELSE 0 END) as receitas,
                SUM(CASE WHEN at.id = 2 THEN e.entries_value ELSE 0 END) as despesas,
                COUNT(*) as total
            ')
            ->first();
        
        $new = DB::table('financial_entries as fe')
            ->join('transactions as t', 'fe.transaction_id', '=', 't.id')
            ->where('t.company_id', $companyId)
            ->whereIn('t.type', ['income', 'expense'])
            ->selectRaw('
                SUM(CASE WHEN t.type = "income" THEN fe.amount ELSE 0 END) as receitas,
                SUM(CASE WHEN t.type = "expense" THEN fe.amount ELSE 0 END) as despesas,
                COUNT(*) as total
            ')
            ->first();
        
        $this->table(
            ['Métrica', 'Antigo', 'Novo', 'Diferença'],
            [
                [
                    'Total Lançamentos',
                    $old->total,
                    $new->total,
                    $new->total - $old->total
                ],
                [
                    'Receitas',
                    'R$ ' . number_format($old->receitas, 2, ',', '.'),
                    'R$ ' . number_format($new->receitas, 2, ',', '.'),
                    'R$ ' . number_format($new->receitas - $old->receitas, 2, ',', '.')
                ],
                [
                    'Despesas',
                    'R$ ' . number_format($old->despesas, 2, ',', '.'),
                    'R$ ' . number_format($new->despesas, 2, ',', '.'),
                    'R$ ' . number_format($new->despesas - $old->despesas, 2, ',', '.')
                ],
                [
                    'Saldo',
                    'R$ ' . number_format($old->receitas - $old->despesas, 2, ',', '.'),
                    'R$ ' . number_format($new->receitas - $new->despesas, 2, ',', '.'),
                    'R$ ' . number_format(($new->receitas - $new->despesas) - ($old->receitas - $old->despesas), 2, ',', '.')
                ]
            ]
        );
        
        // 2. Verificar saldos por conta
        $this->info("\n📊 Saldos por Conta:");
        
        $accounts = DB::table('financial_accounts')
            ->where('company_id', $companyId)
            ->get();
        
        foreach ($accounts as $account) {
            $calculated = DB::table('financial_entries')
                ->where('account_id', $account->id)
                ->selectRaw('SUM(CASE WHEN type = "credit" THEN amount ELSE -amount END) as balance')
                ->value('balance') ?? 0;
            
            $diff = abs($account->current_balance - $calculated);
            $status = $diff < 0.01 ? '✅' : '❌';
            
            $this->line("{$status} {$account->name}: Registrado R$ " . number_format($account->current_balance, 2, ',', '.') . 
                       " | Calculado R$ " . number_format($calculated, 2, ',', '.'));
        }
        
        return 0;
    }
}
