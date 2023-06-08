<?php

namespace Seara\Repository;

use Seara\Entry;
use Seara\FileLaunch;
use Seara\AccountBank;
use Seara\AccountLaunch;
use Seara\Seara\Monetary;

class EntryRepository {

    static public function deleteFile($id)
    {
        
        //exclusao dos arquivos, caso tenha
        $files = FileLaunch::where('file_launches_id_entry', '=', $id)->get();
       
        foreach ($files as $key => $value) {
            FileLaunch::where('id', $value->id)->delete();
        }
    }

    static public function deleteLaunchBank($idEntry)
    {
        $entry = Entry::where('entries_id', $idEntry)->first();
        if($entry->entries_bank == 0 || !empty($entry->entries_bank) && is_null($entry->entries_parent))
        {
            $account_bank = AccountBank::find($entry->entries_bank);//instanciando o conta
            if(!is_null($account_bank)){
                $valueBank = Monetary::money_real($entry->entries_value);//formatando o valor
                $account_bank->balance  -= (float) $valueBank;//reduzindo o valor da conta
                $account_bank->save();//salvando os dados
            }               
        }

        return $entry;
    }

    static function typeAccount($id)
    {
        return AccountLaunch::join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
            ->where('account_launches.id', '=' , $id)
            ->select('account_types.account_types_name')->first();
    }

    /**
     * Essa funcao altera o valor da conta bancaria
     * dependendo o tipo do lançamento
     *
     * @param [string] $type
     * @param Entry $entry
     * @return \Illuminate\Http\JsonResponse
     */
    static function alterBalanceEntry($type, Entry $entry): \Illuminate\Http\JsonResponse
    {
        try {
            switch ($type) {
                case 'Receita':
                    $acc_bank = AccountBank::find($entry->entries_bank);
                    $acc_bank->balance = ($acc_bank->balance - $entry->entries_value);//remove valor da conta bancaria
                    $acc_bank->save();
                    break;
                case 'Despesa':                    
                    $accountBank = AccountBank::find($entry->entries_bank);
                    $accountBank->balance += $entry->entries_value;//adiciona valor da conta bancaria
                    $accountBank->save();
                    break;
            }
            return response()->json(['message' => 'success', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 400], 400);
        } 
       
    }

}