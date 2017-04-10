<?php
use Faker\Factory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Models\ReceiptCompany::class, function (Faker\Generator $faker) {
    return [
      'receipt_received_from' => $faker->name,
      'receipt_reference' => $faker->realText(20),
      'receipt_value' => $faker->randomFloat(0,2,200),
      'receipt_local' => $faker->city,
      'receipt_date' => $faker->date()
    ];
});
