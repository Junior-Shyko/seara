<?php

declare(strict_types=1);

namespace Seara\Service\Core\Util;

use DB;

class DatabaseCleaner
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
        'payment_part',
        'payment',
        'receivable',
        'settings',
        'companies',
        'account',
        'income_category',
        'administrators',
    ];

    private const VIEWS = [
        'receivable_view',
    ];

    private const DROP = [
        'profiles',
    ];

    public static function cleanDatabase()
    {
        DB::transaction(function () {
            foreach (self::TABLES as $table) {
                DB::table($table)->delete();
            }
        });
    }

    public static function dropTables()
    {
        DB::transaction(function () {
            foreach (self::TABLES as $table) {
                DB::statement("DROP TABLE IF EXISTS {$table}");
            }

            foreach (self::DROP as $table) {
                DB::statement("DROP TABLE IF EXISTS {$table}");
            }

            foreach (self::VIEWS as $view) {
                DB::statement("DROP VIEW IF EXISTS {$view}");
            }

            DB::statement("DROP TABLE IF EXISTS migrations");
        });
    }
}
