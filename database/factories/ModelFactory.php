<?php

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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\GiftCard::class, function (Faker\Generator $faker) {
	return [
			'card_number' => $faker->randomNumber(8) . $faker->randomNumber(8),
			'encyrpted_pin' => Crypt::encrypt($faker->randomNumber(6)),
			'balance' => $faker->randomFloat(3, 900.00, 999.00),
			'expiry_date' => $faker->dateTimeBetween('now', '+12 months'),
			'offer_price' => $faker->randomFloat(3, 800.00, 899.00),
			'user_id' => rand(1,6),
			'status' => 'available', //validating, available, incart, sold, hold 
			'brand_id' => rand(1, 6)
		];
		
});
