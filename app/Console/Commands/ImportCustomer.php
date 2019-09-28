<?php

namespace App\Console\Commands;

use App\Service\Company\CompanyImporter;
use Illuminate\Console\Command;

class ImportCustomer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seara:customer:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports customers from a file';
    /**
     * @var CompanyImporter
     */
    private $importer;

    /**
     * Create a new command instance.
     *
     * @param \App\Service\Company\CompanyImporter $importer
     */
    public function __construct(CompanyImporter $importer)
    {
        parent::__construct();
        $this->importer = $importer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filePath = $this->argument('file');
        $this->info("Importing data from file {$filePath}");
        $this->importer->import($filePath);
        return 0;
    }
}
