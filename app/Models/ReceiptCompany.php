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

  /**
  * The attributes that should be mutated to dates.
  *
  * @var array
  */
  protected $dates = [
    'created_at',
    'updated_at',
    'deleted_at',
    'receipt_date'
  ];

  public function extensiveDate()
  {
    $month = '';
    switch($this->receipt_date->month)
    {
      case 1:
      $month = 'Janeiro';
      break;

      case 2:
      $month = 'Fevereiro';
      break;

      case 3:
      $month = 'Março';
      break;

      case 4:
      $month = 'Abril';
      break;

      case 5:
      $month = 'Maio';
      break;

      case 6:
      $month = 'Junho';
      break;

      case 7:
      $month = 'Julho';
      break;

      case 8:
      $month = 'Agosto';
      break;

      case 9:
      $month = 'Setembro';
      break;

      case 10:
      $month = 'Outubro';
      break;

      case 11:
      $month = 'Novembro';
      break;

      case 12:
      $month = 'Dezembro';
      break;
    }

    return $this->receipt_date->day.' de '.$month.' de '.$this->receipt_date->year;
  }
}
