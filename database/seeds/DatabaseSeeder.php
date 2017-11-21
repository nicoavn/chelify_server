<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AccountTypesTableSeeder::class);
        $this->call(FinancialInstrumentTypesTableSeeder::class);
        $this->call(TransactionCategoryTypesTableSeeder::class);
    }
}
