<?php

declare(strict_types=1);

namespace App\Service\Core\Transactor;

use Throwable;

interface Transactor
{
    /**
     * Performs an action in a transaction and if any error is throw, it
     * rolls back
     *
     * @param callable $action
     * @throws Throwable
     */
    public function perform(callable $action): void;
}
