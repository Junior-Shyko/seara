<?php

declare(strict_types=1);

namespace Seara\Service\Receipt;

use Seara\Models\Setting;
use Auth;

class GetReceiptSetting
{
    public function execute(): Setting
    {
        $company = Auth::user()->company;

        $setting = Setting::where('setting_id_company', $company->company_id)->first();

        if ( is_null($setting) )
        {
            $setting = [
                'setting_id_company' => $company->company_id,
                'setting_receipt_local' => ucwords($company->company_addr_city),
                'setting_receipt_emitter' => ucwords($company->company_fantasy),
                'setting_receipt_document' => preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $company->company_cnpj),
                'setting_receipt_email' => '',
                'setting_receipt_header' => $company->company_fantasy
            ];

            $setting = Setting::create($setting);
        }

        return $setting;
    }
}
