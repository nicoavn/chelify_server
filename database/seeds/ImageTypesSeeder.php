<?php

use Illuminate\Database\Seeder;

class ImageTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('image_types')->insert([
            'name' => 'Perfil',
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);

        DB::table('image_types')->insert([
            'name' => 'Grupo',
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);
    }
}
