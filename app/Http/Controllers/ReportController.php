<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Region;
use App\Models\Report;
use App\Models\Barangay;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Models\ReportAttachment;
use App\Models\ViolationCategory;
use App\Models\CitiesMunicipalities;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function dashboard()
    {
        $violations_count = Report::where('user_id', Auth::id())
            ->count();

        $violations = Report::with('reporter', 'officer', 'category', 'barangay')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $reportCounts = Report::selectRaw("
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'under_review' THEN 1 ELSE 0 END) as under_review,
                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
                SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved
            ")
        ->where('user_id', Auth::id())
        ->first();

        return view('dashboard.reporter', compact('violations_count', 'violations', 'reportCounts'));
    }

    public function index(Request $request)
    {
        $status = $request->query('status');

        $reports = Report::with([
                'region:id,region_name',
                'province:id,province_name',
                'city:id,city_name',
                'barangay:id,brgy_name',
                'user:id,name'
        ])
        ->where('user_id', Auth::id())
        ->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

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
            'street' => 'nullable|string',
            'landmark' => 'nullable|string',
        ]);

        $report = Report::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'region_id' => $request->region_id,
            'province_id' => $request->province_id,
            'city_municipality_id' => $request->city_municipality_id,
            'barangay_id' => $request->barangay_id,
            'description' => $request->description,
            'incident_date' => Carbon::parse(str_replace('T', ' ', $request->datetime)),
            'street' => $request->street,
            'landmark' => $request->landmark
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

        $status = $this->sendSmsToOfficers($report->id, $request->city_municipality_id);

        return redirect()->route('reports.index')
            ->with('success', 'Report submitted successfully.')
            ->with('warning', $status);
    }

    protected function sendSmsToOfficers($reportId, $cityMunicipalityId)
    {
        // Get on-duty officers for the city
        $officers = User::where('role', 'officer')
            ->where('city_municipality_id', $cityMunicipalityId)
            ->where('on_duty', 1)
            ->pluck('phone');

        if ($officers->isEmpty()) {
            return 'No on-duty officers available in this city.';
        }

        // Normalize phone numbers to 09XXXXXXXXX
        $phoneNumbers = $officers->map(function ($num) {
            if (str_starts_with($num, '+63')) {
                return '0' . substr($num, 3);
            }

            if (str_starts_with($num, '63')) {
                return '0' . substr($num, 2);
            }

            return $num;
        });

        // Prepare message
        $message = "New traffic violation reported in your assigned city. Violation ID: {$reportId}. Please check the system for details.";

        // dd($phoneNumbers, $message);        
        if ($phoneNumbers->count() === 1) {
            // Single officer → use single SMS endpoint
            Http::post("https://www.iprogsms.com/api/v1/sms_messages", [
                "api_token" => env('IPROG_API_TOKEN'),
                "phone_number" => $phoneNumbers->first(),
                "message" => $message,
                "sms_provider" => 2
            ]);
        } else {
            // Multiple officers → use bulk SMS endpoint
            $bulkList = $phoneNumbers->join(',');
            Http::post("https://www.iprogsms.com/api/v1/sms_messages/send_bulk", [
                "api_token" => env('IPROG_API_TOKEN'),
                "phone_number" => $bulkList,
                "message" => $message,
                "sms_provider" => 2
            ]);
        }

        return null;
    }

    public function show($id)
    {
        $report = \App\Models\Report::withTrashed()
            ->with(['violations', 'attachments'])
            ->find($id);

        if (!$report || $report->trashed()) {
            return redirect()->route('reports.index')->with('error', 'Report not found or has been deleted.');
        }

        return view('reports.show', compact('report'));
    }

    public function destroy($id)
    {
        $report = Report::findOrFail($id);

        foreach ($report->attachments as $attachment) {
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }
        }

        // Detach all related violations from pivot table
        $report->violations()->detach();

        // Soft delete
        $report->delete();

        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }

    public function edit($id)
    {
        $report = Report::with(['violations', 'attachments'])->find($id);

        if (!$report || $report->trashed()) {
            return redirect()->route('reports.index')->with('error', 'Cannot edit a deleted or non-existent report.');
        }

        // You'll need violations list for the select
        $violations = ViolationCategory::all();
        $regions = Region::orderBy('region_name', 'asc')->get();
        $provinces = Province::where('region_id', $report->region_id)->get();
        $cities = CitiesMunicipalities::where('province_id', $report->province_id)->get();
        $barangays = Barangay::where('city_municipality_id', $report->city_municipality_id)->get();

        return view('reports.edit', compact(
            'report',
            'violations',
            'regions',
            'provinces',
            'cities',
            'barangays'
        ));
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
            'evidence' => 'nullable|array',
            'evidence.*' => 'file|mimes:jpg,jpeg,png,mp4,mov,avi|max:10240',
            'street' => 'nullable|string',
            'landmark' => 'nullable|string',
        ]);

        $report = Report::with('attachments')->findOrFail($id);

        if (!$report || $report->trashed()) {
            return redirect()->route('reports.index')->with('error', 'Cannot update a deleted or non-existent report.');
        }

        $report->update([
            'description' => $request->description,
            'incident_date' => $request->incident_date,
            'region_id' => $request->region_id,
            'province_id' => $request->province_id,
            'city_municipality_id' => $request->city_municipality_id,
            'barangay_id' => $request->barangay_id,
            'street' => $request->street,
            'landmark' => $request->landmark
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

        $status = $this->sendSmsToOfficers($report->id, $request->city_municipality_id);

        return redirect()->route('reports.index')
            ->with('success', 'Report updated successfully.')
            ->with('warning', $status);
    }
}
