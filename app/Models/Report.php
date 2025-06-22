<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function category()
    {
        return $this->belongsTo(ViolationCategory::class, 'violation_category_id');
    }

    public function attachments()
    {
        return $this->hasMany(ReportAttachment::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(ReportStatusLog::class);
    }
    
    public function violations()
    {
        return $this->belongsToMany(ViolationCategory::class, 'report_violation');
    }
}
