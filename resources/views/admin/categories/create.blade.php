@extends('layouts.app')
@section('title', 'Add Category')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h2 fw-bold text-dark">
                            <i class="bi bi-plus-circle me-2 text-success"></i> Add New Category
                        </h1>
                        <p class="text-muted mb-0">Create a new medicine category</p>
                    </div>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Category Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-tag me-1 text-primary"></i> Category Name
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                class="form-control form-control-lg @error('name') is-invalid @enderror"
                                placeholder="e.g., Pain Relievers, Antibiotics, Vitamins"
                                value="{{ old('name') }}"
                                required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-1">
                                <i class="bi bi-info-circle me-1"></i> Enter a unique category name
                            </small>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-file-text me-1 text-info"></i> Description
                            </label>
                            <textarea 
                                name="description" 
                                class="form-control @error('description') is-invalid @enderror"
                                rows="4"
                                placeholder="Provide a detailed description of this category..."
                                required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-1">
                                <i class="bi bi-info-circle me-1"></i> Helpful description for customers
                            </small>
                        </div>

                        <!-- Category Icon/Image -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-image me-1 text-warning"></i> Category Image
                            </label>
                            <div class="card bg-light border-2 border-dashed">
                                <div class="card-body text-center py-4">
                                    <input 
                                        type="file" 
                                        name="image" 
                                        id="categoryImage"
                                        class="form-control d-none"
                                        accept="image/*">
                                    <label for="categoryImage" class="cursor-pointer">
                                        <i class="bi bi-cloud-upload" style="font-size: 2rem; color: #6c757d;"></i>
                                        <p class="mb-0 mt-2 text-muted">
                                            Click to upload image or drag and drop
                                        </p>
                                        <small class="text-muted">PNG, JPG, GIF (Max 2MB)</small>
                                    </label>
                                    <div id="imagePreview" class="mt-3"></div>
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
                                    id="categoryStatus"
                                    value="1"
                                    checked>
                                <label class="form-check-label" for="categoryStatus">
                                    Active (available for use)
                                </label>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2 pt-3">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                <i class="bi bi-check-circle me-1"></i> Create Category
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-lg">
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
                        <strong>Category Naming</strong>
                        <p class="mb-0 text-muted mt-1">Use clear, descriptive names like "Antibiotics" or "Pain Relief"</p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <strong>Description Guidelines</strong>
                        <p class="mb-0 text-muted mt-1">Include what type of medicines are in this category and their common uses</p>
                    </div>
                    <hr>
                    <div>
                        <strong>Image Requirements</strong>
                        <p class="mb-0 text-muted mt-1">Use high-quality pharmacy or medicine-related images for better visibility</p>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-list-check text-info me-2"></i> Popular Categories
                    </h5>
                </div>
                <div class="card-body small">
                    <ul class="list-unstyled">
                        <li class="py-2">
                            <i class="bi bi-capsule text-primary me-2"></i> <strong>Antibiotics</strong>
                        </li>
                        <li class="py-2 border-top">
                            <i class="bi bi-capsule text-danger me-2"></i> <strong>Pain Relievers</strong>
                        </li>
                        <li class="py-2 border-top">
                            <i class="bi bi-capsule text-warning me-2"></i> <strong>Vitamins & Supplements</strong>
                        </li>
                        <li class="py-2 border-top">
                            <i class="bi bi-capsule text-success me-2"></i> <strong>Digestive Health</strong>
                        </li>
                        <li class="py-2 border-top">
                            <i class="bi bi-capsule text-info me-2"></i> <strong>Cold & Flu</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Image preview
document.getElementById('categoryImage')?.addEventListener('change', function(e) {
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
    document.getElementById('categoryImage').files = files;
    document.getElementById('categoryImage').dispatchEvent(new Event('change'));
}, false);
</script>
@endsection
