@extends('layouts.app')
@section('title', 'Manage Medicines')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 fw-bold text-dark">
                        <i class="bi bi-pill me-2 text-danger"></i> Medicine Inventory
                    </h1>
                    <p class="text-muted mb-0">Manage and monitor medicine stock</p>
                </div>
                <a href="{{ route('admin.medicines.create') }}" class="btn btn-success btn-lg">
                    <i class="bi bi-plus-circle me-2"></i> Add Medicine
                </a>
            </div>
        </div>
    </div>

    <!-- Page Header -->

    <!-- Alerts -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search & Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" class="row g-2">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Search medicines..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                <option value="antibiotics" @if(request('category') === 'antibiotics') selected @endif>Antibiotics</option>
                                <option value="pain-relief" @if(request('category') === 'pain-relief') selected @endif>Pain Relief</option>
                                <option value="vitamins" @if(request('category') === 'vitamins') selected @endif>Vitamins</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="stock_status" class="form-select">
                                <option value="">All Status</option>
                                <option value="in-stock" @if(request('stock_status') === 'in-stock') selected @endif>In Stock</option>
                                <option value="low" @if(request('stock_status') === 'low') selected @endif>Low Stock</option>
                                <option value="out" @if(request('stock_status') === 'out') selected @endif>Out of Stock</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="bi bi-search me-1"></i> Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted small mb-2">Total Medicines</p>
                    <h3 class="fw-bold text-primary mb-0">0</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted small mb-2">In Stock</p>
                    <h3 class="fw-bold text-success mb-0">0</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted small mb-2">Low Stock</p>
                    <h3 class="fw-bold text-warning mb-0">0</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted small mb-2">Out of Stock</p>
                    <h3 class="fw-bold text-danger mb-0">0</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Medicines Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">
                                    <input type="checkbox" class="form-check-input select-all" id="selectAll">
                                </th>
                                <th>Medicine Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($medicines ?? [] as $medicine)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input medicine-checkbox">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-danger bg-opacity-10 p-2 rounded me-2">
                                                <i class="bi bi-capsule text-danger"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">{{ $medicine->name ?? 'N/A' }}</h6>
                                                <small class="text-muted">{{ $medicine->generic_name ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $medicine->category ?? 'Uncategorized' }}</span>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 fw-bold">Rs. {{ number_format($medicine->price ?? 0, 2) }}</h6>
                                        <small class="text-muted">Per unit</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-bold">{{ $medicine->stock ?? 0 }}</span>
                                            <div class="progress" style="width: 80px; height: 6px;">
                                                @php
                                                    $stock = $medicine->stock ?? 0;
                                                    $percentage = min(($stock / 100) * 100, 100);
                                                    $barClass = $stock > 50 ? 'bg-success' : ($stock > 20 ? 'bg-warning' : 'bg-danger');
                                                @endphp
                                                <div class="progress-bar {{ $barClass }}" style="width: {{ $percentage }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $stock = $medicine->stock ?? 0;
                                        @endphp
                                        @if($stock > 50)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i> In Stock
                                            </span>
                                        @elseif($stock > 0)
                                            <span class="badge bg-warning">
                                                <i class="bi bi-exclamation-circle me-1"></i> Low Stock
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle me-1"></i> Out of Stock
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.medicines.edit', $medicine->id ?? '#') }}" class="btn btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-warning" title="Update Stock" data-bs-toggle="modal" data-bs-target="#stockModal{{ $medicine->id ?? '' }}">
                                                <i class="bi bi-box-seam"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $medicine->id ?? '' }}" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Stock Update Modal -->
                                <div class="modal fade" id="stockModal{{ $medicine->id ?? '' }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Update Stock - {{ $medicine->name ?? '' }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.medicines.stock', $medicine->id ?? '#') }}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Current Stock</label>
                                                        <input type="text" class="form-control" value="{{ $medicine->stock ?? 0 }}" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">New Stock</label>
                                                        <input type="number" name="stock" class="form-control" value="{{ $medicine->stock ?? 0 }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-warning">Update Stock</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $medicine->id ?? '' }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="mb-0">Are you sure you want to delete <strong>{{ $medicine->name ?? '' }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form method="POST" action="{{ route('admin.medicines.destroy', $medicine->id ?? '#') }}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                            <p class="mt-2 mb-0">No medicines found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if(isset($medicines) && method_exists($medicines, 'links'))
                <div class="mt-3">
                    {{ $medicines->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.select-all').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        document.querySelectorAll('.medicine-checkbox').forEach(cb => {
            cb.checked = this.checked;
        });
    });
});
</script>
@endsection