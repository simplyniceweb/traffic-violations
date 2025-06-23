<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'region_id',
        'province_id',
        'city_municipality_id',
        'barangay_id',
        'description',
        'incident_date',
    ];

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

    public function region() {
        return $this->belongsTo(Region::class);
    }

    public function province() {
        return $this->belongsTo(Province::class);
    }

    public function city() {
        return $this->belongsTo(CitiesMunicipalities::class, 'city_municipality_id');
    }

    public function barangay() {
        return $this->belongsTo(Barangay::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
