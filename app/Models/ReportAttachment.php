<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportAttachment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'report_id',
        'file_path',
        'type',
    ];
    
    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
