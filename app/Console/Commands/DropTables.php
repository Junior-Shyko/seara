<?php

declare(strict_types=1);

namespace Seara\Console\Commands;

use Seara\Service\Core\Util\DatabaseCleaner;
use Illuminate\Console\Command;

class DropTables extends Command
{
    protected $signature = 'seara:drop-tables';

    protected $description = 'Drop all tables';

    public function handle()
    {
        DatabaseCleaner::dropTables();
    }
}
