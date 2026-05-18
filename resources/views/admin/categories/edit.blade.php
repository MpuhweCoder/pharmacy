@extends('layouts.app')
@section('title', 'Edit Category')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h2 fw-bold text-dark">
                            <i class="bi bi-pencil-square me-2 text-warning"></i> Edit Category
                        </h1>
                        <p class="text-muted mb-0">Update category information</p>
                    </div>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.categories.update', $category->id ?? '#') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

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
                                value="{{ old('name', $category->name ?? '') }}"
                                required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
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
                                required>{{ old('description', $category->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category Image -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-image me-1 text-warning"></i> Category Image
                            </label>
                            
                            @if(isset($category) && !empty($category->image))
                                <div class="mb-3">
                                    <small class="text-muted d-block mb-2">Current Image:</small>
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="Category" style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                                </div>
                            @endif

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
                                            Click to upload new image
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
                                    @if($category->status ?? true) checked @endif>
                                <label class="form-check-label" for="categoryStatus">
                                    Active (available for use)
                                </label>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2 pt-3">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                <i class="bi bi-check-circle me-1"></i> Save Changes
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-x-circle me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-info-circle text-info me-2"></i> Category Info
                    </h5>
                </div>
                <div class="card-body small">
                    <div class="mb-3">
                        <strong>Created:</strong>
                        <p class="mb-0 text-muted">{{ $category->created_at->format('d M Y, H:i') ?? 'N/A' }}</p>
                    </div>
                    <hr>
                    <div>
                        <strong>Last Updated:</strong>
                        <p class="mb-0 text-muted">{{ $category->updated_at->format('d M Y, H:i') ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm border-danger">
                <div class="card-header bg-danger bg-opacity-10 border-danger">
                    <h5 class="mb-0 fw-bold text-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i> Danger Zone
                    </h5>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">Delete this category permanently. This action cannot be undone.</p>
                    <button type="button" class="btn btn-danger btn-sm w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash me-1"></i> Delete Category
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-danger">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">
                    Are you sure you want to delete <strong>{{ $category->name ?? '' }}</strong>?
                </p>
                <p class="text-danger small mt-2 mb-0">
                    <i class="bi bi-exclamation-circle me-1"></i> This will remove all associated medicines!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('admin.categories.destroy', $category->id ?? '#') }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
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
