<?php

namespace App\Http\Controllers;

use App\Models\TrafficRule;
use Illuminate\Http\Request;

class TrafficRulesController extends Controller
{
    public function index()
    {
        $trafficRules = TrafficRule::whereNull('deleted_at')->get();
        return view('traffic-rules', compact('trafficRules'));
    }
}
