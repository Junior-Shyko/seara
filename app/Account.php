<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 * @property string $type
 */
class Account extends Model
{
    protected $table = 'account';

    protected $fillable = [
        'id',
        'name',
        'type'
    ];
}
