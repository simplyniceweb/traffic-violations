<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public function regions()
    {
        return $this->belongsTo(Region::class);
    }
    
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
