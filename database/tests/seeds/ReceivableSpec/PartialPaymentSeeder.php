<?php

declare(strict_types=1);

namespace Tests\Seeds\ReceivableSpec;

use App\Service\Core\Util\UuidGenerator;
use DB;
use Tests\Seeds\Seeder;

class PartialPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $incomeCategories = [
            ['id' => UuidGenerator::generate(), 'name' => 'Venda de Certificados'],
            ['id' => UuidGenerator::generate(), 'name' => 'Venda de contratos'],
            ['id' => UuidGenerator::generate(), 'name' => 'Mensalidade'],
        ];

        $accounts = [
            ['id' => UuidGenerator::generate(), 'name' => 'Carteira', 'type' => 'money'],
            ['id' => UuidGenerator::generate(), 'name' => 'BB', 'type' => 'checking_account'],
            ['id' => UuidGenerator::generate(), 'name' => 'Itaú', 'type' => 'checking_account'],
            ['id' => UuidGenerator::generate(), 'name' => 'Outro', 'type' => 'other'],
        ];

        DB::table('income_category')->insert($incomeCategories);
        DB::table('account')->insert($accounts);

        DB::table('receivable')->insert([
            'id' => UuidGenerator::generate(),
            'amount' => 425.21,
            'due_date' => '2019-06-21',
            'description' => 'Mensalidade de serviços contábeis',
            'income_category_id' => $incomeCategories[2]['id'],
            'account_id' => $accounts[0]['id'],
        ]);
    }
}
