@extends('layouts.app')
@section('title', 'Manage Orders')

@section('content')
<div class="container-fluid">
    <div class="row">

        @include('admin.partials.sidebar')

        <div class="col-md-10">
            <div class="main-content">

                <h4 class="fw-bold mb-4">
                    <i class="bi bi-bag me-2 text-primary"></i>Order Management
                </h4>

                {{-- Status Filter Badges --}}
                <div class="d-flex flex-wrap gap-2 mb-4">
                    @php
                        $statuses = [
                            'all'       => ['label' => 'All',        'color' => 'secondary'],
                            'pending'   => ['label' => 'Pending',    'color' => 'warning'],
                            'confirmed' => ['label' => 'Confirmed',  'color' => 'info'],
                            'shipped'   => ['label' => 'Shipped',    'color' => 'primary'],
                            'delivered' => ['label' => 'Delivered',  'color' => 'success'],
                            'cancelled' => ['label' => 'Cancelled',  'color' => 'danger'],
                        ];
                    @endphp

                    @foreach($statuses as $key => $meta)
                    <a href="{{ route('admin.orders.index', $key !== 'all' ? ['status' => $key] : []) }}"
                       class="btn btn-sm btn-{{ request('status') === $key || ($key === 'all' && !request('status')) ? $meta['color'] : 'outline-'.$meta['color'] }}">
                        {{ $meta['label'] }}
                        <span class="badge bg-white text-dark ms-1">{{ $stats[$key] }}</span>
                    </a>
                    @endforeach
                </div>

                {{-- Search Bar --}}
                <div class="card mb-4">
                    <div class="card-body py-2">
                        <form action="{{ route('admin.orders.index') }}" method="GET"
                              class="d-flex gap-2">
                            @if(request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                            <input type="text" name="search" class="form-control"
                                   placeholder="Search by order number, name or phone..."
                                   value="{{ request('search') }}">
                            <button class="btn btn-primary px-4">
                                <i class="bi bi-search"></i>
                            </button>
                            <a href="{{ route('admin.orders.index') }}"
                               class="btn btn-outline-secondary">
                                <i class="bi bi-x"></i>
                            </a>
                        </form>
                    </div>
                </div>

                {{-- Orders Table --}}
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr>
                                        <td>
                                            <span class="fw-bold text-primary small">
                                                {{ $order->order_number }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-semibold small">
                                                {{ $order->delivery_name }}
                                            </div>
                                            <small class="text-muted">
                                                {{ $order->delivery_phone }}
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ $order->items->count() }} item(s)
                                            </span>
                                        </td>
                                        <td class="fw-bold">
                                            ₹{{ number_format($order->total_amount, 2) }}
                                        </td>
                                        <td>
                                            <div class="small">
                                                {{ strtoupper($order->payment_method) }}
                                            </div>
                                            <span class="badge bg-{{ $order->payment_badge }} small">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $order->status_badge }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="small text-muted">
                                            {{ $order->created_at->format('d M Y') }}
                                            <br>
                                            {{ $order->created_at->format('h:i A') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            No orders found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            {{ $orders->total() }} total orders
                        </small>
                        {{ $orders->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection