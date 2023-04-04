<?php

namespace Seara;

use Illuminate\Database\Eloquent\Model;

class AccountInternal extends Model
{
    protected $table = 'account_internal';
    protected $fillable = ['company_id', 'balance'];
}
