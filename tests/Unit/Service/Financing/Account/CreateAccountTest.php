<?php

declare(strict_types=1);

namespace Tests\Unit\Service\Financing\Account;

use App\Service\Financing\Account\AccountRepository;
use App\Service\Financing\Account\CreateAccount;
use PHPUnit\Framework\TestCase;

class CreateAccountTest extends TestCase
{
    /**
     * @test
     */
    public function it_saves_an_account()
    {
        $id = 'myuuid';
        $account = [
            'name' => 'Carteira',
            'type' => 'money'
        ];

        $repository = $this->createMock(AccountRepository::class);
        $repository
            ->expects($this->once())
            ->method('save')
            ->with([
                'name' => 'Carteira',
                'type' => 'money',
                'id' => $id
            ]);

        $repository
            ->method('nextIdentity')
            ->willReturn($id);

        $createAccount = new CreateAccount($repository);
        $createAccount->execute($account);
    }
}