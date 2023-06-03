<?php

namespace Seara\Repository;

use Seara\Entry;
use Seara\FileLaunch;
use Seara\AccountBank;
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

}