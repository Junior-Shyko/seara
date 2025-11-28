<?php

namespace Seara\Service\Financial;

use Seara\FinancialAccount;

class FinancialAccountService
{
    /**
     * Método estático para criar uma nova conta do tipo 'cash'
     *
     * @param array $data Dados para criar a conta (ex.: ['name' => 'Caixa Principal', 'company_id' => 1, ...])
     * @return FinancialAccount A conta criada
     * @throws \Exception Se dados obrigatórios estiverem faltando
     */
    public static function createCashAccount(array $data)
    {
        // Força o tipo para 'cash'
        $data['type'] = 'cash';

        // Validação básica (adicione mais validações se necessário, usando Validator do Laravel)
        if (empty($data['name'])) {
            throw new \Exception('O campo "name" é obrigatório.');
        }
        if (empty($data['company_id'])) {
            throw new \Exception('O campo "company_id" é obrigatório.');
        }

        // Campos opcionais com defaults (exemplo)
        $data['is_active'] = $data['is_active'] ?? true;
        $data['current_balance'] = $data['current_balance'] ?? 0.00;

        // Cria o registro usando Eloquent
        $account = FinancialAccount::create($data);

        // Opcional: Atualiza o saldo inicial (se houver lançamentos iniciais, mas como é novo, provavelmente é 0)
        $account->updateBalance();

        return $account;
    }
}