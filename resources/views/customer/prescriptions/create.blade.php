@extends('layouts.app')

@section('title', 'Upload Prescription')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h4 class="card-title mb-0">
                        <i class="bi bi-file-earmark-arrow-up me-2"></i>
                        Upload Prescription
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('prescriptions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- File Upload --}}
                        <div class="mb-3">
                            <label for="prescription_file" class="form-label">
                                <strong>Prescription File</strong>
                                <span class="text-danger">*</span>
                            </label>
                            <div class="form-text mb-2">
                                Supported formats: PDF, JPG, JPEG, PNG (Max 5MB)
                            </div>
                            <input 
                                type="file" 
                                class="form-control @error('prescription_file') is-invalid @enderror" 
                                id="prescription_file" 
                                name="prescription_file"
                                accept=".pdf,.jpg,.jpeg,.png"
                                required
                            >
                            @error('prescription_file')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Notes --}}
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes (Optional)</label>
                            <textarea 
                                class="form-control @error('notes') is-invalid @enderror" 
                                id="notes" 
                                name="notes" 
                                rows="4"
                                placeholder="Any additional information about your prescription..."
                            ></textarea>
                            <small class="form-text text-muted">Max 500 characters</small>
                            @error('notes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
                            <a href="{{ route('prescriptions.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload me-1"></i>Upload Prescription
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
