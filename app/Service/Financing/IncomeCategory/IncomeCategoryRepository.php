<?php

declare(strict_types=1);

namespace App\Service\Financing\IncomeCategory;

use App\Service\Core\UuidRepository;

interface IncomeCategoryRepository extends UuidRepository
{
    public function save(array $categoryData);
}
