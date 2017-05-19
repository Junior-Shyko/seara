<?php

use Illuminate\Database\Seeder;
use App\Models\ReceiptCompany;
use App\Models\User;
use Faker\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ReceiptCompany::class);
        $this->call(UsersTableSeeder::class);
    }
}
