<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receivable extends Model
{
    protected $table = 'receivable';

    protected $fillable = [
        'id', 'amount', 'due_date', 'description', 'income_category_id',
        'account_id', 'company_id', 'sequence_id', 'sequence_number', 'sequence_count', 'payment_date',
    ];

    protected $casts = [
        'id' => 'string'
    ];

    protected $dates = [
        'payment_date'
    ];
}
