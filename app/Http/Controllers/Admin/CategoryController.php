<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ViolationCategory;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = ViolationCategory::withTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function show(ViolationCategory $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:violation_categories,name',
            'type' => 'nullable|string',
        ]);

        ViolationCategory::create($request->only('name', 'type'));

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(ViolationCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, ViolationCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:violation_categories,name,' . $category->id,
            'type' => 'nullable|string',
        ]);

        $category->update($request->only('name', 'type'));

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(ViolationCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }

    public function restore($id)
    {
        $category = ViolationCategory::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('admin.categories.index')->with('success', 'Category restored successfully.');
    }
}
