<?php

use Faker\Generator as Faker;
use App\Account;

$factory->define(App\Transaction::class, function (Faker $faker) {
    $account = Account::where('account_type_id', 1)->inRandomOrder()->get()->first();
    $financialInstrument = $account->financialInstruments->first();

    return [
        'title' => $faker->name,
        'amount' => $faker->numberBetween(10000, 999999) / 10,
        'account_id' => $account->id,
        'financial_instrument_id' => $financialInstrument->id,
        'remember_token' => str_random(10),
    ];
});
