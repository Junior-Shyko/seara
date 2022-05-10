<?php

declare(strict_types=1);

namespace Seara\Service\Financing\Account;

use Carbon\Carbon;

class ArchiveAccount
{
    /**
     * @var AccountRepository
     */
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function execute(string $id)
    {
        $currentTime = Carbon::now();
        $this->accountRepository->update($id, [
            'archived_at' => $currentTime
        ]);
    }
}