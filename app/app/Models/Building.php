<?php

/**
 * @OA\Schema(
 *     schema="Building",
 *     type="object",
 *     required={"address", "latitude", "longitude"},
 *     @OA\Property(property="id", type="integer", description="ID of the building"),
 *     @OA\Property(property="address", type="string", description="Address of the building"),
 *     @OA\Property(property="latitude", type="number", format="float", description="Latitude of the building"),
 *     @OA\Property(property="longitude", type="number", format="float", description="Longitude of the building")
 * )
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillable = ['address', 'latitude', 'longitude'];

    // Связь с организацией
    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }
}
