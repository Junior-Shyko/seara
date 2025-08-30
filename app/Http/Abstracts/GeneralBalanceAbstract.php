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
    public function getBalanceBank($idCompany): float
    {
        $balance = Entry::where('entries_id_company', $idCompany)->get();
        $sumValueBank = 0;
        $subValueBank = 0;
     
        foreach ($balance as $valueBank) {
            // Tipo do caixa
            $type = AccountType::getNameType($valueBank->entries_id_account);
            // Receita que entrou no banco sem ser transferencia
            // Exemplo: Recebimento de cliente que entrou direto no banco
            // e não passou pelo caixa interno
            // Soma dos valores de receita
            if (
                $valueBank->entries_bank > 0 &&
                $type === 'Receita' &&
                $valueBank->entries_parent === null
            ) {
                $sumValueBank += $valueBank->entries_value;
            }
            // Soma dos valores de despesa
            if (
                $valueBank->entries_bank > 0 &&
                $type === 'Despesa' &&
                $valueBank->entries_parent === null
            ) {
                $subValueBank += $valueBank->entries_value;
            }

        }

        $generalBankValue = ($sumValueBank - $subValueBank);

        return $generalBankValue;
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
    public function getInternalInternal($idCompany): float
    {
        $balance = Entry::where('entries_id_company', $idCompany)->get();
        $valueInternalRecipe = 0;
        $valueInternalExpense = 0;
        foreach ($balance as $key => $valueBank) {
            // Tipo do caixa
            $type = AccountType::getNameType($valueBank->entries_id_account);
            // Soma dos valores de receita
            if (
                $valueBank->entries_bank == 0 &&
                $type === 'Receita' &&
                $valueBank->entries_parent == null
            ) {
                $valueInternalRecipe += $valueBank->entries_value;
            }
            // Soma dos valores de despesa
            if (
                $valueBank->entries_bank == 0 &&
                $type === 'Despesa' &&
                $valueBank->entries_parent === null
            ) {
                $valueInternalExpense += $valueBank->entries_value;
            }
        }

        return ($valueInternalRecipe - $valueInternalExpense);

    }
}
