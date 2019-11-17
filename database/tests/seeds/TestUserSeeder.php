<?php

declare(strict_types=1);

namespace Tests\Seeds;

use DB;
use DateTime;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('companies')->insert([
            'company_id' => 1,
            'company_name' => 'Acme Corporations LTDA',
            'company_fantasy' => 'Megadodo Publications',
            'company_cnpj' => '07.847.427/0001-79',
            'company_addr_street' => 'Ursa',
            'company_addr_number' => 42,
            'company_addr_complement' => '',
            'company_addr_district' => 'Beta',
            'company_addr_city' => 'London',
            'company_addr_state' => 'SP',
            'company_addr_cep' => '42424242',
            'company_phone' => '1612345678',
            'company_mobile' => '1612345678',
            'company_brand_logo' => '1496023338_X5aDPm0L8u.jpg',
            'company_status' => 1,
            'company_manager' => 'Arthur Dent',
            'company_type' => 'fundacao'
        ]);

        DB::table('users')->insert([
            'name' => 'Ford Prefect',
            'email' => 'ford@megadodo.com',
            'user_phone' => '1611223344',
            'password' => '$2y$12$R.pe9pJmp28Lo5Dg8z/tTeKmGRWGS67Wni89Pe/ErBQQaIGGxzIdW',
            'user_position' => 'Presidente',
            'user_id_company' => 1,
            'user_id_profile' => 1,
            'user_birth' => new DateTime('1994-09-21'),
            'user_addr_street' => 'Ursa',
            'user_addr_number' => 42,
            'user_addr_complement' => '',
            'user_addr_district' => 'Beta',
            'user_addr_city' => 'London',
            'user_addr_state' => 'SP',
            'user_addr_cep' => '42424242',
            'users_avatar' => ''
        ]);
    }
}
