<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'region_name',
        'psgc_code',
        'region_code',
    ];

    public function provinces()
    {
        return $this->hasMany(Province::class, 'id');
    }

    public function cities()
    {
        return $this->hasMany(CitiesMunicipalities::class);
    }
}
