<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('organizations')->insert([
            [
                'name' => 'ООО Рога и Копыта',
                'phone_numbers' => ['2-222-222', '3-333-333'],
                'building_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ИП Иванов',
                'phone_numbers' => '8-800-555-35-35',
                'building_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ЗАО Молочные продукты',
                'phone_numbers' => '8-923-666-13-13',
                'building_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
