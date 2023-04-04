<?php

namespace Seara;

use Illuminate\Database\Eloquent\Model;

class TypeAccount extends Model
{
    /*DESENVOLVIDO POR EXCELLENCE SOFT 06/07/2017*/
    protected $table 		= 'type_accounts';
    protected $primaryKey 	= 'type_accounts_id';
    protected $fillabe	 	= ['type_accounts_name' , 'type_accounts_id_user'];

}
