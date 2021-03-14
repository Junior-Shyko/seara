<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $table 		= 'boxies';
    protected $primaryKey 	= 'boxies_id';
    protected $fillable	 	= [
			'boxies_date_open' ,
			'boxies_date_close',
			'boxies_month_year',
			'boxies_balance_end',
			'boxies_status', 
			'boxies_id_company',
			'boxies_id_users',
			'boxies_balance_initial'
    ];


}
