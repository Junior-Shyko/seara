<?php

namespace Seara\Repository;

use Seara\AccountLaunch;
use Seara\FunctionGeneral;


class AccountLaunchRepository
{

    public function getAccountLaunchEntryGroup($company_id, $dtInitial, $dtEnd, $idAccount = null)
    {
        
        // Converter datas com ano de 2 dígitos para 4 dígitos
        $dtInitialConverted = FunctionGeneral::convertTwoDigitYearToFour($dtInitial);
        $dtEndConverted = FunctionGeneral::convertTwoDigitYearToFour($dtEnd);
        return AccountLaunch::join('entries', 'account_launches.id' , '=', 'entries.entries_id_account')
                            ->when($idAccount, function ($query) use ($idAccount) {
                                return $query->where('entries_id_account', $idAccount);
                            })
                            ->select('account_launches.*', 'account_launches.id as idAccountLaunch','entries.*')
                            ->where('entries.entries_id_company',$company_id)
                            ->where('entries.entries_date_launch', '>=', $dtInitialConverted)
                            ->where('entries.entries_date_launch', '<=', $dtEndConverted)
                            ->groupBy('entries.entries_id_account')->get();
    }

    /**
     * Retorna de uma igreja todos os lançamentos e suas contas, se não especificar a conta
     *
     * @param [int] $company_id
     * @param [date] $dtInitial
     * @param [date] $dtEnd
     * @param [int] $idAccount
     * @return void
     */
    public function getAccountLaunchEntry($company_id, $dtInitial, $dtEnd, $idAccount = null)
    {
        return AccountLaunch::join('entries', 'account_launches.id' , '=', 'entries.entries_id_account')
        ->join('users', 'entries.entries_id_user', '=', 'users.id')
        ->join('account_types' , 'account_launches.accountlaunch_type' ,'=', 'account_types.id')
        ->join('companies', 'entries.entries_id_company', '=', 'companies.company_id')
        ->when($idAccount, function ($query) use ($idAccount) {
            return $query->where('entries_id_account', $idAccount);
        })
        ->select(
            'users.id as userId', 'users.name', 'entries.*', 'account_launches.*', 'account_launches.id as idAccountLaunch',
            'account_types.id as typeAccountId', 'account_types.account_types_name',
            'companies.company_name', 'companies.company_cnpj',
            'entries.entries_date_launch as entriesCreatedAt'
        )
        ->where('entries.entries_id_company',$company_id)
        ->where('entries.entries_date_launch','>=',$dtInitial)
        ->where('entries.entries_date_launch','<=',$dtEnd)
        ->get();
    }

    /**
     * Retorna o valor sometário dos lançamento de uma conta, anterior a uma data estabelecida
     * @param [int] $company_id
     * @param [date] $dtInitial
     * @param [int] $idAccount
     * @return void
     * */
    static function getValueAccountLaunchEntry($company_id, $dtInitial,$idAccount)
    {
        return AccountLaunch::join('entries', 'account_launches.id' , '=', 'entries.entries_id_account')
            ->select('account_launches.*', 'account_launches.id as idAccountLaunch','entries.*')
            ->where('entries.entries_id_company',$company_id)
            ->where('entries.entries_date_launch','<=',$dtInitial)
            ->where('entries_id_account', $idAccount)
            ->groupBy('entries.entries_id_account')->sum('entries_value');
    }
}