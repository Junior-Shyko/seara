<?php

namespace Seara;

use Illuminate\Database\Eloquent\Model;

class SettingsBox extends Model
{
    protected $fillable = [
        'date_open',
        'date_close',
        'month',
        'id_user_open',
        'id_user_close',
        'id_company',
        'slug'
    ];
}
