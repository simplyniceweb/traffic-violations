<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Report;

class ViolationController extends Controller
{
    public function index()
    {
        $violations = Report::with('reporter', 'officer', 'category', 'barangay')
            ->orderBy('created_at', 'desc')
            ->withTrashed()
            ->get();

        return view('admin.violations.index', compact('violations'));
    }

    public function show($id)
    {
        $violation = Report::with('reporter', 'officer', 'category', 'barangay')
            ->findOrFail($id);

        return view('admin.violations.show', compact('violation'));
    }
}
