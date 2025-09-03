<?php

namespace Seara\Http\Abstracts;

use Seara\Entry;
use function dump;
use Seara\AccountType;
use Illuminate\Support\Facades\DB;
use Seara\Service\Launch\LaunchService;
use Seara\Repository\AccountBankRepository;
use Illuminate\Database\Eloquent\Collection;

abstract class GeneralBalanceAbstract
{
    const TRANSFER = 1; // Lançamento de transferencia
    const BOXINTERNAL = 0;
    const LAUNCHBOXINTERNAL = 0;
    /**
     * Retorna somente o valor do caixa banco sem transferência
     *
     * @param [int] $idCompany
     * @return double
     */
    public function getBalanceBank($idCompany)
    {
        $balance = Entry::where('entries_id_company', $idCompany)->get();
        $idBoxInternal = AccountBankRepository::getAccountBankAndBankToCompany($idCompany);
        $sumOfValue = 0;
        $subtrationOfValue = 0;
        $transferOfValue = 0;
        $sumTransfer = 0;
     
        foreach ($balance as $valueBank) {
            // Tipo do caixa
          
           $type = AccountType::getNameType($valueBank->entries_id_account);
            if( $valueBank->entries_bank > 0 && 
                $type == 'Receita' && 
                $valueBank->parent_id === null &&
                $valueBank->transaction_id == 0 // Garante que não será transferência
                ) {
                $sumOfValue += $valueBank->entries_value;
               
            }
            if( $valueBank->entries_bank > 0 &&
                $type == 'Despesa' &&
                $valueBank->transaction_id == 0 // Garante que não será transferência
            ) {
                $subtrationOfValue += $valueBank->entries_value;
            }
            // @todo criar calculo de transferencia do caixa interno
            // Transferencia recebida do caixa interno
           
            if($valueBank->entries_bank > 0 && $type === 'Transferência') {
                
                if( $valueBank->transaction_id == 1 &&
                    $valueBank->entries_parent != 0 &&
                    $valueBank->entries_parent != self::BOXINTERNAL
                )
                {
                    $transferOfValue += $valueBank->entries_value;
                }
                if($valueBank->transaction_id == self::TRANSFER &&
                    $valueBank->entries_parent == self::BOXINTERNAL ||
                    $valueBank->entries_parent == -1
                )
                {
                    $sumOfValue += $valueBank->entries_value;
                }else if(
                    $valueBank->transaction_id == self::TRANSFER &&
                    $valueBank->entries_parent == self::BOXINTERNAL ||
                    $valueBank->entries_parent > 0
                )
                {
                    $subtrationOfValue += $valueBank->entries_value;
                }
            }
        }
           
        // dump($sumOfValue,$subtrationOfValue, $transferOfValue);
        return ( $sumOfValue - $subtrationOfValue );
    }

    /**
     * Retornar o tipo de receita ou despesas de um lancamento com base na empresa
     *
     * @param [int] $idCompanyP
     * @param [int] $accountLanunches
     * @return Entry
     */
    static public function getTypeLancheToCompany($idCompany, $accountLanunches): Collection
    {
        return Entry::join('account_launches', 'entries.entries_id_account', '=', 'account_launches.id')
            ->join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
            ->where('entries.entries_id_company', '=', $idCompany)
            ->get();
    }

    /**
     * Retorna somente o valor do caixa interno sem transferência
     *
     * @param [int] $idCompany
     * @return double
     */
    public function getInternalInternal($idCompany)
    {
         $balance = Entry::where('entries_id_company', $idCompany)->get();
        $sumOfValue = 0;
        $subtrationOfValue = 0;
        $transferOfValueSum = 0; // Soma os valores de transferencia recebido
        $transferOfValueSub = 0; // Soma os valores de transferencia repassado
        $idBoxInternal = AccountBankRepository::getAccountBankAndBankToCompany($idCompany);

        foreach ($balance as $key => $valueBank) {
            $type = AccountType::getNameType($valueBank->entries_id_account);
            if($valueBank->entries_bank == 0 && $type == 'Receita') {
                $sumOfValue += $valueBank->entries_value;
            }
            if($valueBank->entries_bank == 0  && $type == 'Despesa') {
                $subtrationOfValue += $valueBank->entries_value;
            }
          
            if($valueBank->entries_bank == 0  && $type === 'Transferência') {
               
                // if( $valueBank->transaction_id == 1 &&
                //     $valueBank->entries_parent != 0 &&
                //     $valueBank->entries_parent > 0)
                // {
                //     $transferOfValueSum += $valueBank->entries_value;
                // }else{
                //     $transferOfValueSub += $valueBank->entries_value;
                // }
            }

            // Transferencia recebida do caixa banco para caixa interno
            if($valueBank->entries_bank > 0  && $type === 'Transferência') {
               
                if( $valueBank->transaction_id == 1 &&
                    $valueBank->entries_parent > 0)
                {
                   
                    $sumOfValue += $valueBank->entries_value;
                }
                //else{
                //     $transferOfValueSub += $valueBank->entries_value;
                // }
               
            }

        }
        //  dump($sumOfValue, $subtrationOfValue, $transferOfValueSum );
          // $sumReceita = ($sumOfValue + $transferOfValueSum);
        return ($sumOfValue - $subtrationOfValue);

    }
}
