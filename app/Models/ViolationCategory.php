<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ViolationCategory extends Model
{
    use SoftDeletes;

    protected $table = 'violation_categories';

    protected $fillable = [
        'name',
        'type',
    ];
    
    public function reports()
    {
        // return $this->belongsToMany(Report::class, 'report_violation');
        return $this->belongsToMany(
            Report::class,
            'report_violation',
            'violation_category_id',
            'report_id'
        );
    }
}
