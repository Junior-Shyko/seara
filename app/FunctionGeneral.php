<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Profile;

class FunctionGeneral extends Model
{
    //CREATE 2017-04-10 BY EXCELLENCE SOFT
   
   
    static public function DataBRtoMySQL( $DataBR ) 
    {
		$DataBR = str_replace(array(" – ","-"," "," "), " ", $DataBR);
		list($data) = explode(" ", $DataBR);
		return implode("-",array_reverse(explode("/",$data))) ;
	}

	static public function getNameProfile($id_profile){

		$profile = Profile::where('profile_id' , '=', $id_profile)->first();

		return $profile;
	}

	//formata o valor moeda para guardar no banco
	static public function moeda($get_valor) {
		$source = array('.', ','); 
		$replace = array('', '.');
		$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
		return $valor; //retorna o valor formatado para gravar no banco
	}
}
