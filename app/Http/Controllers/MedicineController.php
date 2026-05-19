<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Public medicine listing for customers
     */
    public function index(Request $request)
    {
        $query = Medicine::with('category')
                         ->active()
                         ->inStock();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        $medicines  = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::active()->withCount('medicines')->get();

        return view('medicines.index', compact('medicines', 'categories'));
    }

    /**
     * Single medicine detail page
     */
    public function show(Medicine $medicine)
    {
        $medicine->load('category');

        // Related medicines from same category
        $related = Medicine::where('category_id', $medicine->category_id)
                           ->where('id', '!=', $medicine->id)
                           ->active()
                           ->inStock()
                           ->take(4)
                           ->get();

        return view('medicines.show', compact('medicine', 'related'));
    }
}