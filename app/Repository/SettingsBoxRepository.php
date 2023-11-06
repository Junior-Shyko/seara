<?php

namespace Seara\Repository;

use Carbon\Carbon;
use Seara\SettingsBox;
use Seara\FunctionGeneral;
use Illuminate\Support\Facades\Auth;

Class SettingsBoxRepository {

    /**
     * Retorna true quando existe registro de caixa do respectivo mes da data de parametro
     *
     * @param [string|object] $date
     * @param [integer] $id_company
     * @return void
     */
    public static function getBoxOpenClose($date, $id_company)
    {
        if(gettype($date) == 'string')
        {
            $month = Carbon::parse($date)->localeMonth;
        }else{
            $month = $date->month;
        }
        $boxOpen = SettingsBox::where([
            'id_company' => $id_company,
            'month' => $month
        ])->get();

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
}