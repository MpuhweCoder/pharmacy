@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 fw-bold text-dark">
                        <i class="bi bi-speedometer2 me-2 text-primary"></i> Admin Dashboard
                    </h1>
                    <p class="text-muted mb-0">Welcome back, <strong>{{ auth()->user()->name }}</strong></p>
                </div>
                <div class="text-end">
                    <p class="text-muted mb-0">{{ now()->format('l, d F Y') }}</p>
                    <p class="small text-muted">{{ now()->format('H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row mb-4 g-3">
        <!-- Total Users -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                <div class="position-absolute top-0 end-0 p-3 opacity-10">
                    <i class="bi bi-people-fill" style="font-size: 4rem; color: #007bff;"></i>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-2">
                        <i class="bi bi-person-check me-1"></i> Total Users
                    </p>
                    <h3 class="fw-bold text-primary mb-0">{{ $stats['total_users'] ?? 0 }}</h3>
                    <p class="small text-success mt-2 mb-0">
                        <i class="bi bi-arrow-up-short"></i> Active users
                    </p>
                </div>
                <div class="card-footer bg-light border-0">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-primary">
                        Manage <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                <div class="position-absolute top-0 end-0 p-3 opacity-10">
                    <i class="bi bi-bag-check-fill" style="font-size: 4rem; color: #28a745;"></i>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-2">
                        <i class="bi bi-shop me-1"></i> Customers
                    </p>
                    <h3 class="fw-bold text-success mb-0">{{ $stats['total_customers'] ?? 0 }}</h3>
                    <p class="small text-info mt-2 mb-0">
                        <i class="bi bi-arrow-up-short"></i> This month
                    </p>
                </div>
                <div class="card-footer bg-light border-0">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-success">
                        View <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Pharmacists -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                <div class="position-absolute top-0 end-0 p-3 opacity-10">
                    <i class="bi bi-capsule-pill" style="font-size: 4rem; color: #dc3545;"></i>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-2">
                        <i class="bi bi-hospital me-1"></i> Pharmacists
                    </p>
                    <h3 class="fw-bold text-danger mb-0">{{ $stats['total_pharmacists'] ?? 0 }}</h3>
                    <p class="small text-warning mt-2 mb-0">
                        <i class="bi bi-check-circle me-1"></i> Verified
                    </p>
                </div>
                <div class="card-footer bg-light border-0">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-danger">
                        Manage <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Orders Today -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                <div class="position-absolute top-0 end-0 p-3 opacity-10">
                    <i class="bi bi-box-seam" style="font-size: 4rem; color: #ffc107;"></i>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-2">
                        <i class="bi bi-clock-history me-1"></i> Orders Today
                    </p>
                    <h3 class="fw-bold text-warning mb-0">{{ $stats['orders_today'] ?? 0 }}</h3>
                    <p class="small text-muted mt-2 mb-0">
                        <i class="bi bi-lightning me-1"></i> Real-time updates
                    </p>
                </div>
                <div class="card-footer bg-light border-0">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-warning">
                        View <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Overview -->
    <div class="row g-3">
        <!-- Quick Actions -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-lightning-charge text-warning me-2"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <!-- Manage Users -->
                        <div class="col-6 col-sm-4">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary w-100 py-3 rounded-3 d-flex flex-column align-items-center gap-2">
                                <i class="bi bi-person-lines-fill" style="font-size: 1.5rem;"></i>
                                <small class="fw-semibold">Manage Users</small>
                            </a>
                            <small class="d-block text-center text-muted mt-2">View, activate or deactivate</small>
                        </div>

                        <!-- Medicines -->
                        <div class="col-6 col-sm-4">
                            <a href="{{ route('admin.medicines.index') }}" class="btn btn-outline-success w-100 py-3 rounded-3 d-flex flex-column align-items-center gap-2">
                                <i class="bi bi-pill" style="font-size: 1.5rem;"></i>
                                <small class="fw-semibold">Medicines</small>
                            </a>
                            <small class="d-block text-center text-muted mt-2">Add, edit, manage inventory</small>
                        </div>

                        <!-- Categories -->
                        <div class="col-6 col-sm-4">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-info w-100 py-3 rounded-3 d-flex flex-column align-items-center gap-2">
                                <i class="bi bi-tags-fill" style="font-size: 1.5rem;"></i>
                                <small class="fw-semibold">Categories</small>
                            </a>
                            <small class="d-block text-center text-muted mt-2">Organize product types</small>
                        </div>

                        <!-- Orders -->
                        <div class="col-6 col-sm-4">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-danger w-100 py-3 rounded-3 d-flex flex-column align-items-center gap-2">
                                <i class="bi bi-cart-check-fill" style="font-size: 1.5rem;"></i>
                                <small class="fw-semibold">Orders</small>
                            </a>
                            <small class="d-block text-center text-muted mt-2">Manage transactions</small>
                        </div>

                        <!-- Reports -->
                        <div class="col-6 col-sm-4">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-warning w-100 py-3 rounded-3 d-flex flex-column align-items-center gap-2">
                                <i class="bi bi-bar-chart-line-fill" style="font-size: 1.5rem;"></i>
                                <small class="fw-semibold">Reports</small>
                            </a>
                            <small class="d-block text-center text-muted mt-2">View sales & analytics</small>
                        </div>

                        <!-- Settings -->
                        <div class="col-6 col-sm-4">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary w-100 py-3 rounded-3 d-flex flex-column align-items-center gap-2">
                                <i class="bi bi-gear-fill" style="font-size: 1.5rem;"></i>
                                <small class="fw-semibold">Settings</small>
                            </a>
                            <small class="d-block text-center text-muted mt-2">System configuration</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-clock-history text-info me-2"></i> Recent Activity
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 py-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="mb-1 fw-semibold">
                                        <span class="badge bg-success me-2">New Order</span>
                                        Order #12345 placed
                                    </p>
                                    <small class="text-muted">Customer: John Doe</small>
                                </div>
                                <small class="text-muted">2 mins ago</small>
                            </div>
                        </div>
                        <div class="list-group-item px-0 py-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="mb-1 fw-semibold">
                                        <span class="badge bg-info me-2">Stock Update</span>
                                        Paracetamol stock updated
                                    </p>
                                    <small class="text-muted">Updated by: Admin</small>
                                </div>
                                <small class="text-muted">15 mins ago</small>
                            </div>
                        </div>
                        <div class="list-group-item px-0 py-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="mb-1 fw-semibold">
                                        <span class="badge bg-warning me-2">New User</span>
                                        New pharmacist registered
                                    </p>
                                    <small class="text-muted">Dr. Sarah Johnson</small>
                                </div>
                                <small class="text-muted">1 hour ago</small>
                            </div>
                        </div>
                        <div class="list-group-item px-0 py-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="mb-1 fw-semibold">
                                        <span class="badge bg-danger me-2">Low Stock</span>
                                        Aspirin inventory low
                                    </p>
                                    <small class="text-muted">Only 5 units remaining</small>
                                </div>
                                <small class="text-muted">3 hours ago</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-server text-secondary me-2"></i> System Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Database</span>
                                <span class="badge bg-success">Online</span>
                            </div>
                            <div class="progress mt-2" style="height: 8px;">
                                <div class="progress-bar bg-success" style="width: 95%"></div>
                            </div>
                            <small class="text-muted">Response: 45ms</small>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">API Server</span>
                                <span class="badge bg-success">Online</span>
                            </div>
                            <div class="progress mt-2" style="height: 8px;">
                                <div class="progress-bar bg-success" style="width: 98%"></div>
                            </div>
                            <small class="text-muted">Uptime: 99.9%</small>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Storage</span>
                                <span class="badge bg-warning">72%</span>
                            </div>
                            <div class="progress mt-2" style="height: 8px;">
                                <div class="progress-bar bg-warning" style="width: 72%"></div>
                            </div>
                            <small class="text-muted">Available: 28%</small>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Security</span>
                                <span class="badge bg-success">Secure</span>
                            </div>
                            <div class="progress mt-2" style="height: 8px;">
                                <div class="progress-bar bg-success" style="width: 100%"></div>
                            </div>
                            <small class="text-muted">SSL Certificate Valid</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
    }
    .btn {
        transition: all 0.3s ease;
    }
    .btn:hover {
        transform: translateY(-2px);
    }
</style>
@endsection
