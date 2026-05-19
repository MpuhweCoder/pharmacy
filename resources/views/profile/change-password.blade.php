@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-6 mx-auto">
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
                        <i class="bi bi-key me-2"></i>
                        Change Password
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.change-password.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        {{-- Current Password --}}
                        <div class="mb-3">
                            <label for="current_password" class="form-label">
                                <strong>Current Password</strong>
                                <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="password" 
                                class="form-control @error('current_password') is-invalid @enderror" 
                                id="current_password" 
                                name="current_password"
                                required
                            >
                            @error('current_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- New Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <strong>New Password</strong>
                                <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password"
                                required
                                minlength="8"
                            >
                            <small class="form-text text-muted">Minimum 8 characters</small>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm New Password --}}
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">
                                <strong>Confirm New Password</strong>
                                <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="password" 
                                class="form-control @error('password_confirmation') is-invalid @enderror" 
                                id="password_confirmation" 
                                name="password_confirmation"
                                required
                                minlength="8"
                            >
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Security Tips --}}
                        <div class="alert alert-info" role="alert">
                            <small>
                                <strong>Password Tips:</strong>
                                <ul class="mb-0">
                                    <li>Use a combination of uppercase and lowercase letters</li>
                                    <li>Include numbers and special characters</li>
                                    <li>Avoid using personal information</li>
                                </ul>
                            </small>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-end mt-4">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check me-1"></i>Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
