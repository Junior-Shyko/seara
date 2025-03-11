<?php

namespace Seara;

use Illuminate\Database\Eloquent\Model;
use Seara\AccountLaunch;

class AccountType extends Model
{
    //
    protected $fillable = [
        'account_types_name',
        'account_types_id_user'
    ];

    public static function getNameType($idAccount) {
        $name = AccountType::join('account_launches', 'account_types.id', '=', 'account_launches.accountlaunch_type')
        ->where('account_launches.id','=',$idAccount)->get();
        return isset($name[0]->account_types_name) ? $name[0]->account_types_name : null;
    }
}
