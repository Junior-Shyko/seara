<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    protected $fillable = [
      'company_name',
      'company_fantasy',
      'company_responsible',
      'company_cnpj',
      'company_street',
      'company_number',
      'company_complement',
      'company_district',
      'company_city',
      'company_state',
      'company_cep',
      'company_phone',
      'company_mobile',
      'company_brand_logo'
    ];
    //

    protected $table = "companies";
    protected $primaryKey = "company_id";
}
