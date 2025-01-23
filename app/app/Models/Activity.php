<?php

/**
 * @OA\Schema(
 *     schema="Activity",
 *     type="object",
 *     required={"name"},
 *     @OA\Property(property="id", type="integer", description="ID of the activity"),
 *     @OA\Property(property="name", type="string", description="Name of the activity"),
 *     @OA\Property(property="parent_id", type="integer", description="ID of the parent activity")
 * )
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    // Связь с организациями
    public function organizations()
    {
        return $this->belongsToMany(Organization::class);
    }

    // Связь с родительским видом деятельности
    public function parent()
    {
        return $this->belongsTo(Activity::class, 'parent_id');
    }

    // Связь с дочерними видами деятельности
    public function children()
    {
        return $this->hasMany(Activity::class, 'parent_id');
    }

    public static function getWithParentAndChildren($id)
    {
        return self::with(['parent', 'children'])->find($id);
    }
}
