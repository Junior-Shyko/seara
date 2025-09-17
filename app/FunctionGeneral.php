<?php

namespace Seara;

use DB;
use Seara\Box;
use Carbon\Carbon;
use Seara\Models\User;
use Seara\Models\Profile;
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

	static public function getNameProfile($id_profile){

		$profile = Profile::where('profile_id' , '=', $id_profile)->first();

		return $profile;
	}

	//formata o valor moeda para guardar no banco
	static public function moeda($get_valor) {
		$source = array('.', ',', 'R$' , ' '); 
		$replace = array('', '.');
		$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
		return $valor; //retorna o valor formatado para gravar no banco
	}

	public static function getName($id_users)
	{
		$user = User::find($id_users);
		echo $user->name;
	}
	//VERIFICA SE A TABELA BOX NÃO TEM REGISTRO NENHOM
	public static function getBox()
	{
		$box = Box::all();
		return $box;
	}


	// Função auxiliar para conversão
	public static function convertTwoDigitYearToFour($dateString)
	{
		// Parse a data assumindo formato como 'YY-MM-DD' ou 'DD-MM-YY'. Ajuste o formato aqui se necessário.
		$carbonDate = Carbon::createFromFormat('y-m-d', $dateString); // 'y' é para ano de 2 dígitos

		// Se o parsing falhar, você pode adicionar validação ou fallback
		if (!$carbonDate) {
			throw new \Exception("Formato de data inválido: " . $dateString);
		}

		// Retorna no formato YYYY-MM-DD
		return $carbonDate->format('Y-m-d');
	}
}
