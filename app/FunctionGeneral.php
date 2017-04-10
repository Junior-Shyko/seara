<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FunctionGeneral extends Model
{
    //CREATE 2017-04-10 BY EXCELLENCE SOFT
    static public function DataBRtoMySQL( $DataBR ) 
    {
		$DataBR = str_replace(array(" – ","-"," "," "), " ", $DataBR);
		list($data) = explode(" ", $DataBR);
		return implode("-",array_reverse(explode("/",$data))) ;
	}
}
