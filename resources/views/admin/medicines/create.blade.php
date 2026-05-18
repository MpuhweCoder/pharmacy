@extends('layouts.app')
@section('title', 'Add Medicine')

@section('content')
<div class="container-fluid">
    <div class="row">

        @include('admin.partials.sidebar')

        <div class="col-md-10">
            <div class="main-content">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-plus-circle me-2 text-primary"></i>Add New Medicine
                    </h4>
                    <a href="{{ route('admin.medicines.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                </div>

                <form action="{{ route('admin.medicines.store') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">

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