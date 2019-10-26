<?php

declare(strict_types=1);

namespace App\Service\Financing\Receivable;

use App\Service\Core\UuidRepository;

interface ReceivableRepository extends UuidRepository
{
    /**
     * Saves a receivable
     * @param array $receivable
     */
    public function save(array $receivable): void;
}
