<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountLaunch extends Model
{
    protected $fillable = [
        'accountlaunch_name',
        'accountlaunch_type',
        'accountlaunch_history',
        'accountlaunch_id_user'
    ];
}
