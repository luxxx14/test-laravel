<?php

/**
 * @OA\Schema(
 *     schema="Organization",
 *     type="object",
 *     required={"name", "phone_numbers", "building_id"},
 *     @OA\Property(property="name", type="string", example="ООО Рога и Копыта"),
 *     @OA\Property(property="phone_numbers", type="array", items=@OA\Items(type="string"), example={"2-222-222", "3-333-333"}),
 *     @OA\Property(property="building_id", type="integer", example=1)
 * )
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
  protected $fillable = ['name', 'phone_numbers', 'building_id'];

  public function building()
  {
    return $this->belongsTo(Building::class);
  }

  public function activities()
  {
    return $this->belongsToMany(Activity::class);
  }
}

