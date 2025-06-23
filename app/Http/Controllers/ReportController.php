<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\CitiesMunicipalities;
use App\Models\Province;
use App\Models\Region;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\ViolationCategory;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {

        $reports = \App\Models\Report::with([
                'region:id,region_name',
                'province:id,province_name',
                'city:id,city_name',
                'barangay:id,brgy_name',
                'user:id,name'
        ])->latest()->paginate(10);

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        $violations = ViolationCategory::all();
        
        $regions = Region::orderBy('region_name')->get();

        return view('reports.create', compact('violations', 'regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'violation_type' => 'required|exists:violation_categories,id',
            'region_id' => 'required|exists:regions,id',
            'province_id' => 'required|exists:provinces,id',
            'city_municipality_id' => 'required|exists:cities_municipalities,id',
            'barangay_id' => 'required|exists:barangays,id',
            'description' => 'required|string',
            'datetime' => 'required|date',
            'evidence' => 'nullable|array',
            'evidence.*' => 'file|mimes:jpg,jpeg,png,mp4,mov,avi|max:10240',
        ]);

        $report = Report::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'region_id' => $request->region_id,
            'province_id' => $request->province_id,
            'city_municipality_id' => $request->city_municipality_id,
            'barangay_id' => $request->barangay_id,
            'description' => $request->description,
            'incident_date' => Carbon::parse(str_replace('T', ' ', $request->datetime)),
        ]);

        // Attach the violation type to the report
        $report->violations()->sync($request->violation_type);

        // Handle file uploads
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $path = $file->store('reports', 'public');

                // Determine the type
                $extension = strtolower($file->getClientOriginalExtension());
                $type = in_array($extension, ['mp4', 'mov', 'avi']) ? 'video' : 'photo';

                // Save to report_attachments table
                $report->attachments()->create([
                    'file_path' => $path,
                    'type' => $type,
                ]);
            }
        }

        return redirect()->route('reports.index')->with('success', 'Report submitted successfully.');
    }

    public function show(Report $report)
    {
        $report->load(['violations', 'attachments']);

        return view('reports.show', compact('report'));
    }
}
