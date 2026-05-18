@extends('layouts.app')
@section('title', 'Pharmacist Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">

        {{-- Sidebar --}}
        <div class="col-md-2 px-0">
            <div class="sidebar">
                <div class="text-center text-white py-3 border-bottom border-secondary mb-2">
                    <i class="bi bi-person-badge text-info" style="font-size:1.5rem;"></i>
                    <p class="mb-0 small mt-1">Pharmacist Panel</p>
                </div>
                <nav class="nav flex-column">
                    <a href="{{ route('pharmacist.dashboard') }}" class="nav-link active">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-capsule"></i> Medicines
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-file-earmark-medical"></i> Prescriptions
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-bag"></i> Orders
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
                <h4 class="fw-bold mb-1">Pharmacist Dashboard</h4>
                <p class="text-muted">Welcome, {{ auth()->user()->name }}. Manage medicines and prescriptions.</p>

                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <div class="stat-card bg-success">
                            <div class="stat-number">0</div>
                            <div class="stat-label"><i class="bi bi-capsule me-1"></i> Medicines in Stock</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card bg-warning text-dark">
                            <div class="stat-number">0</div>
                            <div class="stat-label"><i class="bi bi-exclamation-triangle me-1"></i> Low Stock Alert</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card bg-info">
                            <div class="stat-number">0</div>
                            <div class="stat-label"><i class="bi bi-file-earmark me-1"></i> Pending Prescriptions</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection