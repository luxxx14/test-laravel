<?php

/**
 * @OA\Schema(
 *     schema="Building",
 *     type="object",
 *     required={"address", "latitude", "longitude"},
 *     @OA\Property(property="id", type="integer", description="ID здания"),
 *     @OA\Property(property="address", type="string", description="Адрес здания"),
 *     @OA\Property(property="latitude", type="number", format="float", description="Широта"),
 *     @OA\Property(property="longitude", type="number", format="float", description="Долгота")
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
