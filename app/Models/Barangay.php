<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barangay extends Model
{
    use SoftDeletes;

    public function cityMunicipality()
    {
        return $this->belongsTo(CitiesMunicipalities::class, 'city_municipality_id');
    }
}
