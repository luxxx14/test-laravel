<?php

/**
 * @OA\Schema(
 *     schema="Activity",
 *     type="object",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", example="Молочная продукция")
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
