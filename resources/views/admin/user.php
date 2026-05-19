@extends('layouts.app')
@section('title', 'Manage Users')

@section('content')
<div class="container-fluid">
    <div class="row">

        {{-- Sidebar (same as dashboard) --}}
        <div class="col-md-2 px-0">
            <div class="sidebar">
                <nav class="nav flex-column pt-3">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.users') }}" class="nav-link active">
                        <i class="bi bi-people"></i> Users
                    </a>
                </nav>
            </div>
        </div>

        {{-- Main --}}
        <div class="col-md-10">
            <div class="main-content">
                <h4 class="fw-bold mb-4">
                    <i class="bi bi-people me-2"></i>Manage Users
                </h4>

                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Joined</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone ?? '-' }}</td>
                                        <td>
                                            @php
                                                $badgeClass = match($user->role) {
                                                    'admin'      => 'bg-danger',
                                                    'pharmacist' => 'bg-warning text-dark',
                                                    default      => 'bg-primary',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($user->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td>
                                            {{-- Toggle active status --}}
                                            @if(auth()->id() !== $user->id)
                                            <form action="{{ route('admin.users.toggle', $user) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button
                                                    class="btn btn-sm {{ $user->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                                    onclick="return confirm('Are you sure?')">
                                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">No users found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $users->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection