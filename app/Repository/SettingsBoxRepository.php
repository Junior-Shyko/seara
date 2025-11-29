<?php

namespace Seara\Repository;

use Carbon\Carbon;
use Seara\SettingsBox;
use Seara\FunctionGeneral;
use Illuminate\Support\Facades\Auth;

Class SettingsBoxRepository {

    /**
     * Retorna true quando existe registro de caixa do respectivo mes da data de parametro
     * no formato da data brasileira
     *
     * @param [string|object] $date
     * @param [integer] $id_company
     * @return void
     */
    public static function getExistBoxMonth($date, $id_company = null)
    {
        $boxOpen = false;
        if(gettype($date) == 'string' && $date !== null)
        {
            // dump($date);
            // $dtFormat = FunctionGeneral::DataBRtoMySQL($date);
            $month = Carbon::parse($date);
            // dump($month->month);
            // dump($month->year);
            // dd($date);
            $boxOpen = SettingsBox::where([
                'id_company' => $id_company,
                'month' => $month->month,
                'year' => $month->year
            ])->get();
            // dump($boxOpen);
        }elseif(gettype($date) == 'object' && $date !== null){
            $month = $date->month;

            $boxOpen = SettingsBox::where([
                'id_company' => $id_company,
                'month' => $month,
                'year' => $date->year
            ])->get();
        }
      
        return count($boxOpen) == 0 ? false : true;
    }

     /**
     * Retorna o mes referente a data que foi passada
     *
     * @param [string|object] $date
     * @return void
     */
    public static function getMonthYear($date)
    {
        if(gettype($date) == 'string')
        {
            $month['month'] = Carbon::parse($date)->month;
            $month['year'] = Carbon::parse($date)->year;
        }else{
            $month['month'] = $date->month;
            $month['year'] = $date->year;
        }
        return $month;
    }

    /**
     * Função que passa a Mẽs em numero e retorna em string em português
     *
     * @param [number] $month
     * @return void
     */
    public static function getMonthToNumner($month)
    {
        switch ($month) {
            case 1:
                return 'Janeiro';
                break;
            case 2:
                return 'Fevereiro';
                break;
            case 3:
                return 'Março';
                break;
            case 4:
                return 'Abril';
                break;
            case 5:
                return 'Maio';
                break;
            case 6:
                return 'Junho';
                break;
            case 7:
                return 'Julho';
                break;
            case 8:
                return 'Agosto';
                break;
            case 9:
                return 'Setembro';
                break;
            case 10:
                return 'Outubro';
                break;
            case 11:
                return 'Novembro';
                break;
            case 12:
                return 'Dezembro';
                break;
            
            default:
                return 'Janeiro';
                break;
        }
    }

    /**
     * Retorna um objeto inteiro da primeira consulta que for encontrado com os
     * parametros passado. Data no formato brasileiro
     *
     * @param [integer] $id_company
     * @param [string] $date
     * @return void
     */
    public static function getBoxOpenOrClose($id_company, $date)
    {
        $dtFormat = FunctionGeneral::DataBRtoMySQL($date);
        $month = Carbon::parse($dtFormat);

        $boxOpen = SettingsBox::where([
            'id_company' => $id_company,
            'month' => $month->month,
            'year' => $month->year
        ])->first();

        return $boxOpen;
    }

    /**
     * Converte data com ano de 2 dígitos para 4 dígitos
     * 
     * @param string $date Data no formato dd/mm/yy
     * @return string Data no formato dd/mm/yyyy
     */
    public static function convertDateToFullYear($date)
    {
        // Remove espaços em branco
        $date = trim($date);
        
        // Verifica se a data já tem 4 dígitos no ano
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
            return $date; // Já está no formato correto
        }
        
        // Verifica se está no formato dd/mm/yy
        if (!preg_match('/^\d{2}\/\d{2}\/\d{2}$/', $date)) {
            throw new \InvalidArgumentException("Formato de data inválido: {$date}");
        }
        
        // Separa dia, mês e ano
        list($day, $month, $year) = explode('/', $date);
        
        // Converte ano de 2 para 4 dígitos
        // Regra: se ano <= 50, assume 20xx, senão 19xx
        $fullYear = (int)$year <= 50 ? '20' . $year : '19' . $year;
        
        return sprintf('%02d/%02d/%s', $day, $month, $fullYear);
    }
}