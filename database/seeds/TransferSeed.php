<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class TransferSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('pt_BR');
        for ($i = 0; $i < 10; $i++) {
            $date = $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now');
            DB::table('bank_accounts')->insert([
                'name' => str_random(10),
                'bank_name' => $faker->name(),
                'agency' => $faker->number(),
                'account_number' => $faker->number()
            ]);
          }
    }
}
