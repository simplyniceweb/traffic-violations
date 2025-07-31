<?php

namespace App\Http\Controllers\Admin;

use App\Models\Province;
use Illuminate\Http\Request;
use App\Models\CitiesMunicipalities;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function index() {
        $cities = CitiesMunicipalities::with(['province.region'])
            ->withTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);
        return view('admin.cities.index', ['cities' => $cities]);
    }

    public function show(CitiesMunicipalities $city) {
        return view('admin.cities.show', compact('city'));
    }

    public function create() {
        $provinces = Province::all();
        return view('admin.cities.create', compact('provinces'));
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|unique:cities']);
        CitiesMunicipalities::create($request->all());
        return redirect()->route('cities.index');
    }

    public function edit(CitiesMunicipalities $city)
    {
        $provinces = Province::all();
        return view('admin.cities.edit', compact('city', 'provinces'));
    }

    public function update(Request $request, CitiesMunicipalities $city)
    {
        $request->validate([
            'city_name' => 'required|string|max:255',
            'city_code' => 'required|string|max:255',
            'psgc_code' => 'nullable|string|max:255',
            'province_id' => 'nullable|exists:provinces,id',
        ]);

        $city->update($request->only('city_name', 'city_code', 'psgc_code', 'province_id'));

        return redirect()->route('admin.cities.index')->with('success', 'City/Municipality updated successfully.');
    }

    public function destroy(CitiesMunicipalities $city) {
        $city->delete();
        return redirect()->route('admin.cities.index')->with('success', 'City/Municipality moved to trash.');
    }
    
    public function restore($id)
    {
        $city = CitiesMunicipalities::withTrashed()->findOrFail($id);
        $city->restore();

        return redirect()->route('admin.cities.index')->with('success', 'City/Municipality restored successfully.');
    }
}
