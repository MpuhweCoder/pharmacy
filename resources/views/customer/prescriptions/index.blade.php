@extends('layouts.app')

@section('title', 'My Prescriptions')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1>
                <i class="bi bi-file-earmark-text me-2"></i>
                My Prescriptions
            </h1>
            <a href="{{ route('prescriptions.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>Upload Prescription
            </a>
        </div>
    </div>

    @if($prescriptions->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Upload Date</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prescriptions as $prescription)
                        <tr>
                            <td>{{ $prescription->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($prescription->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($prescription->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($prescription->status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                @if($prescription->notes)
                                    <small>{{ Str::limit($prescription->notes, 50) }}</small>
                                @else
                                    <small class="text-muted">—</small>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('prescriptions.show', $prescription) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i>View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $prescriptions->links() }}
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <i class="bi bi-info-circle me-2"></i>
            No prescriptions uploaded yet. <a href="{{ route('prescriptions.create') }}" class="alert-link">Upload one now</a>
        </div>
    @endif
</div>
@endsection
