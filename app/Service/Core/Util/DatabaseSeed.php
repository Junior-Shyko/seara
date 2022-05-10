<?php

declare(strict_types=1);

namespace Seara\Service\Core\Util;

use Tests\Seeds\ReceivableSpec;
use Tests\Seeds\TestUserSeeder;

class DatabaseSeed
{
    private const SEEDERS = [
        'user' => [TestUserSeeder::class],
        'receivable_spec' => [
            'accounts_and_categories' => [ReceivableSpec\AccountAndCategoriesSeeder::class],
            'partial_payment' => [ReceivableSpec\PartialPaymentSeeder::class],
        ]
    ];

    /**
     * @var SeederRunner
     */
    private $runner;
    /**
     * @var array
     */
    private $configuration;

    public static function seedDatabase(string $seed)
    {
        $databaseSeed = new self(
            SeederRunner::create(),
            self::SEEDERS
        );
        $databaseSeed->execute($seed);
    }

    public function __construct(
        SeederRunner $runner,
        array $configuration
    ) {
        $this->runner = $runner;
        $this->configuration = $configuration;
    }

    public function execute(string $seed)
    {
        $seeders = array_get($this->configuration, $seed);
        foreach ($seeders as $seeder) {
            $this->runner->run($seeder);
        }
    }
}
