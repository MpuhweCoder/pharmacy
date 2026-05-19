@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary mb-3">
                <i class="bi bi-chevron-left me-1"></i>Back to Orders
            </a>
            <h1>Order #{{ $order->id }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            {{-- Order Status --}}
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Order Status</h5>
                </div>
                <div class="card-body">
                    <p>
                        <strong>Status:</strong>
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
                    </p>
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                    @if($order->notes)
                        <p><strong>Notes:</strong> {{ $order->notes }}</p>
                    @endif
                </div>
            </div>

            {{-- Order Items --}}
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Order Items</h5>
                </div>
                <div class="card-body">
                    @if($order->items->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>{{ $item->medicine->name ?? 'N/A' }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>${{ number_format($item->price, 2) }}</td>
                                            <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No items in this order.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Order Summary --}}
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>${{ number_format($order->total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax:</span>
                        <span>$0.00</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong>${{ number_format($order->total, 2) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
