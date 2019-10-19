<?php

declare(strict_types=1);

namespace App\Service\Core\Util;

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
        'companies',
        'account',
        'income_category',
    ];

    public static function cleanDatabase()
    {
        foreach (self::TABLES as $table) {
            DB::table($table)->delete();
        }
    }
}
