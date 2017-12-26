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

        $account = Account::create(['account_type_id' => 1]);
        DB::table('users')->insert([
            'name' => 'José Torres',
            'email' => 'josse.1397@gmail.com',
            'password' => bcrypt('123456'),
            'account_id' => $account->id,
        ]);
    }
}
