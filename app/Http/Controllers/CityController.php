<?php

namespace App\Http\Controllers;

use App\Models\CitiesMunicipalities;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index() {
        // $cities = CitiesMunicipalities::with('province')->orderBy('city_name')->paginate(10);
        $cities = CitiesMunicipalities::with(['province.region'])->paginate(10);
        return view('cities.index', ['cities' => $cities]);
    }

    public function create() {
        return view('cities.create');
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|unique:cities']);
        CitiesMunicipalities::create($request->all());
        return redirect()->route('cities.index');
    }

    public function edit(CitiesMunicipalities $region) {
        return view('cities.edit', compact('cities'));
    }

    public function update(Request $request, CitiesMunicipalities $city) {
        $request->validate(['name' => 'required|unique:cities,name,' . $city->id]);
        $city->update($request->all());
        return redirect()->route('cities.index');
    }

    public function destroy(CitiesMunicipalities $region) {
        $region->delete();
        return redirect()->route('cities.index');
    }
}
