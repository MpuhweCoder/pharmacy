@extends('layouts.app')
@section('title', 'Add Medicine')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h2 fw-bold text-dark">
                            <i class="bi bi-plus-circle me-2 text-success"></i> Add New Medicine
                        </h1>
                        <p class="text-muted mb-0">Add a new medicine to inventory</p>
                    </div>
                    <a href="{{ route('admin.medicines.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.medicines.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Medicine Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-capsule me-1 text-danger"></i> Medicine Name
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                class="form-control form-control-lg @error('name') is-invalid @enderror"
                                placeholder="e.g., Paracetamol 500mg"
                                value="{{ old('name') }}"
                                required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Generic Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-pill me-1 text-info"></i> Generic Name
                            </label>
                            <input 
                                type="text" 
                                name="generic_name" 
                                class="form-control @error('generic_name') is-invalid @enderror"
                                placeholder="e.g., Paracetamol"
                                value="{{ old('generic_name') }}"
                                required>
                            @error('generic_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Category -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-tags me-1 text-info"></i> Category
                                </label>
                                <select name="category_id" class="form-select form-select-lg @error('category_id') is-invalid @enderror" required>
                                    <option value="">Select Category</option>
                                    <option value="1">Pain Relief</option>
                                    <option value="2">Antibiotics</option>
                                    <option value="3">Vitamins</option>
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Strength -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-bar-chart me-1 text-warning"></i> Strength
                                </label>
                                <input 
                                    type="text" 
                                    name="strength" 
                                    class="form-control @error('strength') is-invalid @enderror"
                                    placeholder="e.g., 500mg, 250ml"
                                    value="{{ old('strength') }}"
                                    required>
                                @error('strength')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-file-text me-1 text-primary"></i> Description
                            </label>
                            <textarea 
                                name="description" 
                                class="form-control @error('description') is-invalid @enderror"
                                rows="3"
                                placeholder="Describe the medicine, uses, and side effects..."
                                required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Price -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-currency-dollar me-1 text-success"></i> Price (Rs.)
                                </label>
                                <input 
                                    type="number" 
                                    name="price" 
                                    class="form-control @error('price') is-invalid @enderror"
                                    placeholder="0.00"
                                    step="0.01"
                                    value="{{ old('price') }}"
                                    required>
                                @error('price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Stock -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-box-seam me-1 text-warning"></i> Stock Quantity
                                </label>
                                <input 
                                    type="number" 
                                    name="stock" 
                                    class="form-control @error('stock') is-invalid @enderror"
                                    placeholder="0"
                                    value="{{ old('stock') }}"
                                    required>
                                @error('stock')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Expiry Date -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-calendar-event me-1 text-danger"></i> Expiry Date
                                </label>
                                <input 
                                    type="date" 
                                    name="expiry_date" 
                                    class="form-control @error('expiry_date') is-invalid @enderror"
                                    value="{{ old('expiry_date') }}"
                                    required>
                                @error('expiry_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Medicine Image -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-image me-1 text-warning"></i> Medicine Image
                            </label>
                            <div class="card bg-light border-2 border-dashed">
                                <div class="card-body text-center py-4">
                                    <input 
                                        type="file" 
                                        name="image" 
                                        id="medicineImage"
                                        class="form-control d-none"
                                        accept="image/*">
                                    <label for="medicineImage" class="cursor-pointer">
                                        <i class="bi bi-cloud-upload" style="font-size: 2rem; color: #6c757d;"></i>
                                        <p class="mb-0 mt-2 text-muted">
                                            Click to upload image
                                        </p>
                                        <small class="text-muted">PNG, JPG, GIF (Max 2MB)</small>
                                    </label>
                                    <div id="imagePreview" class="mt-3"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Manufacturer -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-building me-1 text-primary"></i> Manufacturer
                                </label>
                                <input 
                                    type="text" 
                                    name="manufacturer" 
                                    class="form-control @error('manufacturer') is-invalid @enderror"
                                    placeholder="e.g., Panadol Inc."
                                    value="{{ old('manufacturer') }}"
                                    required>
                                @error('manufacturer')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Requires Prescription -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-file-medical me-1 text-danger"></i> Requires Prescription
                                </label>
                                <div class="form-check form-switch">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="requires_prescription" 
                                        id="prescriptionRequired"
                                        value="1">
                                    <label class="form-check-label" for="prescriptionRequired">
                                        This medicine requires a doctor's prescription
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-toggle-on me-1 text-success"></i> Status
                            </label>
                            <div class="form-check form-switch">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="status" 
                                    id="medicineStatus"
                                    value="1"
                                    checked>
                                <label class="form-check-label" for="medicineStatus">
                                    Active (available for purchase)
                                </label>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2 pt-3">
                            <button type="submit" class="btn btn-success btn-lg flex-grow-1">
                                <i class="bi bi-check-circle me-1"></i> Add Medicine
                            </button>
                            <a href="{{ route('admin.medicines.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-x-circle me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Help -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-lightbulb text-warning me-2"></i> Tips
                    </h5>
                </div>
                <div class="card-body small">
                    <div class="mb-3">
                        <strong>Medicine Naming</strong>
                        <p class="mb-0 text-muted mt-1">Include brand name and strength (e.g., Aspirin 500mg)</p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <strong>Generic Name</strong>
                        <p class="mb-0 text-muted mt-1">Scientific/chemical name (e.g., Acetylsalicylic acid)</p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <strong>Pricing</strong>
                        <p class="mb-0 text-muted mt-1">Include packaging cost and ensure competitive pricing</p>
                    </div>
                    <hr>
                    <div>
                        <strong>Image Quality</strong>
                        <p class="mb-0 text-muted mt-1">Use clear, professional product images with white background</p>
                    </div>
                </div>
            </div>

            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Stock Management</strong>
                <p class="mb-0 mt-2 small">Update stock levels regularly. System will alert when stock falls below 20 units.</p>
            </div>
        </div>
    </div>
</div>

<script>
// Image preview
document.getElementById('medicineImage')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" style="max-width: 200px; max-height: 200px; border-radius: 8px;">`;
        };
        reader.readAsDataURL(file);
    }
});

