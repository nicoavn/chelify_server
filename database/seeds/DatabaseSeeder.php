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
        $this->call(TransactionCategoriesTableSeeder::class);
        $this->call(FinancialEntitiesTableSeeder::class);
        $this->call(ImageTypesSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(FinancialInstrumentsTableSeeder::class);
        $this->call(PlacesTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(GroupUserTableSeeder::class);
    }
}
