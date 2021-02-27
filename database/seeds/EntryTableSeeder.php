<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Entry;
use Faker\Factory;

class EntryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $date = $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now');
            Entry::insert([
                'entries_id_account' => $faker->numberBetween($min = 19, $max = 26),
                'entries_day' => $faker->numberBetween($min = 19, $max = 26),
                'entries_description' => $faker->sentence($nbWords = 4, $variableNbWords = true) ,
                'entries_id_company' => 1,
                'entries_id_user' => 4,
                'entries_value' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
                'entries_file' => 'null',
                'created_at' => $date,
                'entries_date_launch' => $date
            ]);
          }
    }
}
