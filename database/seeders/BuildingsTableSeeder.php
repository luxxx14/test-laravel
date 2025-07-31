<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuildingsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('buildings')->insert([
            [
                'address' => 'г. Москва, ул. Ленина 1, офис 3',
                'latitude' => 55.7558,
                'longitude' => 37.6173,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'address' => 'г. Санкт-Петербург, Невский проспект, 22',
                'latitude' => 59.9343,
                'longitude' => 30.3351,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'address' => 'г. Казань, ул. Баумана, 45',
                'latitude' => 55.7963,
                'longitude' => 49.1088,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
