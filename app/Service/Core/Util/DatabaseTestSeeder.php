<?php

declare(strict_types=1);

namespace App\Service\Core\Util;

class DatabaseTestSeeder
{
    private const SEEDERS = [
        'user' => [\TestUserSeeder::class],
        'login_spec' => [\TestUserSeeder::class],
        'financing.account_spec' => [\TestUserSeeder::class],
    ];

    public static function seedDatabase(string $seed)
    {
        $seeders = self::SEEDERS[$seed];
        foreach ($seeders as $seeder) {
            SeederRunner::runSeeder($seeder);
        }
    }
}
