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
        $manager = User::inRandomOrder()->get()->first();

        $account = Account::create(['account_type_id' => 2]);
        $id = DB::table('groups')->insertGetId([
            'title' => 'Un Grupo',
            'manager_id' => $manager->id,
            'account_id' => $account->id,
            'target_amount' => 1429.99,
            'current_amount' => 450.00,
        ]);

        $group = Group::find($id);

        do
            $user = User::inRandomOrder()->get()->first();
        while($user->id == $manager->id);

        DB::table('group_user')->insert([
            'group_id' => $group->id,
            'user_id' => $user->id
        ]);
    }
}
