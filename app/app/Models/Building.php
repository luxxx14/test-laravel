<?php

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
