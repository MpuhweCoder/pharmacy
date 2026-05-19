@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">

        {{-- Sidebar --}}
        <div class="col-md-2 px-0">
            <div class="sidebar">
                <div class="text-center text-white py-3 border-bottom border-secondary mb-2">
                    <i class="bi bi-shield-check text-warning" style="font-size:1.5rem;"></i>
                    <p class="mb-0 small mt-1">Admin Panel</p>
                </div>
                <nav class="nav flex-column">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link active">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.users') }}" class="nav-link">
                        <i class="bi bi-people"></i> Users
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-capsule"></i> Medicines
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-bag"></i> Orders
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-file-earmark-medical"></i> Prescriptions
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-bar-chart"></i> Reports
                    </a>
                    <hr class="border-secondary mx-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="nav-link text-danger border-0 bg-transparent w-100 text-start">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </nav>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-md-10">
            <div class="main-content">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-0">Admin Dashboard</h4>
                        <small class="text-muted">Welcome back, {{ auth()->user()->name }}</small>
                    </div>
                    <span class="text-muted small">{{ now()->format('D, d M Y') }}</span>
                </div>

                {{-- Stat Cards --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="stat-card bg-primary">
                            <div class="stat-number">{{ $stats['total_users'] }}</div>
                            <div class="stat-label"><i class="bi bi-people me-1"></i> Total Users</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card bg-success">
                            <div class="stat-number">{{ $stats['total_customers'] }}</div>
                            <div class="stat-label"><i class="bi bi-person me-1"></i> Customers</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card bg-warning text-dark">
                            <div class="stat-number">{{ $stats['total_pharmacists'] }}</div>
                            <div class="stat-label"><i class="bi bi-person-badge me-1"></i> Pharmacists</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card bg-info">
                            <div class="stat-number">0</div>
                            <div class="stat-label"><i class="bi bi-bag me-1"></i> Orders Today</div>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-people text-primary" style="font-size:2rem;"></i>
                                <h6 class="mt-2 fw-bold">Manage Users</h6>
                                <p class="text-muted small">View, activate or deactivate user accounts</p>
                                <a href="{{ route('admin.users') }}" class="btn btn-primary btn-sm">
                                    View Users
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-capsule text-success" style="font-size:2rem;"></i>
                                <h6 class="mt-2 fw-bold">Medicines</h6>
                                <p class="text-muted small">Add, edit and manage medicine inventory</p>
                                <a href="#" class="btn btn-success btn-sm">Manage Medicines</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-graph-up text-info" style="font-size:2rem;"></i>
                                <h6 class="mt-2 fw-bold">Reports</h6>
                                <p class="text-muted small">View sales, orders and inventory reports</p>
                                <a href="#" class="btn btn-info btn-sm text-white">View Reports</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection