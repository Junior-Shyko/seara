<?php

declare(strict_types=1);

namespace Seara\Service\Financing\Account;

class CreateAccount
{
    /**
     * @var AccountRepository
     */
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function execute(array $account)
    {
        $id = $this->accountRepository->nextIdentity();
        $account['id'] = $id;
        $this->accountRepository->save($account);
    }
}