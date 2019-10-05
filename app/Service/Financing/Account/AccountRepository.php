<?php

declare(strict_types=1);

namespace App\Service\Financing\Account;

use App\Account;

interface AccountRepository
{
    /**
     * Gets an identifier
     * @return string
     */
    public function nextIdentity(): string;

    /**
     * Saves the account
     *
     * @param array $accountData
     */
    public function save(array $accountData): void;

    /**
     * Updates an account
     *
     * @param string $id
     * @param array $accountData
     * @throws AccountNotFound
     */
    public function update(string $id, array $accountData): void;

    /**
     * Finds an account by its id
     *
     * @param string $id
     * @return Account
     * @throws AccountNotFound
     */
    public function find(string $id): Account;
}