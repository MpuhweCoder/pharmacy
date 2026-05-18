<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MedPlus Pharmacy - @yield('title', 'Online Medicine Store')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body { background-color: #f8f9fa; }

        .navbar-brand { font-weight: 700; font-size: 1.4rem; }
        .navbar-brand span { color: #0d6efd; }

        .sidebar {
            min-height: 100vh;
            background: #212529;
            padding-top: 1rem;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            margin: 2px 8px;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #0d6efd;
            color: #fff;
        }
        .sidebar .nav-link i { margin-right: 8px; }

        .main-content { padding: 2rem; }

        .card { border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 12px; }
        .card-header { border-radius: 12px 12px 0 0 !important; }

        .stat-card { border-radius: 12px; padding: 1.5rem; color: #fff; }
        .stat-card .stat-number { font-size: 2rem; font-weight: 700; }
        .stat-card .stat-label  { font-size: 0.9rem; opacity: 0.85; }

        .alert { border-radius: 10px; }
    </style>

    @stack('styles')
</head>
<body>

{{-- Top Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="{{ route('home') }}">
        <i class="bi bi-capsule-pill"></i> Med<span>Plus</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center gap-2">
            @auth
                <li class="nav-item">
                    <span class="text-secondary small">
                        <i class="bi bi-person-circle"></i>
                        {{ auth()->user()->name }}
                        <span class="badge bg-primary ms-1">{{ ucfirst(auth()->user()->role) }}</span>
                    </span>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </li>
            @else
                <li class="nav-item">
                    <a class="btn btn-sm btn-outline-light me-1" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-sm btn-primary" href="{{ route('register') }}">Register</a>
                </li>
            @endauth
        </ul>
    </div>
</nav>

{{-- Flash Messages --}}
<div class="container-fluid px-4 mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

{{-- Page Content --}}
@yield('content')

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>