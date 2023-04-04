<?php

declare(strict_types=1);

namespace Tests\Unit\Service\Core\Util;

use Seara\Service\Core\Util\DatabaseSeed;
use Seara\Service\Core\Util\SeederRunner;
use PHPUnit\Framework\TestCase;

class DatabaseSeedTest extends TestCase
{
    /**
     * @test
     */
    public function it_runs_all_the_set_up_seeders_with_dot_notation()
    {
        $configuration = [
            'some_spec' => [
                'some_case' => [
                    'seeding' => [
                        MyFakeSeeder::class,
                        AnotherFakeSeeder::class
                    ]
                ]
            ]
        ];

        $seederRunner = $this->prophesize(SeederRunner::class);
        $seederRunner
            ->run(MyFakeSeeder::class)
            ->shouldBeCalled();

        $seederRunner
            ->run(AnotherFakeSeeder::class)
            ->shouldBeCalled();

        $databaseSeed = new DatabaseSeed($seederRunner->reveal(), $configuration);
        $databaseSeed->execute('some_spec.some_case.seeding');
    }
}

class MyFakeSeeder {
}

class AnotherFakeSeeder {
}
