<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Activity;
use App\Models\Organization;

class ActivityOrganizationSeeder extends Seeder
{
  public function run()
  {
    $organizations = Organization::all();
    $activities = Activity::all();

    if ($organizations->isEmpty() || $activities->isEmpty()) {
      return;
    }

    foreach ($organizations as $organization) {
      foreach ($activities as $activity) {
        DB::table('activity_organization')->insert([
          'organization_id' => $organization->id,
          'activity_id' => $activity->id,
          'created_at' => now(),
          'updated_at' => now(),
        ]);
      }
    }
  }
}
