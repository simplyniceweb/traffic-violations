<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrafficRule extends Model
{
    use SoftDeletes;
    
    protected $table = 'traffic_rules_list';

    protected $fillable = ['rule_name', 'description', 'photo'];
}
