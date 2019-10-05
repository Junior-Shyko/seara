<?php

declare(strict_types=1);

namespace App\Service\Financing\Account;

use App\Account;
use Ramsey\Uuid\Uuid;

class EloquentAccountRepository implements AccountRepository
{
    public function save(array $accountData)
    {
        $account = new Account();
        $account->fill($accountData);
        $account->save();
    }

    public function nextIdentity(): string
    {
        return Uuid::uuid4()->toString();
    }
}