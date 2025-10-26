<?php

namespace Seara\Service\Launch;

use Seara\Entry;
use Seara\AccountBank;
use DB;

class LaunchService
{

    const BANK_INCOME  = 56; //TRANSFERENCIA DE BANCO SENDO RECEITA 
    const BANK_EXPENSE = 58; //TRANSFERENCIA DE BANCO SENDO DESPESA 

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
    static function getCountValueLaunch($idCompany)
    {
        // DB::enableQueryLog();
        $entry  = Entry::join('account_launches', 'entries.entries_id_account', '=', 'account_launches.id')
            ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
            ->where('entries.entries_id_company', '=', $idCompany)
            ->select(
                'account_launches.accountlaunch_type',
                'account_types.id',
                'account_types.account_types_name',
                'entries.entries_id_account',
                'entries.entries_id_company',
                'entries.entries_value',
                'entries.entries_id_account',
                'entries.entries_bank',
                'entries.entries_id as idEntry',
                'account_types.id as idAccountType'
            )->get();
        //retorna o valor encontrados
        $receita = 0;
        $despesa = 0;
        foreach ($entry as $key => $entries) {
            switch ($entries['account_types_name']) {
                case 'Receita':
                    //Se lançado direto no caixa faz a somatória                   
                    if($entries['entries_bank'] == 0){
                        $receita = ($receita + $entries['entries_value']);
                    }elseif(
                        //se a conta bancaria e receita de uma transferencia, então soma
                        $entries['entries_bank'] > 0 
                        && $entries['entries_id_account'] == self::BANK_INCOME
                    )
                    {
                        $receita = ($receita + $entries['entries_value']);
                    }
                    break;
                case 'Despesa':
                    $despesa = ($despesa + $entries['entries_value']);
                    break;
            }
        }

        // dd( DB::getQueryLog());
        $saldo = ($receita - $despesa);
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
        return AccountBank::where('company_id', '=', $idCompany)->get();
    }

    public function getServiceTransferAccountBank($type, $valueBank, $transferOfValueSub, $transferOfValueSum): array
    {
        if(
            $type === 'Transferência' &&
            $valueBank->entries_bank > 0 &&
            $valueBank->transaction_id == 1
        )
        {
            if($valueBank->entries_parent == -1)
            {
                $transferOfValueSub += $valueBank->entries_value;
            }elseif($valueBank->entries_parent > 0)
            {
                $transferOfValueSum += $valueBank->entries_value;
            }
        }

        return [
            'transferOfValueSub' => $transferOfValueSub,
            'transferOfValueSum' => $transferOfValueSum
        ];
    }

}
