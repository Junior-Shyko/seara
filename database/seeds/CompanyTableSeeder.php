<?php

use Faker\Factory;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('pt_BR');
        // $faker->addProvider(new Faker\Provider\pt_BR\Address);
        for ($i=0; $i < 50; $i++) { 
            DB::table('companies')->insert([
                'company_name' => $faker->name(),
                'company_fantasy' => $faker->name(),
                'company_cnpj' => $faker->cnpj,
                'company_addr_street'  => $faker->streetAddress,
                'company_addr_number' => $faker->numberBetween($min = 1, $max = 1000),
                'company_addr_complement' => $faker->numberBetween($min = 1, $max = 4),
                'company_addr_district' =>null,
                'company_addr_city' => $faker->city,
                'company_addr_state' =>  $faker->state,
                'company_addr_cep' =>  $faker->postcode,
                'company_phone' => $faker->cellphoneNumber,
                'company_mobile' => $faker->cellphoneNumber,
                'company_brand_logo' =>  null,
                'company_status' => 1,
                'company_manager' =>  $faker->name(),
                'company_type' =>  'outro',
            ]);
        }
    }
}
