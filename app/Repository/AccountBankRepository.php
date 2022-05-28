<?php

namespace Seara\Repository;

use Carbon\Carbon;
use Seara\AccountBank;
use Seara\Seara\Monetary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AccountBankRepository {

    /**
     * Retorna o relacionamento de todas as tabelas relacionadas
     *
     * @return void
     */
    static public function getRelationAccountBank()
    {
        $user = Auth::user();
        return AccountBank::with('account')
            ->join('companies', 'account_banks.company_id', '=', 'companies.company_id')
            ->join('type_banks', 'account_banks.typeBank_id', '=', 'type_banks.id')
            ->join('banks', 'account_banks.bank_id', '=', 'banks.id')
            ->join('users', 'account_banks.owner', '=', 'users.id')
            ->select('type_banks.id','type_banks.name','type_banks.name as nameTypeBank','banks.id', 'banks.name as nameBank', 'account_banks.*',
            'users.id', 'users.name as nameUser', 'account_banks.id as idAccountBank')
            ->where('companies.company_id', $user->user_id_company)
            ->get();
    }

    static public function getBalance()
    {
        $balance = AccountBank::where('company_id' , Auth::user()->user_id_company)->get();
        $balanceActual = 0;
        //SOMANDO TODOS OS VALORES
        foreach ($balance as $key => $value) {
            $balanceActual = ($balanceActual + $value->balance);
        }
        return $balanceActual;
    }

    static public function update($request)
    {
        $money = Monetary::money_real($request['balance']);
        $request['balance'] = $money;
        $accountBank = AccountBank::findOrFail($request['idAccontBank']);
        unset($request['idAccontBank']);
        return $accountBank->update($request);
    }

    static public function getAccountBankAndTypeToCompany($idCompany)
    {
        return DB::table('account_banks')
                    ->join('type_banks', 'account_banks.typeBank_id', '=', 'type_banks.id')
                    ->join('banks', 'account_banks.bank_id', '=', 'banks.id')
                    ->select('type_banks.*' ,'account_banks.*', 'type_banks.name as nameTypeBank', 'banks.name as nameBank',
                    'account_banks.id as idAccountBank')
                    ->where('account_banks.company_id', $idCompany)->get();
    }

    /**
     * Retorna todas as informações de uma conta definida
     *
     * @return void
     */
    static public function getInfoAccountBank($id)
    {
        $account = AccountBank::findOrFail($id);
        return $account;
    }

    /**
     * Faz transferencia de valores entre contas
     */
    static public function transfer($request)
    {
        try {
            $valueBalance = Monetary::money_real($request['value']);
            $accountBank = AccountBank::findOrFail($request['idAccountEnd']);
            $accountBank->balance = $accountBank->balance - $valueBalance;
            $accountBank->save();
            $accountBank2 = AccountBank::findOrFail($request['idAccountEntry']);
            $accountBank2->balance = $accountBank2->balance + $valueBalance;
            $accountBank2->save();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
        
        
    }

    static public function fieldsEntry($idAccount, $desc, $value)
    {
        $launch['entries_id_account'] = $idAccount;
        $launch['entries_description'] = $desc;
        $launch['entries_id_company'] = Auth::user()->user_id_company;
        $launch['entries_id_user'] = Auth::user()->id;
        $launch['entries_value'] = Monetary::money_real($value);
        $launch['entries_date_launch'] = Carbon::now();
        return $launch;
    }
}