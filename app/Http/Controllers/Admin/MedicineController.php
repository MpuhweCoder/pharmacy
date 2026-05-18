<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMedicineRequest;
use App\Http\Requests\UpdateMedicineRequest;
use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicineController extends Controller
{
    /**
     * List all medicines with search and filter
     */
    public function index(Request $request)
    {
        $query = Medicine::with('category');

        // Search by name or brand
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('generic_name', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            match($request->stock_status) {
                'low'      => $query->lowStock(),
                'out'      => $query->where('stock', 0),
                'expired'  => $query->expired(),
                default    => null,
            };
        }

        // Filter by active status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $medicines  = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::active()->orderBy('name')->get();

        // Low stock count for alert badge
        $lowStockCount = Medicine::lowStock()->count();

        return view('admin.medicines.index', compact(
            'medicines', 'categories', 'lowStockCount'
        ));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.medicines.create', compact('categories'));
    }

    /**
     * Store a new medicine
     */
    public function store(StoreMedicineRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Store in storage/app/public/medicines/
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        // Handle checkboxes (unchecked = not in request)
        $data['requires_prescription'] = $request->boolean('requires_prescription');
        $data['is_active']             = $request->boolean('is_active', true);

        Medicine::create($data);

        return redirect()->route('admin.medicines.index')
                         ->with('success', 'Medicine added successfully.');
    }

    /**
     * Show medicine details
     */
    public function show(Medicine $medicine)
    {
        $medicine->load('category');
        return view('admin.medicines.show', compact('medicine'));
    }

    /**
     * Show edit form
     */
    public function edit(Medicine $medicine)
    {
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.medicines.edit', compact('medicine', 'categories'));
    }

    /**
     * Update medicine
     */
    public function update(UpdateMedicineRequest $request, Medicine $medicine)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($medicine->image) {
                Storage::disk('public')->delete($medicine->image);
            }
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        $data['requires_prescription'] = $request->boolean('requires_prescription');
        $data['is_active']             = $request->boolean('is_active', true);

        $medicine->update($data);

        return redirect()->route('admin.medicines.index')
                         ->with('success', 'Medicine updated successfully.');
    }

    /**
     * Soft delete medicine
     */
    public function destroy(Medicine $medicine)
    {
        // Soft delete - data stays in DB, just hidden
        $medicine->delete();

        return redirect()->route('admin.medicines.index')
                         ->with('success', 'Medicine removed successfully.');
    }

    /**
     * Update stock only (quick action)
     */
    public function updateStock(Request $request, Medicine $medicine)
    {
        $request->validate([
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $medicine->update(['stock' => $request->stock]);

        return back()->with('success', "Stock updated to {$request->stock} units.");
    }
}