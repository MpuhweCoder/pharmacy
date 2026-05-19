<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    /**
     * Display customer's prescriptions
     */
    public function index()
    {
        $user = auth()->user();
        
        $prescriptions = Prescription::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show the form for creating a new prescription
     */
    public function create()
    {
        return view('customer.prescriptions.create');
    }

    /**
     * Store a newly created prescription
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'prescription_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'notes' => 'nullable|string|max:500',
        ]);

        $user = auth()->user();
        
        $file = $request->file('prescription_file');
        $path = $file->store('prescriptions', 'private');

        Prescription::create([
            'user_id' => $user->id,
            'file_path' => $path,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('prescriptions.index')
                        ->with('success', 'Prescription uploaded successfully');
    }

    /**
     * Display a specific prescription
     */
    public function show(Prescription $prescription)
    {
        $this->authorize('view', $prescription);

        return view('customer.prescriptions.show', compact('prescription'));
    }
}
