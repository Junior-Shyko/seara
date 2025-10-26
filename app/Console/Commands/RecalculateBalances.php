<?php

namespace Seara\Console\Commands;

use Seara\FinancialEntry;
use Seara\FinancialAccount;
use Illuminate\Console\Command;

class RecalculateBalances extends Command
{
    protected $signature = 'balances:recalculate {--company=}';
    protected $description = 'Recalcula saldos das contas baseado nas entries';

    public function handle()
    {
        $companyId = $this->option('company');
        
        $query = FinancialAccount::query();
        
        if ($companyId) {
            $query->where('company_id', $companyId);
        }
        
        $accounts = $query->get();
        
        $this->info("🔄 Recalculando saldos de {$accounts->count()} contas...\n");
        
        foreach ($accounts as $account) {
            $oldBalance = $account->current_balance;
            
            $newBalance = FinancialEntry::where('account_id', $account->id)
                ->selectRaw('SUM(CASE WHEN type = "credit" THEN amount ELSE -amount END) as total')
                ->value('total') ?? 0;
            
            $account->update(['current_balance' => $newBalance]);
            
            $diff = $newBalance - $oldBalance;
            $icon = abs($diff) < 0.01 ? '✅' : '🔄';
            
            $this->line("{$icon} {$account->name}:");
            $this->line("   Antigo: R$ " . number_format($oldBalance, 2, ',', '.'));
            $this->line("   Novo:   R$ " . number_format($newBalance, 2, ',', '.'));
            
            if (abs($diff) >= 0.01) {
                $this->warn("   Diferença: R$ " . number_format($diff, 2, ',', '.'));
            }
            
            $this->line('');
        }
        
        $this->info("✅ Recálculo concluído!");
        
        return 0;
    }
}
