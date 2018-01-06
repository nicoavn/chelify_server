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
            ['name' => 'Comida rápida', 'transaction_category_type_id' => 2, 'icon' => 'fastfood'],
            ['name' => 'Restaurantes', 'transaction_category_type_id' => 2, 'icon' => 'restaurant'],
            ['name' => 'Ropa', 'transaction_category_type_id' => 2, 'icon' => 'clothes'],
            ['name' => 'Cosméticos', 'transaction_category_type_id' => 2, 'icon' => 'cosmetics'],
            ['name' => 'Estética', 'transaction_category_type_id' => 2, 'icon' => 'scissors'],
            ['name' => 'Salón de belleza', 'transaction_category_type_id' => 2, 'icon' => 'nail-polish'],
            ['name' => 'Peluquería', 'transaction_category_type_id' => 2, 'icon' => 'scissors'],
            ['name' => 'Supermercado', 'transaction_category_type_id' => 2, 'icon' => 'groceries'],
            ['name' => 'Colmado', 'transaction_category_type_id' => 2, 'icon' => 'colmado'],
            ['name' => 'Calzado', 'transaction_category_type_id' => 2, 'icon' => 'sneaker'],
            ['name' => 'Muebles', 'transaction_category_type_id' => 2, 'icon' => 'furniture'],
            ['name' => 'Electrodomésticos', 'transaction_category_type_id' => 2, 'icon' => 'appliances'],
            ['name' => 'Salud', 'transaction_category_type_id' => 2, 'icon' => 'health'],
            ['name' => 'Transporte', 'transaction_category_type_id' => 2, 'icon' => 'bus'],
            ['name' => 'Combustible', 'transaction_category_type_id' => 2, 'icon' => 'gas'],
            ['name' => 'Alcohol', 'transaction_category_type_id' => 2, 'icon' => 'alcohol'],
            ['name' => 'Educación', 'transaction_category_type_id' => 2, 'icon' => 'education'],
            ['name' => 'Comunicaciones', 'transaction_category_type_id' => 2, 'icon' => 'communication'],
            ['name' => 'Entretenimiento', 'transaction_category_type_id' => 2, 'icon' => 'entertainment'],
            ['name' => 'Gimnasio', 'transaction_category_type_id' => 2, 'icon' => 'gym'],
            ['name' => 'Recreación', 'transaction_category_type_id' => 2, 'icon' => 'carousel'],
            ['name' => 'Viaje', 'transaction_category_type_id' => 2, 'icon' => 'travel'],
            ['name' => 'Cultura', 'transaction_category_type_id' => 2, 'icon' => 'museum'],
            ['name' => 'Alquiler', 'transaction_category_type_id' => 2, 'icon' => 'rent'],
            ['name' => 'Hipoteca', 'transaction_category_type_id' => 2, 'icon' => 'mortgage'],
            ['name' => 'Hoteles', 'transaction_category_type_id' => 2, 'icon' => 'hotel'],
            ['name' => 'Tecnología', 'transaction_category_type_id' => 2, 'icon' => 'tech'],
            ['name' => 'Inversión', 'transaction_category_type_id' => 2, 'icon' => 'investment'],
            ['name' => 'Misceláneos', 'transaction_category_type_id' => 2, 'icon' => 'misc'],
            ['name' => 'Reparaciones', 'transaction_category_type_id' => 2, 'icon' => 'repair'],
            ['name' => 'Servicio de agua', 'transaction_category_type_id' => 2, 'icon' => 'water'],
            ['name' => 'Servicio de electricidad', 'transaction_category_type_id' => 2, 'icon' => 'electricity'],
            ['name' => 'Robo o pérdida', 'transaction_category_type_id' => 2, 'icon' => 'robbery'],
            ['name' => 'Gastos menores', 'transaction_category_type_id' => 2, 'icon' => 'others'],
            ['name' => 'Otro', 'transaction_category_type_id' => 2, 'icon' => 'others'],
        ];

        TransactionCategory::insert($transactionCategories);
    }
}
