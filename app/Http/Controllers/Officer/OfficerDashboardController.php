<?php

namespace App\Http\Controllers\Officer;

use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class OfficerDashboardController extends Controller
{
    public function index() {
        $violations_count = Report::count();

        $violations = Report::with('reporter', 'officer', 'category', 'barangay')
            ->where('city_municipality_id', Auth::user()->city_municipality_id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $reportCounts = Report::selectRaw("
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'under_review' THEN 1 ELSE 0 END) as under_review,
                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
                SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved
            ")
            ->where('city_municipality_id', Auth::user()->city_municipality_id)
            // ->where('user_id', Auth::id())
            ->first();

        return view('dashboard.officer', [
            'violations_count' => $violations_count,
            'violations' => $violations,
            'reportCounts' => $reportCounts
        ]);
    }

    public function startDuty(Request $request)
    {
        $officer = Auth::user();
        $officer->update([
            'on_duty' => true,
            'last_seen_at' => now(),
        ]);
        
        return back()->with('success', 'You are now on duty.');
    }

    public function endDuty(Request $request)
    {
        $officer = Auth::user();
        $officer->update([
            'on_duty' => false,
        ]);

        return back()->with('success', 'You are now off duty.');
    }

    public function heartbeat()
    {
        $officer = Auth::user();
        if ($officer->on_duty) {
            $officer->update(['last_seen_at' => now()]);
        }

        return response()->json(['status' => 'ok']);
    }
    
    public function ban(User $user, Request $request)
    {
        $request->validate([
            'ban_reason' => 'required|string|max:1000',
        ]);

        $user->update([
            'is_banned' => 1,
            'banned_reason' => $request->ban_reason,
        ]);

        return back()->with('status', 'User has been banned.');
    }

    public function unban(User $user)
    {
        $user->update([
            'is_banned' => 0,
            'banned_reason' => null,
        ]);

        return back()->with('status', 'User has been unbanned.');
    }
}
