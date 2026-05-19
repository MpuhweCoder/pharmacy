<div class="col-md-2 px-0">
    <div class="sidebar">
        <div class="text-center text-white py-3 border-bottom border-secondary mb-2">
            <i class="bi bi-shield-check text-warning" style="font-size:1.5rem;"></i>
            <p class="mb-0 small mt-1">Admin Panel</p>
        </div>
        <nav class="nav flex-column">
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.users') }}"
               class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Users
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Categories
            </a>
            <a href="{{ route('admin.medicines.index') }}"
               class="nav-link {{ request()->routeIs('admin.medicines*') ? 'active' : '' }}">
                <i class="bi bi-capsule"></i> Medicines
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-bag"></i> Orders
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-file-earmark-medical"></i> Prescriptions
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