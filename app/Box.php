<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $table 		= 'entries';
    protected $primaryKey 	= 'entries_id';
    protected $fillable	 	= ['entries_id_account' ,'entries_day', 'entries_description' , 'entries_id_company' , 'entries_balance_initial' , 'entries_balance_previous' ,'entries_decimate' , 'entries_offer' , 'entries_end' , 'entries_balance' , 'entries_balance_end'];


}
