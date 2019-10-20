<?php

declare(strict_types=1);

namespace App\Service\Core\Util;

class SeederRunner
{
    public static function create()
    {
        return new self();
    }

    public function run(string $seederClass)
    {
        app()->make($seederClass)
            ->run();
    }
}
