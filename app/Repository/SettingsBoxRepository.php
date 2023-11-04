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
            $month = $date->localeMonth;
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
    public static function getMonthBox($date)
    {
        if(gettype($date) == 'string')
        {
            $month = Carbon::parse($date)->localeMonth;
        }else{
            $month = $date->localeMonth;
        }
        return $month;
    }
}