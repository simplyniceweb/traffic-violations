<?php

namespace App\Http\Controllers\Admin;

use App\Models\TrafficRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;

class RulesController extends Controller
{
    public function index()
    {
        $rules = TrafficRule::withTrashed()->get();

        return view('admin.rules.index', compact('rules'));
    }

    public function create()
    {
        return view('admin.rules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rule_name'   => 'required|string|max:255|unique:traffic_rules_list,rule_name',
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('traffic_rule_photos', 'public');
            $validated['photo'] = $photoPath;
        }

        TrafficRule::create($validated);

        return redirect()->route('admin.rules.index')
                        ->with('success', 'Traffic rule created successfully.');
    }

    public function show($id)
    {
        $trafficRule = TrafficRule::findOrFail($id);
        return view('admin.rules.show', compact('trafficRule'));
    }

    public function edit($id)
    {
        $trafficRule = TrafficRule::findOrFail($id);
        return view('admin.rules.edit', compact('trafficRule'));
    }

    public function update(Request $request, $id)
    {
        $trafficRule = TrafficRule::findOrFail($id);

        $validated = $request->validate([
            'rule_name'   => 'required|string|max:255|unique:traffic_rules_list,rule_name,' . $trafficRule->id,
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($trafficRule->photo && \Storage::disk('public')->exists($trafficRule->photo)) {
                Storage::disk('public')->delete($trafficRule->photo);
            }

            $validated['photo'] = $request->file('photo')->store('traffic_rule_photos', 'public');
        }

        $trafficRule->update($validated);

        return redirect()->route('admin.rules.index')->with('success', 'Traffic rule updated successfully.');
    }

    public function destroy($id)
    {
        $trafficRule = TrafficRule::findOrFail($id);
        $trafficRule->delete();

        return redirect()->route('admin.rules.index')->with('success', 'Traffic rule moved to trash.');
    }

    public function restore($id)
    {
        $rule = TrafficRule::withTrashed()->findOrFail($id);
        $rule->restore();

        return redirect()->route('admin.rules.index')->with('success', 'Traffic rule restored successfully.');
    }
}
