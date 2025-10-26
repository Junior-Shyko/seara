<?php
declare(strict_types=1);

namespace Seara\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Seara\FinancialAccount;
use Seara\Transaction;
use Seara\FinancialEntry;
use Seara\TransferDetail;
use Carbon\Carbon;

class MigrateOldEntries extends Command
{
    protected $signature = 'entries:migrate 
                            {--company= : ID da empresa para migrar (opcional)}
                            {--dry-run : Simula a migração sem salvar}
                            {--rollback : Desfaz a última migração}';

    protected $description = 'Migra dados da tabela entries antiga para a nova estrutura';

    private $stats = [
        'receitas' => 0,
        'despesas' => 0,
        'transferencias' => 0,
        'erros' => 0,
        'pulados' => 0
    ];

    private $accountMap = []; // Mapeia entries_bank → financial_accounts.id
    private $processedTransfers = []; // Evita duplicar transferências
    private $isDryRun = false;

    public function handle()
    {
        $this->isDryRun = $this->option('dry-run');

        if ($this->option('rollback')) {
            return $this->rollbackMigration();
        }

        $this->info('🚀 Iniciando migração de lançamentos...');

        if ($this->isDryRun) {
            $this->warn('⚠️  MODO DRY-RUN: Nenhum dado será salvo no banco');
        }

        // Passo 1: Mapear contas
        $this->info('📋 Mapeando contas bancárias...');
        $this->mapAccounts();

        // Passo 2: Migrar lançamentos
        $companyId = $this->option('company');
        $this->info('📦 Migrando lançamentos' . ($companyId ? " da empresa $companyId" : ' de todas as empresas') . '...');

        $this->migrateEntries($companyId);

         // Recalcular saldos
        if (!$this->isDryRun) {
            $this->recalculateBalances($companyId);
        }

        // Passo 3: Estatísticas
        $this->showStats();

        return 0;
    }

