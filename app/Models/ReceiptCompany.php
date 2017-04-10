<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiptCompany extends Model
{
    protected $fillable = [
      'receipt_id_company',
      'receipt_value',
      'receipt_extensive_value',
      'receipt_received_from',
      'receipt_reference',
      'receipt_local',
      'receipt_date',
      'receipt_emitter',
      'receipt_document',
    ];
    protected $primaryKey = 'receipt_id';
    protected $table = 'receipt_company';
}
