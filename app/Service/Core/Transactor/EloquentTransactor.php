<?php

declare(strict_types=1);

namespace App\Service\Core\Transactor;

use DB;

class EloquentTransactor implements Transactor
{
    /**
     * @inheritDoc
     */
    public function perform(callable $action): void
    {
        DB::transaction(function () use ($action) {
            $action();
        });
    }
}
