<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use SoftDeletes;

    public function regions()
    {
        return $this->belongsTo(Region::class);
    }
    
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
