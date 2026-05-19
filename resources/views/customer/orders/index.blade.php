@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-3">
                <i class="bi bi-box-seam me-2"></i>
                My Orders
            </h1>
        </div>
    </div>

    @if($orders->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td>
                                @if($order->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($order->status === 'processing')
                                    <span class="badge bg-info">Processing</span>
                                @elseif($order->status === 'shipped')
                                    <span class="badge bg-primary">Shipped</span>
                                @elseif($order->status === 'delivered')
                                    <span class="badge bg-success">Delivered</span>
                                @elseif($order->status === 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i>View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <i class="bi bi-info-circle me-2"></i>
            No orders yet. <a href="{{ route('medicines.index') }}" class="alert-link">Start shopping</a>
        </div>
    @endif
</div>
@endsection
