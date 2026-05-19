@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h4 class="card-title mb-0">
                        <i class="bi bi-person me-2"></i>
                        Edit Profile
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        {{-- Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label"><strong>Full Name</strong></label>
                            <input 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $user->name) }}"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label"><strong>Email Address</strong></label>
                            <input 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email', $user->email) }}"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input 
                                type="tel" 
                                class="form-control @error('phone') is-invalid @enderror" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone', $user->phone) }}"
                            >
                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea 
                                class="form-control @error('address') is-invalid @enderror" 
                                id="address" 
                                name="address" 
                                rows="3"
                            >{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-end mt-4">
                            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check me-1"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Change Password Section --}}
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lock me-2"></i>
                        Security
                    </h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted">Manage your password and security settings.</p>
                    <a href="{{ route('profile.change-password') }}" class="btn btn-outline-warning">
                        <i class="bi bi-key me-1"></i>Change Password
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
