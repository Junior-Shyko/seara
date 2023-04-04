<?php

namespace Seara;

use Carbon\Carbon;
use Seara\Models\Company;
use Illuminate\Database\Eloquent\Model;

class SettingsEntry extends Model
{
    protected $table = 'settings_entries';

    protected $fillable = [
        'balance_bank',
        'balance_internal',
        'balance_general',
        'company_id'
    ];

    static public function CreateOrUp(Company $company)
    {
        
        $setEntries = SettingsEntry::where('company_id', $company->company_id)->first();
        if(is_null($setEntries)){
            dump($company);
            try {
                SettingsEntry::insert([
                    'balance_bank' => 0,
                    'balance_internal'=> 0,
                    'balance_general'=> 0,
                    'company_id' => $company->company_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            } catch (\Throwable $th) {
                throw $th;
            }

        }
    }

    static public function UpSettings($bank, $internal, $general, $company_id)
    {
        //REGISTRO DE CONFIGURAÇÃO DA IGREJA
        $set = SettingsEntry::findOrFail($company_id);
        try {
            //ATUALIZANDO O REGISTRO
            foreach ($set as $item) {            
                $item->update([
                    'balance_bank' => $bank,
                    'balance_internal'=> $internal,
                    'balance_general'=> $general,
                    'updated_at' => Carbon::now()
                ]);
            }           
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
