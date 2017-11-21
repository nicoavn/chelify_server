<?php

use Illuminate\Database\Seeder;

class AccountTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account_types')->insert([
            'name' => 'Personal',
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);

        DB::table('account_types')->insert([
            'name' => 'Grupo',
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);
    }
}
