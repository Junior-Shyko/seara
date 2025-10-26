<?php

namespace Seara\Service\AccountBank;

use Seara\AccountBank;

class AccountBankService {
    public $accountBank;
    public function __construct(AccountBank $accountBank)
    {
        $this->accountBank = $accountBank;
    }

    function getBankAndAccount($bankId, $number, $agency) {
        return $this->accountBank->where([
            ['bank_id', '=', $bankId],
            ['number', '=' , $number],
            ['agency_number', '=' , $agency]
        ]);
    }
}

?>


