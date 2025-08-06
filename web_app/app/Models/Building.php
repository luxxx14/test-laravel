<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Building",
 *     type="object",
 *     required={"id", "address", "latitude", "longitude"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="address", type="string", example="г. Москва, ул. Ленина 1, офис 3"),
 *     @OA\Property(property="latitude", type="number", format="float", example=55.7558),
 *     @OA\Property(property="longitude", type="number", format="float", example=37.6176),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-01T11:15:26"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-01T11:15:26")
 * )
 */
class Building extends Model
{
  protected $fillable = ['address', 'latitude', 'longitude'];

  public function organizations()
  {
    return $this->hasMany(Organization::class);
  }
}
