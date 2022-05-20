<?php

namespace Seara;

use Illuminate\Database\Eloquent\Model;

class AccountBank extends Model
{
    protected $fillable = [
        'bank_id',
        'typeBank_id',
        'company_id',
        'number',
        'agency_number',
        'balance',
        'owner'
    ];
}
