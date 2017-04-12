<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        factory(App\Models\User::class, 5)->create();

    }
}
