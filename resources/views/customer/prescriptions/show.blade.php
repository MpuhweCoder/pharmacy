@extends('layouts.app')

@section('title', 'Prescription Details')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            <a href="{{ route('prescriptions.index') }}" class="btn btn-outline-secondary mb-3">
                <i class="bi bi-chevron-left me-1"></i>Back to Prescriptions
            </a>
            
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Prescription Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Upload Date:</strong>
                        <p>{{ $prescription->created_at->format('M d, Y H:i') }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Status:</strong>
                        <p>
                            @if($prescription->status === 'pending')
                                <span class="badge bg-warning">Pending Review</span>
                            @elseif($prescription->status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($prescription->status === 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </p>
                    </div>

                    @if($prescription->notes)
                        <div class="mb-3">
                            <strong>Notes:</strong>
                            <p>{{ $prescription->notes }}</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <strong>File:</strong>
                        <p>
                            <a href="#" class="btn btn-sm btn-primary">
                                <i class="bi bi-download me-1"></i>Download File
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm bg-light">
                <div class="card-header">
                    <h6 class="card-title mb-0">File Preview</h6>
                </div>
                <div class="card-body text-center" style="min-height: 300px;">
                    <i class="bi bi-file-earmark-pdf fs-1 text-danger mb-2"></i>
                    <p class="text-muted small">Prescription file preview not available</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
