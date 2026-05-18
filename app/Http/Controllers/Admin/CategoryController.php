<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /** List all categories */
    public function index()
    {
        $categories = Category::withCount('medicines')
                               ->orderBy('name')
                               ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    /** Show create form */
    public function create()
    {
        return view('admin.categories.create');
    }

    /** Store new category */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:categories,name'],
            'description' => ['nullable', 'string'],
            'icon'        => ['nullable', 'string', 'max:50'],
            'is_active'   => ['boolean'],
        ]);

        Category::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'icon'        => $request->icon ?? 'bi-capsule',
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category created successfully.');
    }

    /** Show edit form */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /** Update category */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:100', "unique:categories,name,{$category->id}"],
            'description' => ['nullable', 'string'],
            'icon'        => ['nullable', 'string', 'max:50'],
            'is_active'   => ['boolean'],
        ]);

        $category->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'icon'        => $request->icon ?? 'bi-capsule',
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category updated successfully.');
    }

    /** Delete category */
    public function destroy(Category $category)
    {
        // Prevent deletion if category has medicines
        if ($category->medicines()->count() > 0) {
            return back()->with('error', 'Cannot delete category. It has medicines assigned to it.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category deleted successfully.');
    }
}