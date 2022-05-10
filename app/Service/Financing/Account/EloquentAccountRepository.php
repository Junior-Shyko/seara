<?php

declare(strict_types=1);

namespace Seara\Service\Financing\Account;

use Seara\Account;
use Ramsey\Uuid\Uuid;

class EloquentAccountRepository implements AccountRepository
{
    public function save(array $accountData): void
    {
        $account = new Account();
        $account->fill($accountData);
        $account->save();
    }

    public function nextIdentity(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function update(string $id, array $accountData): void
    {
        $account = $this->find($id);
        $account
            ->fill($accountData)
            ->save();
    }

    public function find(string $id): Account
    {
        if ($account = Account::find($id)) {
            return $account;
        }
        throw AccountNotFound::withId($id);
    }
}