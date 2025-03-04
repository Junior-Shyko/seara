<?php

namespace Seara\Http\Abstracts;

use Seara\AccountType;
use Seara\Entry;
use Illuminate\Database\Eloquent\Collection;
use Seara\Repository\AccountBankRepository;
use function dump;

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
        $idBoxInternal = 29;
        $transferOfValue = 0;
        $sumTransfer = 0;
        foreach ($balance as $valueBank) {
            $type = AccountType::getNameType($valueBank->entries_id_account);
            if($valueBank->entries_bank !== $idBoxInternal && $type == 'Receita') {
                $sumOfValue += $valueBank->entries_value;
            }
            if($valueBank->entries_bank !== $idBoxInternal && $type == 'Despesa') {
                $subtrationOfValue += $valueBank->entries_value;
            }
            // Transferencia entre bancos
            if($valueBank->entries_bank !== $idBoxInternal && $type === 'Transferência') {
                if( $valueBank->transaction_id == 1 &&
                    $valueBank->entries_parent != 0 &&
                    $valueBank->entries_parent != $idBoxInternal
                )
                {
                    $transferOfValue += $valueBank->entries_value;
                }
                // Transferencia que o banco recebeu do caixa interno
                if($valueBank->transaction_id == 1 && $valueBank->entries_parent == $idBoxInternal)
                {
                    $sumTransfer += $valueBank->entries_value;
                }
            }
        }

        return ( ($sumOfValue - $subtrationOfValue - $transferOfValue) + $sumTransfer);
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
//               ->whereIn('account_launches.id',[$accountLanunches])
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
        $transferOfValueSum = 0; // Soma os valores de transferencia recebido
        $transferOfValueSub = 0; // Soma os valores de transferencia repassado
        $typesAccount = AccountBankRepository::getRelationAccountBank();
        $idBoxInternal = 29;

        foreach ($balance as $key => $valueBank) {
            $type = AccountType::getNameType($valueBank->entries_id_account);

            if($valueBank->entries_bank == $idBoxInternal && $type == 'Receita') {
                $sumOfValue += $valueBank->entries_value;
            }
            if($valueBank->entries_bank == $idBoxInternal && $type == 'Despesa') {
                $subtrationOfValue += $valueBank->entries_value;
            }
            if($valueBank->entries_bank == $idBoxInternal && $type === 'Transferência') {
                if( $valueBank->transaction_id == 1 &&
                    $valueBank->entries_parent != 0 &&
                    $valueBank->entries_parent > 0)
                {
                    $transferOfValueSum += $valueBank->entries_value;
                }else{
                    $transferOfValueSub += $valueBank->entries_value;
                }
            }

        }
        $sumReceita = ($sumOfValue + $transferOfValueSum);
        return ($sumReceita - $subtrationOfValue - $transferOfValueSub);
    }

}