<?php

namespace Seara\Repository;

use App\Account;
use Carbon\Carbon;
use Seara\AccountLaunch;


class AccountLaunchRepository
{

    public function getAccountLaunchEntryGroup($company_id, $dtInitial, $dtEnd, $idAccount = null)
    {
        return AccountLaunch::join('entries', 'account_launches.id' , '=', 'entries.entries_id_account')
                            ->when($idAccount, function ($query) use ($idAccount) {
                                return $query->where('entries_id_account', $idAccount);
                            })
                            ->where('entries.entries_id_company',$company_id)
                            ->where('entries.created_at','>=',$dtInitial)
                            ->where('entries.created_at','<=',$dtEnd)
                            ->groupBy('entries.entries_id_account')->get();
    }

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
            'users.id as userId', 'users.name', 'entries.*', 'account_launches.*',
            'account_types.id as typeAccountId', 'account_types.account_types_name',
            'companies.company_name', 'companies.company_cnpj'
        )
        ->where('entries.entries_id_company',$company_id)
        ->where('entries.created_at','>=',$dtInitial)
        ->where('entries.created_at','<=',$dtEnd)
        ->get();
    }

}