    /**
     * Mapeia account_banks → financial_accounts
     */
    private function mapAccounts()
    {
        $this->info('📋 Mapeando contas bancárias...');
        
        // CRIAR CAIXA INTERNO PARA CADA EMPRESA
        $companies = DB::table('companies')->pluck('company_id');
        
        foreach ($companies as $companyId) {
            $caixaInterno = FinancialAccount::firstOrCreate(
                [
                    'company_id' => $companyId,
                    'type' => 'cash',
                    'name' => 'Caixa Interno'
                ],
                [
                    'current_balance' => 0,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );

            // ❌ NÃO FAZER ISSO:
            // $this->accountMap[0] = $caixaInterno->id;
            
            // ✅ FAZER ASSIM (mapear por empresa):
            $this->accountMap["cash_{$companyId}"] = $caixaInterno->id; // 👈 CHAVE COMPOSTA
            
            $this->line("  ✓ Caixa Interno empresa {$companyId}: ID {$caixaInterno->id}");
        }

        // MAPEAR BANCOS EXISTENTES
        $oldBanks = DB::table('account_banks')->get();
        
        foreach ($oldBanks as $bank) {
            $financialAccount = FinancialAccount::where('company_id', $bank->company_id)
                ->where('account_number', $bank->number)
                ->first();

            if (!$financialAccount) {
                $bankName = DB::table('banks')->where('id', $bank->bank_id)->value('name') ?? 'Banco';
                
                $financialAccount = FinancialAccount::create([
                    'company_id' => $bank->company_id,
                    'type' => 'bank',
                    'name' => $bank->number . ' - ' . $bankName,
                    'bank_id' => $bank->bank_id,
                    'account_number' => $bank->number,
                    'agency_number' => $bank->agency_number,
                    'current_balance' => 0,
                    'is_active' => true,
                    'created_at' => $bank->created_at,
                    'updated_at' => $bank->updated_at
                ]);
            } else {
                // Se já existe, zerar
                $financialAccount->update(['current_balance' => 0]);
            }

            // Mapear banco por ID original
            $this->accountMap["bank_{$bank->id}"] = $financialAccount->id; // 👈 PREFIXO "bank_"
            
            $this->line("  ✓ Banco {$bank->number}: ID {$financialAccount->id}");
        }

        $this->info('✅ ' . count($this->accountMap) . ' contas mapeadas');
    }

    /**
     * Migra os lançamentos
     */
    private function migrateEntries($companyId = null)
    {
        $query = DB::table('entries')
            ->orderBy('entries_date_launch')
            ->orderBy('entries_id');

        if ($companyId) {
            $query->where('entries_id_company', $companyId);
        }

        $entries = $query->get();
        $bar = $this->output->createProgressBar($entries->count());
        
        foreach ($entries as $entry) {
            try {
                // Condição CORRETA para identificar transferência
                if ($entry->transaction_id == 1 && $entry->entries_parent !== null) {
                    // É transferência REAL
                    $this->migrateTransfer($entry);
                } else {
                    // É receita ou despesa
                    $this->migrateSimpleEntry($entry);
                }
            } catch (\Exception $e) {
                $this->stats['erros']++;
                $this->error("\n❌ Erro no entry {$entry->entries_id}: " . $e->getMessage());

                // Log detalhado
                \Log::error("Erro migração entry {$entry->entries_id}", [
                    'message' => $e->getMessage(),
                    'entry' => $entry
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->line('');
    }

    /**
     * Migra receita ou despesa simples
     */
    private function migrateSimpleEntry($oldEntry)
    {
        // Determinar tipo (income ou expense)
        $accountTypeQuery = DB::table('account_launches')
        ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
        ->where('account_launches.id', $oldEntry->entries_id_account)
        ->select('account_types.account_types_name')
        ->first();

        if (!$accountTypeQuery || !$accountTypeQuery->account_types_name) {
            $this->warn("\n⚠️  Categoria não encontrada para entry {$oldEntry->entries_id}");
            $this->stats['pulados']++;
            return;
        }

        $accountTypeLower = strtolower($accountTypeQuery->account_types_name);
        // Determinar se é receita ou despesa
        $type = null;
        $entryType = null;

        if (stripos($accountTypeLower, 'receita') !== false) {
            $type = 'income';
            $entryType = 'credit';
            $this->stats['receitas']++;
        } elseif (stripos($accountTypeLower, 'despesa') !== false) {
            $type = 'expense';
            $entryType = 'debit';
            $this->stats['despesas']++;
        } else {
            $this->warn("\n⚠️  Tipo não reconhecido: '{$accountTypeLower}' (entry {$oldEntry->entries_id})");
            $this->stats['pulados']++;
            return;
        }

        if ($this->isDryRun) return;

        // DETERMINAR CONTA CORRETAMENTE
        $accountId = null;
        
        // Se entries_bank for 0 ou NULL → é CAIXA INTERNO
        if (empty($oldEntry->entries_bank) || $oldEntry->entries_bank == 0) {
            $mapKey = "cash_{$oldEntry->entries_id_company}"; // 👈 Buscar caixa da empresa
            $accountId = $this->accountMap[$mapKey] ?? null;
            
            if (!$accountId) {
                // Fallback: buscar direto no banco
                $caixaInterno = FinancialAccount::where('company_id', $oldEntry->entries_id_company)
                    ->where('type', 'cash')
                    ->first();
                
                if (!$caixaInterno) {
                    throw new \Exception("Caixa interno não encontrado para empresa {$oldEntry->entries_id_company}");
                }
                
                $accountId = $caixaInterno->id;
                $this->accountMap[$mapKey] = $accountId; // Adicionar ao mapa
                
                $this->warn("\n⚠️  Caixa interno criado dinamicamente para empresa {$oldEntry->entries_id_company}");
            }
        } else {
            // É BANCO
            $mapKey = "bank_{$oldEntry->entries_bank}";
            $accountId = $this->accountMap[$mapKey] ?? null;
            
            if (!$accountId) {
                throw new \Exception("Banco não mapeado: entries_bank = {$oldEntry->entries_bank}, company = {$oldEntry->entries_id_company}");
            }
        }

        // Criar Transaction
        $transaction = Transaction::create([
            'uuid' => $this->generateUuid(),
            'type' => $type,
            'status' => 'completed',
            'description' => $oldEntry->entries_description ?: 'Lançamento migrado',
            'total_amount' => abs($oldEntry->entries_value),
            'company_id' => $oldEntry->entries_id_company,
            'created_by_user_id' => $oldEntry->entries_id_user ?? 1,
            'created_at' => $oldEntry->created_at ?? now(),
            'updated_at' => $oldEntry->updated_at ?? now()
        ]);

        // Criar Financial Entry
        FinancialEntry::create([
            'transaction_id' => $transaction->id,
            'account_id' => $accountId, // 👈 Agora está correto!
            'category_id' => $oldEntry->entries_id_account,
            'type' => $entryType,
            'description' => $oldEntry->entries_description ?: 'Lançamento migrado',
            'amount' => abs($oldEntry->entries_value),
            'entry_date' => Carbon::parse($oldEntry->entries_date_launch),
            'document_file' => !empty($oldEntry->entries_file) ? $oldEntry->entries_file : null,
            'company_id' => $oldEntry->entries_id_company,
            'created_by_user_id' => $oldEntry->entries_id_user ?? 1,
            'created_at' => $oldEntry->created_at ?? now(),
            'updated_at' => $oldEntry->updated_at ?? now()
        ]);
    }

    /**
     * Migra transferência
     */
    private function migrateTransfer($oldEntry)
    {
        // Criar chave única para evitar duplicação
        $transferKey = md5($oldEntry->entries_value . $oldEntry->entries_date_launch . $oldEntry->entries_id_company);

        if (in_array($transferKey, $this->processedTransfers)) {
            return; // Já processou esta transferência
        }

        // Buscar o par da transferência (condição corrigida)
        $pairEntry = DB::table('entries')
            ->where('transaction_id', 1)
            ->whereNotNull('entries_parent') // 👈 ADICIONAR ESTA VALIDAÇÃO
            ->where('entries_id', '!=', $oldEntry->entries_id)
            ->where('entries_value', $oldEntry->entries_value)
            ->where('entries_date_launch', $oldEntry->entries_date_launch)
            ->where('entries_id_company', $oldEntry->entries_id_company)
            ->first();

        if (!$pairEntry) {
            $this->warn("\n⚠️  Transferência sem par: entry {$oldEntry->entries_id}");
            $this->stats['erros']++;
            return;
        }

        // Determinar origem e destino
        $debitEntry = $oldEntry->entries_parent == -1 ? $oldEntry : $pairEntry;
        $creditEntry = $oldEntry->entries_parent == -1 ? $pairEntry : $oldEntry;
// MAPEAR CONTAS CORRETAMENTE
        $fromAccountId = null;
        $toAccountId = null;

        // Conta origem (débito)
        if (empty($debitEntry->entries_bank) || $debitEntry->entries_bank == 0) {
            $mapKey = "cash_{$debitEntry->entries_id_company}";
            $fromAccountId = $this->accountMap[$mapKey] ?? null;
        } else {
            $mapKey = "bank_{$debitEntry->entries_bank}";
            $fromAccountId = $this->accountMap[$mapKey] ?? null;
        }

        // Conta destino (crédito)
        if (empty($creditEntry->entries_bank) || $creditEntry->entries_bank == 0) {
            $mapKey = "cash_{$creditEntry->entries_id_company}";
            $toAccountId = $this->accountMap[$mapKey] ?? null;
        } else {
            $mapKey = "bank_{$creditEntry->entries_bank}";
            $toAccountId = $this->accountMap[$mapKey] ?? null;
        }

        if (!$fromAccountId || !$toAccountId) {
            throw new \Exception("Contas não mapeadas na transferência: from={$debitEntry->entries_bank}, to={$creditEntry->entries_bank}");
        }


        // Criar Transaction
        $transaction = Transaction::create([
            'uuid' => $this->generateUuid(),
            'type' => 'transfer',
            'status' => 'completed',
            'description' => $oldEntry->entries_description ?: 'Transferência',
            'total_amount' => abs($oldEntry->entries_value),
            'from_account_id' => $fromAccountId,
            'to_account_id' => $toAccountId,
            'company_id' => $oldEntry->entries_id_company,
            'created_by_user_id' => $oldEntry->entries_id_user ?? 1,
            'created_at' => $oldEntry->created_at ?? now(),
            'updated_at' => $oldEntry->updated_at ?? now()
        ]);

        // Entry débito
        FinancialEntry::create([
            'transaction_id' => $transaction->id,
            'account_id' => $fromAccountId,
            'category_id' => $oldEntry->entries_id_account,
            'type' => 'debit',
            'description' => 'Transferência enviada - ' . ($oldEntry->entries_description ?: ''),
            'amount' => abs($oldEntry->entries_value),
            'entry_date' => Carbon::parse($oldEntry->entries_date_launch),
            'document_file' => !empty($oldEntry->entries_file) ? $oldEntry->entries_file : null,
            'company_id' => $oldEntry->entries_id_company,
            'created_by_user_id' => $oldEntry->entries_id_user ?? 1,
            'created_at' => $debitEntry->created_at ?? now(),
            'updated_at' => $debitEntry->updated_at ?? now()
        ]);

        // Entry crédito
        FinancialEntry::create([
            'transaction_id' => $transaction->id,
            'account_id' => $toAccountId,
            'category_id' => $oldEntry->entries_id_account,
            'type' => 'credit',
            'description' => 'Transferência recebida - ' . ($oldEntry->entries_description ?: ''),
            'amount' => abs($oldEntry->entries_value),
            'entry_date' => Carbon::parse($oldEntry->entries_date_launch),
            'document_file' => !empty($pairEntry->entries_file) ? $pairEntry->entries_file : null,
            'company_id' => $oldEntry->entries_id_company,
            'created_by_user_id' => $oldEntry->entries_id_user ?? 1,
            'created_at' => $creditEntry->created_at ?? now(),
            'updated_at' => $creditEntry->updated_at ?? now()
        ]);

        $this->stats['transferencias']++;
        $this->processedTransfers[] = $transferKey;
    }
    /**
     * Exibe estatísticas
     */
    private function showStats()
    {
        $this->info("\n\n📊 ESTATÍSTICAS DA MIGRAÇÃO:");
        $this->table(
            ['Tipo', 'Quantidade'],
            [
                ['✅ Receitas', $this->stats['receitas']],
                ['✅ Despesas', $this->stats['despesas']],
                ['✅ Transferências', $this->stats['transferencias']],
                ['⚠️  Pulados', $this->stats['pulados']],
                ['❌ Erros', $this->stats['erros']],
            ]
        );

        $total = $this->stats['receitas'] + $this->stats['despesas'] + ($this->stats['transferencias'] * 2);
        $this->info("\n🎉 Total de entries criadas: $total");
    }

    /**
     * Gera UUID
     */
    private function generateUuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * Rollback da migração
     */
    private function rollbackMigration()
    {
        if (!$this->confirm('⚠️  Tem certeza que deseja desfazer a migração? Isso irá deletar todos os dados migrados.')) {
            return 0;
        }

        $this->info('🔄 Revertendo migração...');

        DB::transaction(function() {
            // Deletar apenas dados migrados (com base na data de criação, por exemplo)
            $deleted = DB::table('transactions')
                ->where('created_at', '>=', now()->subHours(24)) // Últimas 24h
                ->delete();

            $this->info("✅ $deleted transactions deletadas");
        });

        return 0;
    }

    /**
     * Recalcula saldos após migração
     */
    private function recalculateBalances($companyId = null)
    {
        $this->info("\n🔄 Recalculando saldos das contas...");

        $query = FinancialAccount::query();
        
        if ($companyId) {
            $query->where('company_id', $companyId);
        }

        $accounts = $query->get();
        
        foreach ($accounts as $account) {
            // Calcular saldo real baseado nas entries
            $balance = FinancialEntry::where('account_id', $account->id)
                ->selectRaw('SUM(CASE WHEN type = "credit" THEN amount ELSE -amount END) as total')
                ->value('total') ?? 0;

            // Atualizar saldo
            $account->update(['current_balance' => $balance]);
            
            $this->line("✓ {$account->name}: R$ " . $balance);
        }
        
        $this->info("✅ Saldos recalculados!");
    }
}