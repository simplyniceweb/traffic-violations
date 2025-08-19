<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barangay extends Model
{
    use SoftDeletes;

    protected $table = 'barangays';

    protected $fillable = [
        'brgy_code',
        'brgy_name',
        'city_municipality_id',
    ];

    public function cityMunicipality()
    {
        return $this->belongsTo(CitiesMunicipalities::class, 'city_municipality_id');
    }
}
