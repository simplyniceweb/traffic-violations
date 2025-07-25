<?php

namespace App\Http\Controllers\Admin;

use App\Models\Barangay;
use Illuminate\Http\Request;
use App\Models\CitiesMunicipalities;
use App\Http\Controllers\Controller;

class BarangayController extends Controller
{
    public function index() {
        $barangays = Barangay::with('cityMunicipality.province.region')
            ->withTrashed()
            ->orderBy('brgy_name')
            ->paginate(10);
        return view('admin.barangays.index', ['barangays' => $barangays]);
    }

    public function show(Barangay $barangay) {
        return view('admin.barangays.show', compact('barangay'));
    }

    public function create() {
        $cities = CitiesMunicipalities::all();
        return view('admin.barangays.create', compact('cities'));
    }

    public function store(Request $request) {
        $request->validate([
            'brgy_name' => 'required|string|max:255',
            'brgy_code' => 'required|string|max:255',
            'city_municipality_id' => 'required|exists:cities_municipalities,id',
        ]);

        Barangay::create($request->all());
        return redirect()->route('admin.barangays.index')->with('success', 'Barangay created successfully.');
    }

    public function edit(Barangay $barangay)
    {
        $cities = CitiesMunicipalities::all();
        return view('admin.barangays.edit', compact('barangay', 'cities'));
    }

    public function update(Request $request, Barangay $barangay)
    {
        $request->validate([
            'brgy_name' => 'required|string|max:255',
            'brgy_code' => 'required|string|max:255',
            'city_municipality_id' => 'required|exists:cities_municipalities,id',
        ]);

        $barangay->update([
            'brgy_name' => $request->brgy_name,
            'brgy_code' => $request->brgy_code,
            'city_municipality_id' => $request->city_municipality_id,
        ]);

        return redirect()->route('admin.barangays.index')->with('success', 'Barangay updated successfully.');
    }

    public function destroy(Barangay $barangay) {
        $barangay->delete();
        return redirect()->route('admin.barangays.index')->with('success', 'Barangay moved to trash.');
    }
    
    public function restore($id)
    {
        $barangay = Barangay::withTrashed()->findOrFail($id);
        $barangay->restore();

        return redirect()->route('admin.barangays.index')->with('success', 'Barangay restored successfully.');
    }
}
