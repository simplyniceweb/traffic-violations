<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CitiesMunicipalities extends Model
{
    use SoftDeletes;

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function barangays()
    {
        return $this->hasMany(Barangay::class, 'city_municipality_id');
    }
}
