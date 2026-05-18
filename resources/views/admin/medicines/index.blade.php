@extends('layouts.app')
@section('title', 'Manage Medicines')

@section('content')
<div class="container-fluid">
    <div class="row">

        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Main Content --}}
        <div class="col-md-10">
            <div class="main-content">

                {{-- Page Header --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-0">
                            <i class="bi bi-capsule me-2 text-primary"></i>Medicine Management
                        </h4>
                        <small class="text-muted">Manage your pharmacy inventory</small>
                    </div>
                    <a href="{{ route('admin.medicines.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i> Add Medicine
                    </a>
                </div>

                {{-- Low Stock Alert --}}
                @if($lowStockCount > 0)
                <div class="alert alert-warning d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div>
                        <strong>Low Stock Alert!</strong>
                        {{ $lowStockCount }} medicine(s) are running low on stock.
                        <a href="{{ route('admin.medicines.index', ['stock_status' => 'low']) }}"
                           class="alert-link ms-2">View them →</a>
                    </div>
                </div>
                @endif

                {{-- Search & Filter Bar --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ route('admin.medicines.index') }}" method="GET">
                            <div class="row g-2">

                                {{-- Search --}}
                                <div class="col-md-4">
                                    <input
                                        type="text"
                                        name="search"
                                        class="form-control"
                                        placeholder="Search by name, brand..."
                                        value="{{ request('search') }}">
                                </div>

                                {{-- Category Filter --}}
                                <div class="col-md-2">
                                    <select name="category_id" class="form-select">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Stock Status Filter --}}
                                <div class="col-md-2">
                                    <select name="stock_status" class="form-select">
                                        <option value="">All Stock</option>
                                        <option value="low"     {{ request('stock_status') == 'low'     ? 'selected' : '' }}>Low Stock</option>
                                        <option value="out"     {{ request('stock_status') == 'out'     ? 'selected' : '' }}>Out of Stock</option>
                                        <option value="expired" {{ request('stock_status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                    </select>
                                </div>

                                {{-- Status Filter --}}
                                <div class="col-md-2">
                                    <select name="status" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="active"   {{ request('status') == 'active'   ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <div class="col-md-2 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary flex-fill">
                                        <i class="bi bi-search"></i> Filter
                                    </button>
                                    <a href="{{ route('admin.medicines.index') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                {{-- Medicines Table --}}
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="60">Image</th>
                                        <th>Medicine</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Expiry</th>
                                        <th>Status</th>
                                        <th width="150">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($medicines as $medicine)
                                    <tr class="{{ $medicine->isExpired() ? 'table-danger' : ($medicine->isLowStock() ? 'table-warning' : '') }}">

                                        {{-- Image --}}
                                        <td>
                                            <img src="{{ $medicine->image_url }}"
                                                 alt="{{ $medicine->name }}"
                                                 width="45" height="45"
                                                 class="rounded object-fit-cover border">
                                        </td>

                                        {{-- Name & Brand --}}
                                        <td>
                                            <div class="fw-semibold">{{ $medicine->name }}</div>
                                            <small class="text-muted">{{ $medicine->brand ?? '-' }}</small>
                                            @if($medicine->requires_prescription)
                                                <span class="badge bg-danger ms-1">Rx</span>
                                            @endif
                                        </td>

                                        {{-- Category --}}
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ $medicine->category->name }}
                                            </span>
                                        </td>

                                        {{-- Price --}}
                                        <td>
                                            <div class="fw-semibold">₹{{ number_format($medicine->final_price, 2) }}</div>
                                            @if($medicine->discount > 0)
                                                <small class="text-muted text-decoration-line-through">
                                                    ₹{{ number_format($medicine->price, 2) }}
                                                </small>
                                                <small class="text-success">{{ $medicine->discount }}% off</small>
                                            @endif
                                        </td>

                                        {{-- Stock --}}
                                        <td>
                                            @if($medicine->stock === 0)
                                                <span class="badge bg-danger">Out of Stock</span>
                                            @elseif($medicine->isLowStock())
                                                <span class="badge bg-warning text-dark">
                                                    Low: {{ $medicine->stock }}
                                                </span>
                                            @else
                                                <span class="badge bg-success">{{ $medicine->stock }}</span>
                                            @endif
                                        </td>

                                        {{-- Expiry --}}
                                        <td>
                                            @if($medicine->expiry_date)
                                                <span class="{{ $medicine->isExpired() ? 'text-danger fw-bold' : 'text-muted' }}">
                                                    {{ $medicine->expiry_date->format('M Y') }}
                                                    @if($medicine->isExpired())
                                                        <i class="bi bi-exclamation-circle"></i>
                                                    @endif
                                                </span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>

                                        {{-- Status --}}
                                        <td>
                                            @if($medicine->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>

                                        {{-- Actions --}}
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.medicines.show', $medicine) }}"
                                                   class="btn btn-sm btn-outline-info" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.medicines.edit', $medicine) }}"
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.medicines.destroy', $medicine) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Delete this medicine?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger" title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            No medicines found.
                                            <a href="{{ route('admin.medicines.create') }}">Add one now</a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Showing {{ $medicines->firstItem() }} to {{ $medicines->lastItem() }}
                            of {{ $medicines->total() }} medicines
                        </small>
                        {{ $medicines->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection