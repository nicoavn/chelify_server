<?php

use Illuminate\Database\Seeder;

class FinancialInstrumentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('financial_instrument_types')->insert([
            'name' => 'Cuenta Bancaria',
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);

        DB::table('financial_instrument_types')->insert([
            'name' => 'Tarjeta de Crédito',
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);

        DB::table('financial_instrument_types')->insert([
            'name' => 'Tarjeta de Débito',
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);

        DB::table('financial_instrument_types')->insert([
            'name' => 'Otros',
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);
    }
}
