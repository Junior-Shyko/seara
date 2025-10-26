<?php

declare(strict_types=1);

namespace Seara\Service\Financing\IncomeCategory;

use Seara\IncomeCategory;
use Seara\Service\Core\UuidIdentifier;
use Illuminate\Database\Eloquent\Collection;

class EloquentIncomeCategoryRepository implements IncomeCategoryRepository
{
    use UuidIdentifier;

    public function save(array $categoryData): void
    {
        $incomeCategory = new IncomeCategory();
        $incomeCategory->fill($categoryData);
        $incomeCategory->save();
    }

    public function find(string $id): IncomeCategory
    {
        If ($category = IncomeCategory::find($id)) {
            return $category;
        }
        throw IncomeCategoryNotFound::withId($id);
    }

    public function update(string $id, array $categoryData): void
    {
        $category = $this->find($id);
        $category->fill($categoryData)
            ->save();
    }

    public function findAll(): Collection
    {
        return IncomeCategory::all();
    }
}
