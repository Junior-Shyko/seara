<?php

namespace Seara\Repository;

use Seara\Bank;

class BankRepository {
    
    public function getBanks() {
        return Bank::all();
    }

    static public function getBank($id) {
        return Bank::findOrFail($id);
    }

    static public function getAccountToBank($idAccount) 
    {
        $account = AccountBankRepository::getInfoAccountBank($idAccount);
        $bank = Bank::findOrFail($account['bank_id']);
        return $bank['name'];
    }
    
}

