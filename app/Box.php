<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $table 		= 'boxes';
    protected $primaryKey 	= 'boxes_id';
    protected $fillable	 	= ['boxes_id_account' , 'boxes_id_user' , 'boxes_id_company' , 'boxes_balance_initial' , 'boxes_balance_previous' 						,'boxes_decimate' , 'box_offer' , 'box_end' , 'box_balance' , 'box_balance_end'];


}
