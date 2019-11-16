<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Service\Core\Transactor\Transactor;
use DB;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class MigrateViews extends Command
{
    protected $signature = 'migrate:views';

    protected $description = 'Migrate database views';
    /**
     * @var Transactor
     */
    private $transactor;

    public function __construct(Transactor $transactor)
    {
        parent::__construct();
        $this->transactor = $transactor;
    }

    public function handle()
    {
        $path = $this->laravel->basePath() . '/database/views';
        $views = Finder::create()
            ->in($path)
            ->files()
            ->name('*.sql');

        $this->transactor->perform(function () use ($views) {
            /** @var SplFileInfo $view */
            foreach ($views as $view) {
                $viewName = $view->getBasename('.sql');
                $viewStatement = $this->buildViewStatement(
                    $viewName,
                    file_get_contents($view->getRealPath())
                );

                $this->logViewMigration($viewName, $viewStatement);
                DB::statement($viewStatement);
            }
        });
    }

    private function buildViewStatement(string $viewName, string $viewBody): string
    {
        $viewStatement = sprintf("create or replace view `%s` as\n%s", $viewName, $viewBody);
        return $viewStatement;
    }

    private function logViewMigration(string $viewName, string $viewStatement)
    {
        $this->output->writeln("<info>Migrating view {$viewName}</info>");
        $this->output->writeln('---------------------');
        $this->output->writeln($viewStatement);
        $this->output->writeln('---------------------');
    }
}
