<?php

use Illuminate\Database\Seeder;

class PlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('places')->insert([
            'google_place_id' => 'ChIJSxROh9uJr44RHXhby08IiJk',
            'name' => 'McDonald\'s Tiradentes',
            'lat' => '18.47104',
            'lon' => '-69.925105',
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);

        DB::table('places')->insert([
            'google_place_id' => 'ChIJkYc3K-CJr44R3to4C53y8Qw',
            'name' => 'Wendys',
            'lat' => '18.4638554',
            'lon' => '-69.934276',
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);

        DB::table('places')->insert([
            'google_place_id' => 'ChIJ9wZafuOJr44RO1cywh3MUaY',
            'name' => 'Burger King',
            'lat' => '18.4828118',
            'lon' => '-69.8406699',
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);

        DB::table('places')->insert([
            'google_place_id' => 'ChIJEdIr9uyJr44RVjLt5BoMjDE',
            'name' => 'Burger King',
            'lat' => '18.4828118',
            'lon' => '-69.8406699',
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);
    }
}
