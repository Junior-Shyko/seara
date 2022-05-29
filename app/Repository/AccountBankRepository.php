<?php

namespace Seara\Repository;

use Seara\Bank;
use Carbon\Carbon;
use Doctrine\DBAL\Tools\Dumper;
use Seara\AccountBank;
use Seara\Seara\Monetary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Seara\Repository\BankRepository;

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
        $verify = AccountBank::findOrFail($request['idAccountEnd']);
        $balanceAccount = Monetary::money_real($request['value']);
        $comparation = $balanceAccount <=> $verify->balance;
        //Comparation = 0 = igual, -1 = menor, 1 = maior
        if($comparation == 1)
        {
            return response()->json([
                'type' => 'error',
                'message' => 'Saldo insuficiente'
            ], 400);
        }
        //preenchendo array com os campos e valores para um lancamento
        try {
            $valueBalance = Monetary::money_real($request['value']);
            $accountBank = AccountBank::findOrFail($request['idAccountEnd']);
            $accountBank->balance = $accountBank->balance - $valueBalance;
            $accountBank->save();
            $accountBank2 = AccountBank::findOrFail($request['idAccountEntry']);
            $accountBank2->balance = $accountBank2->balance + $valueBalance;
            $accountBank2->save();
            return response()->json([
                'type' => 'success',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'message' => 'Erro ao transferir valores'
            ], 400);
        }
        
        
    }

    static public function fieldsEntry($request, $type)
    {
        $account = self::getInfoAccountBank($request['idAccountEnd']);
        $bank = BankRepository::getAccountToBank($request['idAccountEnd']);

        $account2 = self::getInfoAccountBank($request['idAccountEntry']);
        $bank2 = BankRepository::getAccountToBank($request['idAccountEntry']);

        $desc = '';
        $idAccountLaunch = 0;
        switch ($type) {
            case 'despesa':
                $desc = 'Transferência da conta nº '.$account['number'].' '.$bank.' para conta nº '.$account2['number']. ' '.$bank2;
                $idAccountLaunch = 7;
                break;
            case 'receita':
                $desc = 'Trasnferência recebida de conta nº '.$account['number'].' '.$bank;
                $idAccountLaunch = 8;
                break;
        }
        $launch['entries_id_account'] = $idAccountLaunch;
        $launch['entries_description'] = $desc;
        $launch['entries_id_company'] = Auth::user()->user_id_company;
        $launch['entries_id_user'] = Auth::user()->id;
        $launch['entries_value'] = Monetary::money_real($request['value']);
        $launch['entries_date_launch'] = Carbon::now();
        return $launch;
    }
}