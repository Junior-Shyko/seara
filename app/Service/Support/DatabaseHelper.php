<?php

declare(strict_types=1);

namespace App\Service\Support;

use DB;

class DatabaseHelper
{
    private const TABLES = [
        'tagging_tags',
        'tagging_tagged',
        'tagging_tag_groups',
        'jobs',
        'password_resets',
        'users',
        'receipt_common',
        'receipt_company',
        'companies',
        'account'
    ];

    private const SEEDERS = [
        'login_spec' => [\TestUserSeeder::class],
        'financing.account_spec' => [\TestUserSeeder::class],
    ];

    public static function cleanDatabase()
    {
        foreach (self::TABLES as $table) {
            DB::table($table)->delete();
        }
    }

    public static function seedDatabase(string $seed)
    {
        $seeders = self::SEEDERS[$seed];
        foreach ($seeders as $seeder) {
            app()
                ->make($seeder)
                ->run();
        }
    }
}