// Drag and drop
const dropZone = document.querySelector('.border-dashed');
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone?.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    dropZone?.addEventListener(eventName, () => dropZone.classList.add('bg-primary', 'bg-opacity-10'), false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone?.addEventListener(eventName, () => dropZone.classList.remove('bg-primary', 'bg-opacity-10'), false);
});

dropZone?.addEventListener('drop', (e) => {
    const dt = e.dataTransfer;
    const files = dt.files;
    document.getElementById('medicineImage').files = files;
    document.getElementById('medicineImage').dispatchEvent(new Event('change'));
}, false);
</script>
@endsection

                        {{-- Left Column: Main Info --}}
                        <div class="col-md-8">

                            {{-- Basic Information --}}
                            <div class="card mb-4">
                                <div class="card-header fw-semibold bg-light">
                                    <i class="bi bi-info-circle me-2"></i>Basic Information
                                </div>
                                <div class="card-body">

                                    <div class="row g-3">

                                        {{-- Medicine Name --}}
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">
                                                Medicine Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="name"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   value="{{ old('name') }}"
                                                   placeholder="e.g. Paracetamol 500mg">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Category --}}
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">
                                                Category <span class="text-danger">*</span>
                                            </label>
                                            <select name="category_id"
                                                    class="form-select @error('category_id') is-invalid @enderror">
                                                <option value="">Select Category</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Brand --}}
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Brand Name</label>
                                            <input type="text" name="brand"
                                                   class="form-control @error('brand') is-invalid @enderror"
                                                   value="{{ old('brand') }}"
                                                   placeholder="e.g. Crocin">
                                            @error('brand')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Generic Name --}}
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Generic Name</label>
                                            <input type="text" name="generic_name"
                                                   class="form-control"
                                                   value="{{ old('generic_name') }}"
                                                   placeholder="e.g. Acetaminophen">
                                        </div>

                                        {{-- Form --}}
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Medicine Form</label>
                                            <select name="form" class="form-select">
                                                <option value="">Select Form</option>
                                                @foreach(['tablet','capsule','syrup','injection','cream','drops','other'] as $f)
                                                    <option value="{{ $f }}"
                                                        {{ old('form') === $f ? 'selected' : '' }}>
                                                        {{ ucfirst($f) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Dosage --}}
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Dosage</label>
                                            <input type="text" name="dosage"
                                                   class="form-control"
                                                   value="{{ old('dosage') }}"
                                                   placeholder="e.g. 500mg">
                                        </div>

                                        {{-- Expiry Date --}}
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Expiry Date</label>
                                            <input type="date" name="expiry_date"
                                                   class="form-control @error('expiry_date') is-invalid @enderror"
                                                   value="{{ old('expiry_date') }}"
                                                   min="{{ date('Y-m-d') }}">
                                            @error('expiry_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Description --}}
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Description</label>
                                            <textarea name="description" rows="3"
                                                      class="form-control"
                                                      placeholder="Brief description of this medicine...">{{ old('description') }}</textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- Pricing & Stock --}}
                            <div class="card">
                                <div class="card-header fw-semibold bg-light">
                                    <i class="bi bi-currency-rupee me-2"></i>Pricing & Stock
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">

                                        {{-- Selling Price --}}
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">
                                                Selling Price (₹) <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" name="price" step="0.01" min="0"
                                                   class="form-control @error('price') is-invalid @enderror"
                                                   value="{{ old('price') }}"
                                                   placeholder="0.00">
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Cost Price --}}
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Cost Price (₹)</label>
                                            <input type="number" name="cost_price" step="0.01" min="0"
                                                   class="form-control"
                                                   value="{{ old('cost_price') }}"
                                                   placeholder="0.00">
                                        </div>

                                        {{-- Discount --}}
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Discount (%)</label>
                                            <input type="number" name="discount" step="0.01" min="0" max="100"
                                                   class="form-control"
                                                   value="{{ old('discount', 0) }}"
                                                   placeholder="0">
                                        </div>

                                        {{-- Stock --}}
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">
                                                Stock Quantity <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" name="stock" min="0"
                                                   class="form-control @error('stock') is-invalid @enderror"
                                                   value="{{ old('stock', 0) }}">
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Min Stock Alert --}}
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Min Stock Alert</label>
                                            <input type="number" name="min_stock_alert" min="0"
                                                   class="form-control"
                                                   value="{{ old('min_stock_alert', 10) }}">
                                            <small class="text-muted">Alert when stock falls below this</small>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- Right Column: Image & Settings --}}
                        <div class="col-md-4">

                            {{-- Image Upload --}}
                            <div class="card mb-4">
                                <div class="card-header fw-semibold bg-light">
                                    <i class="bi bi-image me-2"></i>Medicine Image
                                </div>
                                <div class="card-body text-center">
                                    {{-- Image Preview --}}
                                    <img id="imagePreview"
                                         src="{{ asset('images/medicine-placeholder.png') }}"
                                         alt="Preview"
                                         class="img-fluid rounded mb-3 border"
                                         style="max-height:180px; object-fit:contain;">

                                    <input type="file" name="image" id="imageInput"
                                           class="form-control @error('image') is-invalid @enderror"
                                           accept="image/*"
                                           onchange="previewImage(this)">
                                    <small class="text-muted d-block mt-1">JPG, PNG, WEBP — Max 2MB</small>

                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Settings --}}
                            <div class="card">
                                <div class="card-header fw-semibold bg-light">
                                    <i class="bi bi-gear me-2"></i>Settings
                                </div>
                                <div class="card-body">

                                    {{-- Requires Prescription --}}
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox"
                                               name="requires_prescription"
                                               id="requires_prescription"
                                               value="1"
                                               {{ old('requires_prescription') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="requires_prescription">
                                            <i class="bi bi-file-earmark-medical text-danger me-1"></i>
                                            Requires Prescription
                                        </label>
                                    </div>

                                    {{-- Active Status --}}
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox"
                                               name="is_active"
                                               id="is_active"
                                               value="1"
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            <i class="bi bi-toggle-on text-success me-1"></i>
                                            Active (visible to customers)
                                        </label>
                                    </div>

                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-circle me-2"></i>Save Medicine
                                </button>
                                <a href="{{ route('admin.medicines.index') }}"
                                   class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Preview image before upload
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection