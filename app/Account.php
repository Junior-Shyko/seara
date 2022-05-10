<?php

namespace Seara;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 * @property string $type
 */
class Account extends Model
{
    protected $table = 'account';

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'string'
    ];
}
