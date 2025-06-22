<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CitiesMunicipalities extends Model
{
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function barangays()
    {
        return $this->hasMany(Barangay::class, 'city_municipality_id');
    }
}
