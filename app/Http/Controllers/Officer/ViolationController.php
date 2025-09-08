<?php

namespace App\Http\Controllers\Officer;

use App\Models\Region;
use App\Models\Report;
use App\Models\Barangay;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Models\ViolationCategory;
use App\Http\Controllers\Controller;
use App\Models\CitiesMunicipalities;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReportAccepted;

class ViolationController extends Controller
{
    public function index()
    {
        $violations = Report::with('reporter', 'officer', 'category', 'barangay')
            ->where('city_municipality_id', Auth::user()->city_municipality_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('officer.violations.index', compact('violations'));
    }

    public function show($id)
    {
        $violation = Report::with('reporter', 'officer', 'category', 'barangay')
            ->findOrFail($id);

        return view('officer.violations.show', compact('violation'));
    }

    public function edit($id)
    {
        $report = Report::with('reporter', 'officer', 'category', 'barangay')->findOrFail($id);
        $violations = ViolationCategory::all();
        $regions = Region::orderBy('region_name', 'asc')->get();
        $provinces = Province::where('region_id', $report->region_id)->get();
        $cities = CitiesMunicipalities::where('province_id', $report->province_id)->get();
        $barangays = Barangay::where('city_municipality_id', $report->city_municipality_id)->get();

        return view('officer.violations.edit', compact('report', 'regions', 'provinces', 'cities', 'barangays', 'violations'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string',
            'incident_date' => 'required|date',
            'region_id' => 'required|exists:regions,id',
            'province_id' => 'required|exists:provinces,id',
            'city_municipality_id' => 'required|exists:cities_municipalities,id',
            'barangay_id' => 'required|exists:barangays,id',
            'violation_type' => 'required|array',
            'violation_type.*' => 'exists:violation_categories,id',
            'status' => 'required|string',
            'street' => 'nullable|string',
            'landmark' => 'nullable|string',
            'evidence' => 'nullable|array',
            'evidence.*' => 'file|mimes:jpg,jpeg,png,mp4,mov,avi|max:10240',
            'reason' => 'nullable|string',
            'accept' => 'nullable|boolean'
        ]);

        $report = Report::with('attachments')->findOrFail($id);

        if (!$report || $report->trashed()) {
            return redirect()->route('reports.index')->with('error', 'Cannot update a deleted or non-existent report.');
        }

        if ($report->officer !== null && ($request->status === 'rejected' || $request->status === 'resolved')) {
            $reporter = $report->user;
            $reporter->notify(new ReportAccepted($report, $request->status));
        }

        // dd($request->accept);

        $report->update([
            'description' => $request->description,
            'incident_date' => $request->incident_date,
            'region_id' => $request->region_id,
            'province_id' => $request->province_id,
            'city_municipality_id' => $request->city_municipality_id,
            'barangay_id' => $request->barangay_id,
            'status' => $request->status,
            'street' => $request->street,
            'landmark' => $request->landmark,
            'reason' => $request->reason,
            'officer_id' => $request->accept ? Auth::id() : null,
        ]);

        // Sync violations
        $report->violations()->sync($request->violation_type);

        // Optional: Handle new attachments
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $path = $file->store('reports', 'public');

                $type = in_array($file->getClientOriginalExtension(), ['mp4', 'mov', 'avi']) ? 'video' : 'photo';

                $report->attachments()->create([
                    'file_path' => $path,
                    'type' => $type,
                ]);
            }
        }

        return redirect()->route('officer.violations.index')->with('success', 'Report updated successfully.');
    }

    public function destroy($id)
    {
        $violation = Report::findOrFail($id);
        $violation->delete();

        return redirect()->route('officer.violations.index')
            ->with('success', 'Violation deleted successfully.');
    }

    public function restore()
    {
    }

    public function status(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,under_review,resolved,rejected',
        ]);

        $report = Report::findOrFail($id);

        if ($report->trashed()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot update status of a deleted report.'
            ], 400);
        }

        $status = $request->status;

        $report->status = $status;
        $report->officer_id =  $status === 'pending' ? null : Auth::id();
        $report->save();

        if ($status === 'under_review') {
            $reporter = $report->user;
            $reporter->notify(new ReportAccepted($report));
        }

        return response()->json([
            'success' => true,
            'status' => $report->status
        ]);
    }
}
