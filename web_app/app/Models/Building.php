<?php

/**
 * @OA\Schema(
 *     schema="Building",
 *     type="object",
 *     required={"address", "latitude", "longitude"},
 *     @OA\Property(property="address", type="string", example="г. Москва, ул. Ленина 1, офис 3"),
 *     @OA\Property(property="latitude", type="float", example=55.7558),
 *     @OA\Property(property="longitude", type="float", example=37.6176)
 * )
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
  protected $fillable = ['address', 'latitude', 'longitude'];

  public function organizations()
  {
    return $this->hasMany(Organization::class);
  }
}
