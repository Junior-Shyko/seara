<?php

declare(strict_types=1);

namespace App\Service\Financing\Account;

interface AccountRepository
{
    public function save(array $account);

    public function nextIdentity(): string;
}