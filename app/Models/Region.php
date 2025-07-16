<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use SoftDeletes;

    public function provinces()
    {
        return $this->hasMany(Province::class, 'id');
    }

    public function cities()
    {
        return $this->hasMany(CitiesMunicipalities::class);
    }
}
