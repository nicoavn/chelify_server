<?php

use Illuminate\Database\Seeder;

class TransactionCategoryTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transaction_category_types')->insert([
            'name' => 'Ingresos',
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);

        DB::table('transaction_category_types')->insert([
            'name' => 'Egresos',
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);
    }
}
