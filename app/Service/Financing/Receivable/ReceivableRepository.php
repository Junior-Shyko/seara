<?php

declare(strict_types=1);

namespace App\Service\Financing\Receivable;

use App\Receivable;
use App\Service\Core\UuidRepository;

interface ReceivableRepository extends UuidRepository
{
    /**
     * Saves a receivable
     * @param array $receivable
     */
    public function save(array $receivable): void;

    /**
     * Finds a receivable
     * @param string $id
     * @return Receivable
     * @throws ReceivableNotFound
     */
    public function find(string $id): Receivable;

    /**
     * Updates a receivable
     * @param string $id
     * @param array $receivable
     * @throws ReceivableNotFound
     */
    public function update(string $id, array $receivable): void;
}
