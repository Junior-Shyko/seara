<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App;
use App\Service\Core\Util\DatabaseCleaner;
use App\Service\Core\Util\DatabaseTestSeeder;

class SeedController extends Controller
{
    public function __invoke(string $seed)
    {
        if (!App::environment(['local', 'testing'])) {
            abort(404);
        }
        DatabaseCleaner::cleanDatabase();
        DatabaseTestSeeder::seedDatabase($seed);
    }
}
