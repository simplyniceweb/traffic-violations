<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    public function cityMunicipality()
    {
        return $this->belongsTo(CitiesMunicipalities::class, 'city_municipality_id');
    }
}
