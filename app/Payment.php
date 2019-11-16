<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property float $amount
 * @property string $receivable_id
 */
class Payment extends Model
{
    protected $table = 'payment';

    protected $guarded = ['created_at', 'updated_at'];

    protected $casts = [
        'id' => 'string'
    ];
}
