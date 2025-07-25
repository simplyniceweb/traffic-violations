<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'province_name',
        'psgc_code',
        'province_code',
        'region_id',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
    
    public function cities()
    {
        return $this->hasMany(CitiesMunicipalities::class);
    }
}
