<?php

declare(strict_types=1);

namespace App\Service\Financing\IncomeCategory;

class CreateIncomeCategory
{
    /**
     * @var IncomeCategoryRepository
     */
    private $repository;

    public function __construct(
        IncomeCategoryRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function execute(array $category)
    {
        $id = $this->repository->nextIdentity();
        $category['id'] = $id;
        $this->repository->save($category);
    }
}
