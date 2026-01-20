<?php

namespace Seara;

use Illuminate\Database\Eloquent\Model;

class FileLaunch extends Model
{
    protected $fillable = [
        'file_launches_name',
        'file_launches_id_entry',
        'transaction_id'
    ];

    /**
     * Relacionamento com Transaction
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
