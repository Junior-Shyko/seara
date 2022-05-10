<?php

declare(strict_types=1);

namespace Seara\Http\Controllers;

use App;
use Seara\Service\Core\Util\DatabaseCleaner;
use Seara\Service\Core\Util\DatabaseSeed;

class SeedController extends Controller
{
    public function __invoke(string $seed)
    {
        if (!App::environment(['local', 'testing'])) {
            abort(404);
        }

        if ('clean' === $seed) {
            DatabaseCleaner::cleanDatabase();
            return;
        }

        DatabaseSeed::seedDatabase($seed);
    }
}
