@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            {{-- Logo / Brand --}}
            <div class="text-center mb-4">
                <i class="bi bi-capsule-pill text-primary" style="font-size:3rem;"></i>
                <h3 class="fw-bold mt-2">MedPlus Pharmacy</h3>
                <p class="text-muted">Sign in to your account</p>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-envelope me-1"></i> Email Address
                            </label>
                            <input
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="you@example.com"
                                required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-lock me-1"></i> Password
                            </label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter password"
                                    required>
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword()">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Remember Me --}}
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <a href="#" class="text-decoration-none small">Forgot password?</a>
                        </div>

                        {{-- Submit --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Register Link --}}
            <p class="text-center mt-3 text-muted">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Register here</a>
            </p>

            {{-- Demo Credentials --}}
            <div class="card border-info mt-3">
                <div class="card-body p-3 small">
                    <p class="fw-bold text-info mb-2"><i class="bi bi-info-circle"></i> Demo Credentials</p>
                    <div class="row text-muted">
                        <div class="col-4"><strong>Admin</strong><br>admin@medplus.com</div>
                        <div class="col-4"><strong>Pharmacist</strong><br>pharmacist@medplus.com</div>
                        <div class="col-4"><strong>Customer</strong><br>customer@medplus.com</div>
                    </div>
                    <p class="mt-1 mb-0 text-muted">All passwords: <code>Admin@1234</code> / <code>Pharma@1234</code> / <code>Customer@1234</code></p>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePassword() {
    const pwd = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        pwd.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
@endpush
@endsection