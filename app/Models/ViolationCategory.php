<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ViolationCategory extends Model
{
    use SoftDeletes;
    
    public function reports()
    {
        return $this->belongsToMany(Report::class, 'report_violation');
    }
}
