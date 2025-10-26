<?php

declare(strict_types=1);

namespace Seara;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 */
class IncomeCategory extends Model
{
    protected $table = 'income_category';

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    protected $dates = ['archived_at'];

    protected $casts = [
        'id' => 'string'
    ];
}
