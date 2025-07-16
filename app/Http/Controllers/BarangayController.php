<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use Illuminate\Http\Request;

class BarangayController extends Controller
{
    public function index() {
        $barangays = Barangay::with('cityMunicipality.province.region')
            ->orderBy('brgy_name')
            ->paginate(10);
        return view('barangays.index', ['barangays' => $barangays]);
    }
}
