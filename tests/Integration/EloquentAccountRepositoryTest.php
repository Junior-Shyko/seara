<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Service\Financing\Account\AccountNotFound;
use App\Service\Financing\Account\EloquentAccountRepository;
use Tests\TestCase;

class EloquentAccountRepositoryTest extends TestCase
{
    /**
     * @var EloquentAccountRepository
     */
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->repository = new EloquentAccountRepository();
    }

    /**
     * @test
     */
    public function it_throws_exception_when_no_account_is_found()
    {
        $this->expectException(AccountNotFound::class);
        $this->expectExceptionMessage("Account of id 'notavalidid' was not found");
        $this->repository->find('notavalidid');
    }
}