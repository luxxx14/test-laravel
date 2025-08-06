<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Organization",
 *     type="object",
 *     required={"id", "name", "phone_numbers", "building_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="ООО Рога и Копыта"),
 *     @OA\Property(property="phone_numbers", type="array", items=@OA\Items(type="string"), example={"2-222-222", "3-333-333"}),
 *     @OA\Property(property="building_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-01T11:15:26"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-01T11:15:26")
 * )
 */
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

