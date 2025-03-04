<?php

namespace Seara;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'name' , 'bank_name' , 'agency' , 'account_number'
    ];
}
