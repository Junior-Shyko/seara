<?php

namespace Seara\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Seara\FileLaunch;
use Seara\Transaction;
use Seara\FinancialEntry;

class MigrateFileLaunches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file-launches:migrate
                            {--dry-run : Simula a migração sem salvar}
                            {--company= : ID da empresa para migrar (opcional)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra file_launches para usar transaction_id ao invés de entries_id';

    private $stats = [
        'migrados' => 0,
        'pulados' => 0,
        'erros' => 0,
    ];

    private $isDryRun = false;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->isDryRun = $this->option('dry-run');
        $companyId = $this->option('company');

        $this->info('🚀 Iniciando migração de file_launches...');

        if ($this->isDryRun) {
            $this->warn('⚠️  MODO DRY-RUN: Nenhum dado será salvo no banco');
        }

        // Buscar file_launches que ainda não foram migrados
        $query = FileLaunch::whereNotNull('file_launches_id_entry')
            ->whereNull('transaction_id');

        if ($companyId) {
            // Filtrar por empresa através do join com entries
            $query->join('entries', 'file_launches.file_launches_id_entry', '=', 'entries.entries_id')
                ->where('entries.entries_id_company', $companyId)
                ->select('file_launches.*');
        }

        $fileLaunches = $query->get();
        $total = $fileLaunches->count();

        if ($total === 0) {
            $this->info('✅ Nenhum file_launch precisa ser migrado!');
            return 0;
        }

        $this->info("📦 Encontrados {$total} file_launches para migrar");
        $bar = $this->output->createProgressBar($total);

        foreach ($fileLaunches as $fileLaunch) {
            try {
                $this->migrateFileLaunch($fileLaunch);
            } catch (\Exception $e) {
                $this->stats['erros']++;
                $this->error("\n❌ Erro no file_launch {$fileLaunch->id}: " . $e->getMessage());

                \Log::error("Erro migração file_launch {$fileLaunch->id}", [
                    'message' => $e->getMessage(),
                    'file_launch' => $fileLaunch
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->line('');

        $this->showStats();

        return 0;
    }

    /**
     * Migra um file_launch individual
     */
    private function migrateFileLaunch($fileLaunch)
    {
        $entryId = $fileLaunch->file_launches_id_entry;

        // Buscar a entrada antiga
        $oldEntry = DB::table('entries')->where('entries_id', $entryId)->first();

        if (!$oldEntry) {
            $this->warn("\n⚠️  Entry {$entryId} não encontrada para file_launch {$fileLaunch->id}");
            $this->stats['pulados']++;
            return;
        }

        // Buscar a transaction correspondente
        // A transaction foi criada a partir da entry antiga, então precisamos encontrá-la
        // através dos dados correspondentes
        $transaction = null;

        // Estratégia 1: Buscar pela data, valor e empresa
        $transaction = Transaction::where('company_id', $oldEntry->entries_id_company)
            ->where('total_amount', abs($oldEntry->entries_value))
            ->whereDate('created_at', '>=', $oldEntry->entries_date_launch)
            ->whereDate('created_at', '<=', date('Y-m-d', strtotime($oldEntry->entries_date_launch . ' +1 day')))
            ->first();

        // Estratégia 2: Se não encontrou, buscar pela financial_entry que tem a mesma data de lançamento
        if (!$transaction) {
            $financialEntry = FinancialEntry::where('company_id', $oldEntry->entries_id_company)
                ->where('amount', abs($oldEntry->entries_value))
                ->whereDate('entry_date', $oldEntry->entries_date_launch)
                ->first();

            if ($financialEntry) {
                $transaction = $financialEntry->transaction;
            }
        }

        if (!$transaction) {
            $this->warn("\n⚠️  Transaction não encontrada para entry {$entryId} (file_launch {$fileLaunch->id})");
            $this->stats['pulados']++;
            return;
        }

        // Atualizar o file_launch com a transaction_id
        if (!$this->isDryRun) {
            $fileLaunch->transaction_id = $transaction->id;
            $fileLaunch->save();
        }

        $this->stats['migrados']++;
    }

    /**
     * Exibe estatísticas
     */
    private function showStats()
    {
        $this->info("\n\n📊 ESTATÍSTICAS DA MIGRAÇÃO:");
        $this->table(
            ['Status', 'Quantidade'],
            [
                ['✅ Migrados', $this->stats['migrados']],
                ['⚠️  Pulados', $this->stats['pulados']],
                ['❌ Erros', $this->stats['erros']],
            ]
        );

        if ($this->isDryRun) {
            $this->warn("\n⚠️  Migração simulada - nenhum dado foi alterado");
        } else {
            $this->info("\n🎉 Migração concluída!");
        }
    }
}
