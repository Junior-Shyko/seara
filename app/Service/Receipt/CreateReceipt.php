<?php

declare(strict_types=1);

namespace App\Service\Receipt;

use App\Models\ReceiptCompany;
use App\Seara\Monetary;

class CreateReceipt
{
    /**
     * @var GetReceiptSetting
     */
    private $getReceiptSetting;

    public function __construct(GetReceiptSetting $getReceiptSetting)
    {
        $this->getReceiptSetting = $getReceiptSetting;
    }

    public function execute(array $receipt): ReceiptCompany
    {
        $receipt['receipt_extensive_value'] = Monetary::numberToExt($receipt['receipt_value']);
        $this->applyDefaults($receipt);
        return ReceiptCompany::create($receipt);
    }

    private function applyDefaults(array &$receipt)
    {
        $setting = $this->getReceiptSetting->execute();

        $receipt['receipt_local'] = $receipt['receipt_local']
            ?? $setting->setting_receipt_local;

        $receipt['receipt_emitter'] = $receipt['receipt_emitter']
            ?? $setting->setting_receipt_emitter;

        $receipt['receipt_document'] = $receipt['receipt_document']
            ?? $setting->setting_receipt_document;
    }
}
