@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="container-fluid py-4">
    {{-- Welcome Banner --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white p-4">
                    <h1 class="mb-2">
                        <i class="bi bi-hand-thumbs-up me-2"></i>
                        Welcome, {{ $user->name }}!
                    </h1>
                    <p class="mb-0 fs-5">Welcome to MedPlus. Order medicines, upload prescriptions and track orders.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-3">
                <i class="bi bi-lightning-fill text-warning me-2"></i>
                Quick Actions
            </h4>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <a href="{{ route('medicines.index') }}" class="card h-100 text-decoration-none text-dark card-hover">
                <div class="card-body text-center">
                    <i class="bi bi-capsule fs-1 text-success mb-3"></i>
                    <h5 class="card-title">Search Medicines</h5>
                    <p class="card-text small text-muted">Find and order medicines</p>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <a href="{{ route('cart.index') }}" class="card h-100 text-decoration-none text-dark card-hover">
                <div class="card-body text-center">
                    <i class="bi bi-bag-check fs-1 text-primary mb-3"></i>
                    <h5 class="card-title">My Cart</h5>
                    <p class="card-text small text-muted">View your shopping cart</p>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <a href="{{ route('orders.index') }}" class="card h-100 text-decoration-none text-dark card-hover">
                <div class="card-body text-center">
                    <i class="bi bi-box-seam fs-1 text-info mb-3"></i>
                    <h5 class="card-title">My Orders</h5>
                    <p class="card-text small text-muted">Track your orders</p>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <a href="{{ route('prescriptions.index') }}" class="card h-100 text-decoration-none text-dark card-hover">
                <div class="card-body text-center">
                    <i class="bi bi-file-earmark-text fs-1 text-danger mb-3"></i>
                    <h5 class="card-title">Prescriptions</h5>
                    <p class="card-text small text-muted">Upload prescriptions</p>
                </div>
            </a>
        </div>
    </div>

    {{-- Main Content Row --}}
    <div class="row">
        {{-- Account Info --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>
                        Account Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small d-block mb-1">Full Name</label>
                            <p class="fs-5 fw-semibold">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small d-block mb-1">Email</label>
                            <p class="fs-5 fw-semibold">{{ $user->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small d-block mb-1">Phone Number</label>
                            <p class="fs-5 fw-semibold">{{ $user->phone ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small d-block mb-1">Member Since</label>
                            <p class="fs-5 fw-semibold">{{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Orders --}}
            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">
                        <i class="bi bi-clock-history me-2"></i>
                        Recent Orders
                    </h5>
                </div>
                <div class="card-body">
                    @if(isset($recent_orders) && count($recent_orders) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_orders as $order)
                                        <tr>
                                            <td><strong>#{{ $order->id }}</strong></td>
                                            <td>{{ $order->created_at->format('d M Y') }}</td>
                                            <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                                            <td>
                                                <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'info') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                            <p class="text-muted">No orders yet. <a href="{{ route('medicines.index') }}">Start shopping</a></p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- My Profile Card --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">
                        <i class="bi bi-gear me-2"></i>
                        Account Settings
                    </h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="bi bi-pencil me-2"></i>
                        Edit Profile
                    </a>
                    <a href="{{ route('profile.change-password') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-lock me-2"></i>
                        Change Password
                    </a>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">
                        <i class="bi bi-graph-up me-2"></i>
                        My Activity
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <span class="text-muted">Total Orders</span>
                        <strong class="fs-5">{{ $total_orders ?? 0 }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <span class="text-muted">Pending Orders</span>
                        <strong class="fs-5 text-warning">{{ $pending_orders ?? 0 }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Total Spent</span>
                        <strong class="fs-5 text-success">${{ number_format($total_spent ?? 0, 2) }}</strong>
                    </div>
                </div>
            </div>

            {{-- Help Section --}}
            <div class="card shadow-sm border-info">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">
                        <i class="bi bi-question-circle me-2 text-info"></i>
                        Need Help?
                    </h5>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">Have questions about your orders or prescriptions?</p>
                    <a href="{{ route('help.contact') }}" class="btn btn-sm btn-info w-100">
                        <i class="bi bi-chat-dots me-2"></i>
                        Contact Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-hover {
        transition: all 0.3s ease;
    }
    
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endsection
