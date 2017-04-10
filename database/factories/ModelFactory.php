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
        'user_phone' => $faker->tollFreePhoneNumber,
        'user_id_company' => 7,
        'user_id_profile' => 1,
        'user_birth' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'user_sex' => 'Masculino',
        'user_cpf' => $faker->randomFloat(0,15),
        'user_addr_street' => $faker->streetAddress,
        //'user_addr_number'=> $faker->numberBetween($min = 1, $max = 100),
        //'user_addr_complement' => $faker->sentences($nb = 3, $asText = false),
        'user_addr_district' =>  $faker->citySuffix,
        'user_addr_city' => $faker->city,
        'user_addr_state'=> $faker->state,
        'user_addr_cep' => $faker->randomNumber($nbDigits = NULL, $strict = false)
    ];
});


$factory->define(App\Models\ReceiptCompany::class, function (Faker\Generator $faker) {
    return [
      'receipt_received_from' => $faker->name,
      'receipt_reference' => $faker->realText(20),
      'receipt_value' => $faker->randomFloat(0,2,200),
      'receipt_local' => $faker->city,
      'receipt_local' => $faker->date()
    ];
});
