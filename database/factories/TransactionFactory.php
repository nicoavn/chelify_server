<?php

use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {
    $account = \App\Account::where('account_type_id', 1)->inRandomOrder()->get()->first();
    $financialInstrument = $account->financialInstruments->first();
    $transactionCategory = \App\TransactionCategory::inRandomOrder()->get()->first();
    $place = \App\Place::inRandomOrder()->get()->first();

    return [
        'title' => ucfirst($faker->randomElement(["Gasto-A", "Gasto-B", "Gasto-C"])),
        'amount' => $faker->numberBetween(10000, 999999) / 10,
        'financial_instrument_id' => $financialInstrument->id,
        'transaction_category_id' => $transactionCategory->id,
        'place_id' => $place->id,
        'created_at' => $faker->dateTimeThisYear(),
    ];
});
