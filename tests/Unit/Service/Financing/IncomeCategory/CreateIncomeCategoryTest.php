<?php

declare(strict_types=1);

namespace Tests\Unit\Service\Financing\IncomeCategory;

use App\Service\Financing\IncomeCategory\CreateIncomeCategory;
use App\Service\Financing\IncomeCategory\IncomeCategoryRepository;
use PHPUnit\Framework\TestCase;

class CreateIncomeCategoryTest extends TestCase
{
    /**
     * @var IncomeCategoryRepository
     */
    private $repository;

    protected function setUp()
    {
        $this->repository = $this->createMock(IncomeCategoryRepository::class);
    }

    /**
     * @test
     */
    public function it_creates_the_account()
    {
        $id = 'uuid';
        $category = [
            'name' => 'Contratos'
        ];

        $this->repository
            ->method('nextIdentity')
            ->willReturn($id);

        $this->repository
            ->expects($this->once())
            ->method('save')
            ->with([
                'name' => 'Contratos',
                'id' => $id
            ]);

        $createIncomeCategory = new CreateIncomeCategory($this->repository);
        $createIncomeCategory->execute($category);
    }
}
