<?php

declare(strict_types=1);

namespace App\Service\Core\Util;

class SeederRunner
{
    public static function runSeeder(string $seederClass)
    {
        app()->make($seederClass)
            ->run();
    }
}
