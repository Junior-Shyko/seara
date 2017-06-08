<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
	/*DESENVOLVIDO POR EXCELLENCE SOFT 06/07/2017*/
    protected $table 		= 'accounts';
    protected $primaryKey 	= 'accounts_id';
    protected $fillabe	 	= ['accounts_name' , 'accounts_id_user' , 'accounts_id_company'];
}
