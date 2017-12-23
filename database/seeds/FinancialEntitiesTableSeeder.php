<?php

use Illuminate\Database\Seeder;

class FinancialEntitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('financial_entities')->insert([
            'name' => 'Banco Popular Dominicano',
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);
    }
}
