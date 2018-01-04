<?php

use App\TransactionCategory;
use Illuminate\Database\Seeder;

class TransactionCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactionCategories = [
            ['name' => 'Comida rápida', 'transaction_category_type_id' => 2],
            ['name' => 'Restaurantes', 'transaction_category_type_id' => 2],
            ['name' => 'Ropa', 'transaction_category_type_id' => 2],
            ['name' => 'Cosméticos', 'transaction_category_type_id' => 2],
            ['name' => 'Estética', 'transaction_category_type_id' => 2],
            ['name' => 'Salón de belleza', 'transaction_category_type_id' => 2],
            ['name' => 'Peluquería', 'transaction_category_type_id' => 2],
            ['name' => 'Supermercado', 'transaction_category_type_id' => 2],
            ['name' => 'Colmado', 'transaction_category_type_id' => 2],
            ['name' => 'Calzado', 'transaction_category_type_id' => 2],
            ['name' => 'Muebles', 'transaction_category_type_id' => 2],
            ['name' => 'Electrodomésticos', 'transaction_category_type_id' => 2],
            ['name' => 'Salud', 'transaction_category_type_id' => 2],
            ['name' => 'Transporte', 'transaction_category_type_id' => 2],
            ['name' => 'Combustible', 'transaction_category_type_id' => 2],
            ['name' => 'Alcohol', 'transaction_category_type_id' => 2],
            ['name' => 'Educación', 'transaction_category_type_id' => 2],
            ['name' => 'Comunicaciones', 'transaction_category_type_id' => 2],
            ['name' => 'Entretenimiento', 'transaction_category_type_id' => 2],
            ['name' => 'Gimnasio', 'transaction_category_type_id' => 2],
            ['name' => 'Recreación', 'transaction_category_type_id' => 2],
            ['name' => 'Viaje', 'transaction_category_type_id' => 2],
            ['name' => 'Cultura', 'transaction_category_type_id' => 2],
            ['name' => 'Alquiler', 'transaction_category_type_id' => 2],
            ['name' => 'Hipoteca', 'transaction_category_type_id' => 2],
            ['name' => 'Hoteles', 'transaction_category_type_id' => 2],
            ['name' => 'Tecnología', 'transaction_category_type_id' => 2],
            ['name' => 'Inversión', 'transaction_category_type_id' => 2],
            ['name' => 'Misceláneos', 'transaction_category_type_id' => 2],
            ['name' => 'Reparaciones', 'transaction_category_type_id' => 2],
            ['name' => 'Servicio de agua', 'transaction_category_type_id' => 2],
            ['name' => 'Servicio de electricidad', 'transaction_category_type_id' => 2],
            ['name' => 'Robo o pérdida', 'transaction_category_type_id' => 2],
            ['name' => 'Gastos menores', 'transaction_category_type_id' => 2],
            ['name' => 'Otro', 'transaction_category_type_id' => 2],
        ];

        TransactionCategory::insert($transactionCategories);
    }
}
