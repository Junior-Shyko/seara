<?php

namespace Seara\Service\Launch;

use Seara\Entry;
use Seara\AccountBank;
use DB;

class LaunchService
{

    /**
     * Retorna o saldo atual dos lancamento/Caixa interno
     *
     * @param [type] $idCompany
     * @return void
     */
    static public function getBoxInternal($idCompany)
    {
        $balance  = self::getCountValueLaunch($idCompany, 'Receita', 1);
        return $balance;
    }

    /**
     * Retorna o valor dos lancamentos dependendo do tipo de conta
     *
     * @param [type] $idCompany
     * @param [type] $type
     * @return void
     */
    static function getCountValueLaunch($idCompany, $type, $transaction)
    {
        // DB::enableQueryLog();
        $entry  = Entry::join('account_launches', 'entries.entries_id_account', '=', 'account_launches.id')
            ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
            // ->where('account_types.account_types_name','=', $type)
            ->where('entries.entries_id_company', '=', $idCompany)
            ->where('entries.entries_bank', '=', 0)
            ->orWhere('entries.entries_parent', '=', 0)        
            ->select(
                'account_launches.accountlaunch_type',
                'account_types.id',
                'account_types.account_types_name',
                'entries.entries_id_account',
                'entries.entries_id_company',
                'entries.entries_value',
                'entries.entries_id as idEntry',
                'account_types.id as idAccountType'
            )->get();
        //retorna o valor encontrado
        //dd( DB::getQueryLog());
        $receita = 0;
        $despesa = 0;
        foreach ($entry as $key => $value) {
            switch ($value['account_types_name']) {
                case 'Receita':
                    $receita = ($receita + $value['entries_value']);
                    break;
                case 'Despesa':
                    $despesa = ($despesa + $value['entries_value']);
                    break;
            }
        }
        $saldo = ($receita - $despesa);
        // empty($value) ? $value = 0 : $value = $value->sum('entries_value');
        return $saldo;
    }

    /**
     * Retorna o calculo somado de todos os valores das contas bancáriass
     *
     * @param [type] $idCompany
     * @return void
     */
    static public function getBoxBank($idCompany)
    {
        return AccountBank::where('company_id', '=', $idCompany)->sum('balance');
    }
}
