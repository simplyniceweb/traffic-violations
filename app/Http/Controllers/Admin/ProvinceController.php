<?php

namespace App\Http\Controllers\Admin;

use App\Models\Region;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProvinceController extends Controller
{
    public function index() {
        $provinces = Province::with('region')
            ->withTrashed()
            ->orderBy('province_name')->paginate(10);
        return view('admin.provinces.index', ['provinces' => $provinces]);
    }

    public function create()
    {
        $regions = Region::all();
        return view('admin.provinces.create', compact('regions'));
    }

    public function show(Province $province) {
        return view('admin.provinces.show', compact('province'));
    }

    public function edit(Province $province)
    {
        $regions = Region::all();
        return view('admin.provinces.edit', compact('province', 'regions'));
    }

    public function update(Request $request, Province $province)
    {
        $request->validate([
            'province_name' => 'required|string|max:255',
            'psgc_code' => 'nullable|string|max:255',
            'region_id' => 'nullable|exists:regions,id',
        ]);

        $province->update($request->only('province_name', 'psgc_code', 'region_id'));

        return redirect()->route('admin.provinces.index')->with('success', 'Province updated successfully.');
    }

    public function destroy(Province $province) {
        $province->delete();
        return redirect()->route('admin.provinces.index')->with('success', 'Province moved to trash.');
    }
    
    public function restore($id)
    {
        $province = Province::withTrashed()->findOrFail($id);
        $province->restore();

        return redirect()->route('admin.provinces.index')->with('success', 'Province restored successfully.');
    }
}
