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
        'company_addr_street',
        'company_addr_number',
        'company_addr_complement',
        'company_addr_district',
        'company_addr_city',
        'company_addr_state',
        'company_addr_cep',
        'company_phone',
        'company_mobile',
        'company_brand_logo',
        'company_status',
        'company_manager',
        'company_type',
    ];
    //

    protected $table = "companies";
    protected $primaryKey = "company_id";

    public function users()
    {
      return $this->hasMany('App\Models\User', 'user_id_company');
    }
}
