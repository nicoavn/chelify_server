<?php

use App\Account;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account = Account::create(['account_type_id' => 1]);
        DB::table('users')->insert([
            'name' => 'Alvin Durán',
            'email' => 'nicoavn@gmail.com',
            'password' => bcrypt('Sser45t45'),
            'account_id' => $account->id,
        ]);

        // Default Cash Financial Instrument
        DB::table('financial_instruments')->insert([
            'identifier' => 'Efectivo',
            'alias' => '',
            'balance' => 0.0,
            'account_id' => $account->id,
            'financial_instrument_type_id' => 4
        ]);

        $account = Account::create(['account_type_id' => 1]);
        DB::table('users')->insert([
            'name' => 'José Torres',
            'email' => 'josse.1397@gmail.com',
            'password' => bcrypt('123456'),
            'account_id' => $account->id,
        ]);

        // Default Cash Financial Instrument
        DB::table('financial_instruments')->insert([
            'identifier' => 'Efectivo',
            'alias' => '',
            'balance' => 0.0,
            'account_id' => $account->id,
            'financial_instrument_type_id' => 4
        ]);

        $account = Account::create(['account_type_id' => 1]);
        DB::table('users')->insert([
            'name' => 'Usuario 1',
            'email' => 'usuario1@example.com',
            'password' => bcrypt('123456'),
            'account_id' => $account->id,
        ]);

        // Default Cash Financial Instrument
        DB::table('financial_instruments')->insert([
            'identifier' => 'Efectivo',
            'alias' => '',
            'balance' => 0.0,
            'account_id' => $account->id,
            'financial_instrument_type_id' => 4
        ]);

        $account = Account::create(['account_type_id' => 1]);
        DB::table('users')->insert([
            'name' => 'Usuario 2',
            'email' => 'usuario2@example.com',
            'password' => bcrypt('123456'),
            'account_id' => $account->id,
        ]);

        // Default Cash Financial Instrument
        DB::table('financial_instruments')->insert([
            'identifier' => 'Efectivo',
            'alias' => '',
            'balance' => 0.0,
            'account_id' => $account->id,
            'financial_instrument_type_id' => 4
        ]);
    }
}
