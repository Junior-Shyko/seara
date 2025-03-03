<?php

namespace Seara\Http\Abstracts;

use Seara\Entry;
use Illuminate\Database\Eloquent\Collection;

abstract class GeneralBalanceAbstract
{
    /**
     * Retorna somente o valor do caixa banco sem transferência
     *
     * @param [int] $idCompany
     * @return double
     */
    public function getBalanceBank($idCompany): float
    {
        $balance = Entry::where('entries_id_company', $idCompany)->get();
        $sumOfValue = 0;
        $subtrationOfValue = 0;
        foreach ($balance as $valueBank) {  
            $types = static::getTypeLancheToCompany($idCompany, $valueBank->entries_id_account);    
            if ($valueBank->entries_bank > 0 && is_null($valueBank->entries_parent)) {
                foreach ($types as $type) {
                    if ($type->account_types_name === 'Despesa') {
                        $subtrationOfValue += $type->entries_value;
                    }
                    if ($type->account_types_name === 'Receita') {
                        $sumOfValue += $type->entries_value;
                    }
                }
            }
            elseif($valueBank->entries_bank > 0 && !is_null($valueBank->entries_parent)){
             // Se for transferência entre caixa para banco
                foreach ($types as $type) {
                    if($valueBank->transaction_id == 1 && $valueBank->entries_parent < 0)
                    {
                        $sumOfValue = ($sumOfValue + $type->entries_value);
                    }        
                }
            }

        }
        return ($sumOfValue - $subtrationOfValue);
    }

    /**
     * Retornar o tipo de receita ou despesas de um lancamento com base na empresa
     *
     * @param [int] $idCompany
     * @param [int] $accountLanunches
     * @return Entry
     */
    static public function getTypeLancheToCompany($idCompany, $accountLanunches): Collection
    {
        return Entry::join('account_launches', 'entries.entries_id_account', '=', 'account_launches.id')
               ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
               ->where('account_launches.id', '=', $accountLanunches)
               ->where('entries.entries_id_company', '=', $idCompany)
               ->get();
    }

    /**
     * Retorna somente o valor do caixa interno sem transferência
     *
     * @param [int] $idCompany
     * @return double
     */
    public function getInternalInternal($idCompany): float
    {
        $balance = Entry::where('entries_id_company', $idCompany)->get();
        $sumOfValue = 0;
        $subtrationOfValue = 0;
        foreach ($balance as $valueBank) {  
            $types = static::getTypeLancheToCompany($idCompany, $valueBank->entries_id_account);
            if ($valueBank->entries_bank == 0 && is_null($valueBank->entries_parent)) {
    
                foreach ($types as $type) {
                    if ($type->account_types_name === 'Despesa') {
                        $subtrationOfValue += $type->entries_value;
                    }
                    if ($type->account_types_name === 'Receita') {
                        $sumOfValue += $type->entries_value;
                    }
                }
            }
            elseif($valueBank->entries_bank > 0 && !is_null($valueBank->entries_parent)){
             // Se for transferência entre caixa para banco
                foreach ($types as $type) {
                    if($valueBank->transaction_id == 1 && $valueBank->entries_parent == 0)
                    {
                        $subtrationOfValue = ($subtrationOfValue + $type->entries_value);
                    }        
                }
            }
          
        }
        return ($sumOfValue - $subtrationOfValue);
    }

}