<?php

use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {
    static $password;

    return [
        'title' => $faker->name,
        'amount' => $faker->numberBetween(10000, 999999) / 10,
        'account_id' => $faker->numberBetween(1, 3),

        'remember_token' => str_random(10),
    ];
});
