<?php

use App\Account;
use App\Group;
use App\User;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account = Account::create(['account_type_id' => 2]);
        DB::table('groups')->insert([
            'title' => 'Un Grupo',
            'manager_id' => 1,
            'account_id' => $account->id,
            'target_amount' => 1429.99,
            'current_amount' => 450.00,
        ]);

        $account = Account::create(['account_type_id' => 2]);
        DB::table('groups')->insert([
            'title' => 'Un Grupo',
            'manager_id' => 2,
            'account_id' => $account->id,
            'target_amount' => 1333.99,
            'current_amount' => 255.00,
        ]);
    }
}
