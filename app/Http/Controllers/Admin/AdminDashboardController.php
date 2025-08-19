<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Report;

class AdminDashboardController extends Controller
{
    public function index() {
        $violations_count = Report::count();
        $violations = Report::with('reporter', 'officer', 'category', 'barangay')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $reportCounts = Report::selectRaw("
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'under_review' THEN 1 ELSE 0 END) as under_review,
                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
                SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved
            ")->first();

        return view('dashboard.admin', [
            'violations_count' => $violations_count, 
            'violations' => $violations,
            'reportCounts' => $reportCounts
        ]);
    }
}
