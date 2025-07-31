<?php

/**
 * @OA\Schema(
 *     schema="Organization",
 *     type="object",
 *     required={"name", "building_id"},
 *     @OA\Property(property="id", type="integer", description="ID организации"),
 *     @OA\Property(property="name", type="string", description="Название организации"),
 *     @OA\Property(property="building_id", type="integer", description="ID здания"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Дата обновления")
 * )
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'building_id'];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }
}
