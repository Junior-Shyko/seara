<?php

namespace App\Seara;

use App\Entry;
use DB, Auth;

class Monetary {
    private static $unidades = array("um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove", "dez", "onze", "doze",
                                     "treze", "quatorze", "quinze", "dezesseis", "dezessete", "dezoito", "dezenove");
    private static $dezenas = array("dez", "vinte", "trinta", "quarenta","cinqüenta", "sessenta", "setenta", "oitenta", "noventa");
    private static $centenas = array("cem", "duzentos", "trezentos", "quatrocentos", "quinhentos",
                                     "seiscentos", "setecentos", "oitocentos", "novecentos");
    private static $milhares = array(
        array("text" => "mil", "start" => 1000, "end" => 999999, "div" => 1000),
        array("text" => "milhão", "start" =>  1000000, "end" => 1999999, "div" => 1000000),
        array("text" => "milhões", "start" => 2000000, "end" => 999999999, "div" => 1000000),
        array("text" => "bilhão", "start" => 1000000000, "end" => 1999999999, "div" => 1000000000),
        array("text" => "bilhões", "start" => 2000000000, "end" => 2147483647, "div" => 1000000000)
    );
    const MIN = 0.01;
    const MAX = 2147483647.99;
    const MOEDA = " real ";
    const MOEDAS = " reais ";
    const CENTAVO = " centavo ";
    const CENTAVOS = " centavos ";
    static function numberToExt($number, $moeda = true) {
        if ($number >= self::MIN && $number <= self::MAX) {
            $value = self::conversionR((int)$number);
            if ($moeda) {
                if (floor($number) == 1) {
                    $value .= self::MOEDA;
                }
                else if (floor($number) > 1) $value .= self::MOEDAS;
            }
            $decimals = self::extractDecimals($number);
            if ($decimals > 0.00) {
                $decimals = round($decimals * 100);
                $value .= " e ".self::conversionR($decimals);
                if ($moeda) {
                    if ($decimals == 1) {
                        $value .= self::CENTAVO;
                    }
                    else if ($decimals > 1) $value .= self::CENTAVOS;
                }
            }
        }
        return trim($value);
    }
    private static function extractDecimals($number) {
        return $number - floor($number);
    }
    static function conversionR($number) {
        $value = null;
        if (in_array($number, range(1, 19))) {
            $value = self::$unidades[$number-1];
        }
        else if (in_array($number, range(20, 90, 10))) {
             $value = self::$dezenas[floor($number / 10)-1]." ";
        }
        else if (in_array($number, range(21, 99))) {
             $value = self::$dezenas[floor($number / 10)-1]." e ".self::conversionR($number % 10);
        }
        else if (in_array($number, range(100, 900, 100))) {
             $value = self::$centenas[floor($number / 100)-1]." ";
        }
        else if (in_array($number, range(101, 199))) {
             $value = ' cento e '.self::conversionR($number % 100);
        }
        else if (in_array($number, range(201, 999))) {
             $value = self::$centenas[floor($number / 100)-1]." e ".self::conversionR($number % 100);
        }
        else {
            foreach (self::$milhares as $item) {
                if ($number >= $item['start'] && $number <= $item['end']) {
                    $value = self::conversionR(floor($number / $item['div']))." ".$item['text']." ".self::conversionR($number % $item['div']);
                    break;
                }
            }
        }
        return $value;
    }

    //formata o valor moeda para guardar no banco
    static public function money_real($get_valor) 
    {
        $source = array('.', ','); 
        $replace = array('', '.');
        $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
        return $valor; //retorna o valor formatado para gravar no banco
    }

