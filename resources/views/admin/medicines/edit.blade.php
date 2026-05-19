@extends('layouts.app')
@section('title', 'Edit Medicine')

@section('content')
<div class="container-fluid">
    <div class="row">

        @include('admin.partials.sidebar')

        <div class="col-md-10">
            <div class="main-content">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-pencil me-2 text-warning"></i>Edit Medicine
                    </h4>
                    <a href="{{ route('admin.medicines.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                </div>

                <form action="{{ route('admin.medicines.update', $medicine) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        <div class="col-md-8">

                            <div class="card mb-4">
                                <div class="card-header fw-semibold bg-light">
                                    <i class="bi bi-info-circle me-2"></i>Basic Information
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Medicine Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   value="{{ old('name', $medicine->name) }}">
                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                                <option value="">Select Category</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        {{ old('category_id', $medicine->category_id) == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Brand Name</label>
                                            <input type="text" name="brand" class="form-control"
                                                   value="{{ old('brand', $medicine->brand) }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Generic Name</label>
                                            <input type="text" name="generic_name" class="form-control"
                                                   value="{{ old('generic_name', $medicine->generic_name) }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Form</label>
                                            <select name="form" class="form-select">
                                                <option value="">Select Form</option>
                                                @foreach(['tablet','capsule','syrup','injection','cream','drops','other'] as $f)
                                                    <option value="{{ $f }}"
                                                        {{ old('form', $medicine->form) === $f ? 'selected' : '' }}>
                                                        {{ ucfirst($f) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Dosage</label>
                                            <input type="text" name="dosage" class="form-control"
                                                   value="{{ old('dosage', $medicine->dosage) }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Expiry Date</label>
                                            <input type="date" name="expiry_date"
                                                   class="form-control @error('expiry_date') is-invalid @enderror"
                                                   value="{{ old('expiry_date', $medicine->expiry_date?->format('Y-m-d')) }}">
                                            @error('expiry_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Description</label>
                                            <textarea name="description" rows="3" class="form-control">{{ old('description', $medicine->description) }}</textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header fw-semibold bg-light">
                                    <i class="bi bi-currency-rupee me-2"></i>Pricing & Stock
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Selling Price (₹) *</label>
                                            <input type="number" name="price" step="0.01" min="0"
                                                   class="form-control @error('price') is-invalid @enderror"
                                                   value="{{ old('price', $medicine->price) }}">
                                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Cost Price (₹)</label>
                                            <input type="number" name="cost_price" step="0.01" min="0"
                                                   class="form-control"
                                                   value="{{ old('cost_price', $medicine->cost_price) }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Discount (%)</label>
                                            <input type="number" name="discount" step="0.01" min="0" max="100"
                                                   class="form-control"
                                                   value="{{ old('discount', $medicine->discount) }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Stock Quantity *</label>
                                            <input type="number" name="stock" min="0"
                                                   class="form-control @error('stock') is-invalid @enderror"
                                                   value="{{ old('stock', $medicine->stock) }}">
                                            @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Min Stock Alert</label>
                                            <input type="number" name="min_stock_alert" min="0"
                                                   class="form-control"
                                                   value="{{ old('min_stock_alert', $medicine->min_stock_alert) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="card mb-4">
                                <div class="card-header fw-semibold bg-light">
                                    <i class="bi bi-image me-2"></i>Medicine Image
                                </div>
                                <div class="card-body text-center">
                                    <img id="imagePreview"
                                         src="{{ $medicine->image_url }}"
                                         alt="Preview"
                                         class="img-fluid rounded mb-3 border"
                                         style="max-height:180px; object-fit:contain;">
                                    <input type="file" name="image" id="imageInput"
                                           class="form-control @error('image') is-invalid @enderror"
                                           accept="image/*"
                                           onchange="previewImage(this)">
                                    <small class="text-muted d-block mt-1">Leave blank to keep current image</small>
                                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header fw-semibold bg-light">
                                    <i class="bi bi-gear me-2"></i>Settings
                                </div>
                                <div class="card-body">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox"
                                               name="requires_prescription" value="1"
                                               id="requires_prescription"
                                               {{ old('requires_prescription', $medicine->requires_prescription) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="requires_prescription">
                                            Requires Prescription
                                        </label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox"
                                               name="is_active" value="1"
                                               id="is_active"
                                               {{ old('is_active', $medicine->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-warning btn-lg">
                                    <i class="bi bi-save me-2"></i>Update Medicine
                                </button>
                                <a href="{{ route('admin.medicines.index') }}" class="btn btn-outline-secondary">Cancel</a>
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
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('imagePreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection