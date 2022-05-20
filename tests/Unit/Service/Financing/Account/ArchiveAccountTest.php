<?php

declare(strict_types=1);

namespace Tests\Unit\Service\Financing\Account;

use Seara\Service\Financing\Account\AccountRepository;
use Seara\Service\Financing\Account\ArchiveAccount;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class ArchiveAccountTest extends TestCase
{
    /**
     * @test
     */
    public function it_archives_the_account()
    {
        $now = Carbon::create(2018, 9, 21);
        Carbon::setTestNow($now);
        $id = 'myuuid';

        $repository = $this->createMock(AccountRepository::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($id, [
                'archived_at' => $now
            ]);

        $archiveAccount = new ArchiveAccount($repository);
        $archiveAccount->execute($id);
    }
}