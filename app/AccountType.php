<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    //
    protected $fillable = [
        'account_types_name',
        'account_types_id_user'
    ];
}
