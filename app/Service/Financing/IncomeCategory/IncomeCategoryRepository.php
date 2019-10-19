<?php

declare(strict_types=1);

namespace App\Service\Financing\IncomeCategory;

use App\IncomeCategory;
use App\Service\Core\UuidRepository;

interface IncomeCategoryRepository extends UuidRepository
{
    public function save(array $categoryData): void;

    /**
     * Finds an income category
     *
     * @param string $id
     * @return IncomeCategory
     * @throws IncomeCategoryNotFound
     */
    public function find(string $id): IncomeCategory;

    /**
     * Updates an income category
     *
     * @param string $id
     * @param array $categoryData
     */
    public function update(string $id, array $categoryData): void;
}
