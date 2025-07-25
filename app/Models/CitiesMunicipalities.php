<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CitiesMunicipalities extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'city_code',
        'city_name',
        'psgc_code',
        'province_id',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function barangays()
    {
        return $this->hasMany(Barangay::class, 'city_municipality_id');
    }
}
