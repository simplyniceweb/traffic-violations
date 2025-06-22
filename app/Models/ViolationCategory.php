<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViolationCategory extends Model
{
    public function reports()
    {
        return $this->belongsToMany(Report::class, 'report_violation');
    }
}
