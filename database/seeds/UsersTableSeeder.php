<?php

use Faker\Factory;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('pt_BR');
        for ($i=0; $i < 50; $i++) { 
            DB::table('users')->insert([
                'name' => $faker->name(),
                'email' => $faker->email(),
                'password' => bcrypt('12345678'),
                'user_phone' => $faker->cellphoneNumber,
                'user_position' => null,
                'user_id_company' => $faker->numberBetween($min = 1, $max = 50),
                'user_id_profile' => $faker->numberBetween($min = 1, $max =3),
                'user_birth' => $faker->dateTimeThisCentury->format('Y-m-d'),
                'user_sex' => 'Masculino',
                'user_cpf' =>  $faker->cpf,
                'user_addr_street' => $faker->streetAddress,
                'user_addr_number' => $faker->randomDigit,
                'user_addr_complement' => $faker->word,
                'user_addr_district' =>  $faker->streetName,
                'user_addr_city' => $faker->city,
                'user_addr_state' =>  $faker->state,
                'user_addr_cep' =>  $faker->postcode,
            ]);
        }
    }
}