    /**
     * params $type = Id da conta que não deseja incluir no calculo
     */
    static public function getValueBoxFeed($type = null, $bank, $id_company) {
        $value = 0;
        $total = 0;
        //TIPO RECEITA
        if($type) {
            //SE FOR UMA CONSULTA PARA O CAIXA DO BANCO
            if($bank) {
                DB::enableQueryLog();
                $value = Entry::join('account_launches','entries.entries_id_account','=','account_launches.id')
                ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
                // ->whereMonth('entries.entries_date_launch', $month)
                ->whereNotIn('account_launches.accountlaunch_type',[$type])
                ->where('entries.entries_bank', '=', 1)
                ->where('account_types.account_types_name','=','Receita')
                ->where('entries.entries_id_company', '=', $id_company)
                ->select('account_launches.*', 'account_types.*', 'entries.*', 'entries.entries_id as idEntry', 'account_types.id as idAccountType')->get();
                //dump(DB::getQueryLog());
                $total = $value->sum('entries_value');
            }else{
                $value = Entry::join('account_launches','entries.entries_id_account','=','account_launches.id')
                ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
                // ->whereMonth('entries.entries_date_launch', $month)
                ->where('entries.entries_bank', '=', 0)
                ->where('account_types.account_types_name','=','Receita')
                ->where('entries.entries_id_company', '=', $id_company)
                ->select('account_launches.*', 'account_types.*', 'entries.*', 'entries.entries_id as idEntry', 'account_types.id as idAccountType')->get();
                $total = $value->sum('entries_value');
            }
            
        }else{
            //VALOR NEGATIVOS
            if($bank) {
                $value = Entry::join('account_launches','entries.entries_id_account','=','account_launches.id')
                ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
                ->where('account_types.account_types_name','=','Despesa')
                ->where(function ($query) {
                    $query->where('entries_bank', '=', 1);
                })
                ->where('entries.entries_id_company', '=', $id_company)
                ->select('account_launches.*', 'account_types.*', 'entries.*', 'entries.entries_id as idEntry', 'account_types.id as idAccountType')->get();
                $total = $value->sum('entries_value');
            }else{
                $value = Entry::join('account_launches','entries.entries_id_account','=','account_launches.id')
                ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
                //->whereMonth('entries.entries_date_launch', $month)
                ->where('account_types.account_types_name','=','Despesa')
                ->where(function ($query) {
                    $query->where('entries_bank', '=', 0);
                })
                ->where('entries.entries_id_company', '=', $id_company)
                ->select('account_launches.*', 'account_types.*', 'entries.*', 'entries.entries_id as idEntry', 'account_types.id as idAccountType')->get();
                $total = $value->sum('entries_value');
            }
            
        }
        //dump($total);
        return $total;
    }
    /**
     * Undocumented function
     *
     * @param [type] $month
     * @param [type] $type
     * @return void
     */
    static public function getValueBox() {
        $totalRec = 0;
        $totalDes = 0;
        $total = 0;
        $id_company = Auth::user()->user_id_company;
        $typeEnd = DB::table('account_types')->where('account_types_name', 'Despesa')->get();
        //dump($typeEnd[0]->id);
        //SOMENTE AS ENTRADAS(receitas)
        $valueRec = Entry::join('account_launches','entries.entries_id_account','=','account_launches.id')
            ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
            //->whereMonth('entries.entries_date_launch', $month)
            ->whereNotIn('account_launches.accountlaunch_type',[$typeEnd[0]->id])
            ->where('entries.entries_id_company', '=', $id_company)
            ->select('account_launches.*', 'account_types.*', 'entries.*', 'entries.entries_id as idEntry', 'account_types.id as idAccountType')->get();
            $totalRec = $valueRec->sum('entries_value');
        
        // SOMENTE AS SAÍDAS(despesas)
        $valueDes = Entry::join('account_launches','entries.entries_id_account','=','account_launches.id')
            ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
            //->whereMonth('entries.entries_date_launch', $month)
            ->where('account_types.account_types_name','=','Despesa')
            ->where('entries.entries_id_company', '=', $id_company)
            ->select('account_launches.*', 'account_types.*', 'entries.*', 'entries.entries_id as idEntry', 'account_types.id as idAccountType')->get();
            $totalDes = $valueDes->sum('entries_value');

        return ['receitas' => $totalRec, 'despesas' => $totalDes];
    }
}
