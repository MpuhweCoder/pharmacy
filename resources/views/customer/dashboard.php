@extends('layouts.app')
@section('title', 'My Dashboard')

@section('content')
<div class="container py-4">

    {{-- Welcome Banner --}}
    <div class="card bg-primary text-white mb-4">
        <div class="card-body p-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-hand-wave me-2"></i>Hello, {{ $user->name }}!
                </h4>
                <p class="mb-0 opacity-75">Welcome to MedPlus. Order medicines, upload prescriptions and track orders.</p>
            </div>
            <i class="bi bi-capsule-pill opacity-25" style="font-size:5rem;"></i>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <a href="#" class="text-decoration-none">
                <div class="card text-center p-3 h-100">
                    <i class="bi bi-search text-primary mb-2" style="font-size:1.8rem;"></i>
                    <small class="fw-semibold">Search Medicines</small>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="#" class="text-decoration-none">
                <div class="card text-center p-3 h-100">
                    <i class="bi bi-cart text-success mb-2" style="font-size:1.8rem;"></i>
                    <small class="fw-semibold">My Cart</small>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="#" class="text-decoration-none">
                <div class="card text-center p-3 h-100">
                    <i class="bi bi-bag-check text-warning mb-2" style="font-size:1.8rem;"></i>
                    <small class="fw-semibold">My Orders</small>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="#" class="text-decoration-none">
                <div class="card text-center p-3 h-100">
                    <i class="bi bi-file-earmark-medical text-danger mb-2" style="font-size:1.8rem;"></i>
                    <small class="fw-semibold">Prescriptions</small>
                </div>
            </a>
        </div>
    </div>

    {{-- Account Info --}}
    <div class="card">
        <div class="card-header bg-light fw-semibold">
            <i class="bi bi-person-circle me-2"></i>My Profile
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Name:</strong> {{ $user->name }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Phone:</strong> {{ $user->phone ?? 'Not provided' }}</p>
                    <p class="mb-1">
                        <strong>Member since:</strong>
                        {{ $user->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection