<?php

declare(strict_types=1);

use App\Service\Core\Util\UuidGenerator;
use Illuminate\Database\Seeder;

class ReceivableSpecSeeder extends Seeder
{
    public function run()
    {
        DB::table('income_category')->insert([
            ['id' => UuidGenerator::generate(), 'name' => 'Venda de Certificados'],
            ['id' => UuidGenerator::generate(), 'name' => 'Venda de contratos'],
            ['id' => UuidGenerator::generate(), 'name' => 'Mensalidade'],
        ]);

        DB::table('account')->insert([
            ['id' => UuidGenerator::generate(), 'name' => 'Carteira', 'type' => 'money'],
            ['id' => UuidGenerator::generate(), 'name' => 'BB', 'type' => 'checking_account'],
            ['id' => UuidGenerator::generate(), 'name' => 'Itaú', 'type' => 'checking_account'],
            ['id' => UuidGenerator::generate(), 'name' => 'Outro', 'type' => 'other'],
        ]);
    }
}
