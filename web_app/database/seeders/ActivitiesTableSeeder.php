<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitiesTableSeeder extends Seeder
{
  public function run()
  {
    DB::table('activities')->insert([
      ['name' => 'Еда', 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
      ['name' => 'Мясная продукция', 'parent_id' => 1, 'created_at' => now(), 'updated_at' => now()],
      ['name' => 'Молочная продукция', 'parent_id' => 1, 'created_at' => now(), 'updated_at' => now()],
      ['name' => 'Автомобили', 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
      ['name' => 'Грузовые', 'parent_id' => 4, 'created_at' => now(), 'updated_at' => now()],
      ['name' => 'Легковые', 'parent_id' => 4, 'created_at' => now(), 'updated_at' => now()],
    ]);
  }
}
