<?php

namespace App\Http\Controllers\Admin;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegionController extends Controller
{
    public function index() {
        return view('admin.regions.index', ['regions' => Region::withTrashed()->get()]);
    }

    public function create() {
        return view('admin.regions.create');
    }

    public function show(Region $region) {
        return view('admin.regions.show', compact('region'));
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|unique:regions']);
        Region::create($request->all());
        return redirect()->route('regions.index');
    }

    public function edit(Region $region) {
        return view('admin.regions.edit', compact('region'));
    }

    public function update(Request $request, Region $region) {
        $request->validate([
            'region_name' => 'required|string|max:255',
            'psgc_code' => 'required|string|max:255',
            'region_code' => 'required|string|max:255',
        ]);

        $region->update([
            'region_name' => $request->region_name,
            'psgc_code' => $request->psgc_code,
            'region_code' => $request->region_code,
        ]);

        return redirect()->route('admin.regions.index')->with('success', 'Region updated successfully.');
    }

    public function destroy(Region $region) {
        $region->delete();
        return redirect()->route('admin.regions.index')->with('success', 'Region moved to trash.');
    }
    
    public function restore($id)
    {
        $region = Region::withTrashed()->findOrFail($id);
        $region->restore();

        return redirect()->route('admin.regions.index')->with('success', 'Region restored successfully.');
    }

}
