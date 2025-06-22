<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public function province()
    {
        return $this->hasMany(Province::class);
    }
}
