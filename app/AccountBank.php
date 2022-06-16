<?php

namespace Seara;

use Illuminate\Database\Eloquent\Model;

class AccountBank extends Model
{
    public $nameBank;
    public $number;

    protected $fillable = [
        'bank_id',
        'typeBank_id',
        'company_id',
        'number',
        'agency_number',
        'balance',
        'owner'
    ];

    public function __construct($nameBank = null, $number = null)
    {
        $this->nameBank = $nameBank;
        $this->number = $number;    
    }

    public function account()
    {
        return $this->belongsTo('Seara\Models\Company', 'company_id');
    }
}
