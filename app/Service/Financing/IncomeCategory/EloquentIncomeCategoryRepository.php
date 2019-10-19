<?php

declare(strict_types=1);

namespace App\Service\Financing\IncomeCategory;

use App\IncomeCategory;
use App\Service\Core\UuidIdentifier;

class EloquentIncomeCategoryRepository implements IncomeCategoryRepository
{
    use UuidIdentifier;

    public function save(array $categoryData)
    {
        $incomeCategory = new IncomeCategory();
        $incomeCategory->fill($categoryData);
        $incomeCategory->save();
    }
}
