@extends('layouts.app')
@section('title', 'My Orders')

@section('content')
<div class="container py-4">

    <h4 class="fw-bold mb-4">
        <i class="bi bi-bag me-2 text-primary"></i>My Orders
    </h4>

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-bag-x text-muted" style="font-size:4rem;"></i>
            <h6 class="mt-3 text-muted">No orders yet</h6>
            <a href="{{ url('/medicines') }}" class="btn btn-primary mt-2">
                Shop Now
            </a>
        </div>
    @else
        @foreach($orders as $order)
        <div class="card mb-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <span class="fw-bold text-primary">{{ $order->order_number }}</span>
                    <span class="text-muted ms-2 small">
                        {{ $order->created_at->format('d M Y, h:i A') }}
                    </span>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <span class="badge bg-{{ $order->status_badge }} fs-6">
                        {{ ucfirst($order->status) }}
                    </span>
                    <span class="badge bg-{{ $order->payment_badge }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        {{-- Show first 2 items --}}
                        @foreach($order->items->take(2) as $item)
                        <div class="d-flex align-items-center mb-1">
                            <i class="bi bi-capsule text-muted me-2"></i>
                            <span class="small">
                                {{ $item->medicine_name }}
                                <span class="text-muted">× {{ $item->quantity }}</span>
                            </span>
                        </div>
                        @endforeach
                        @if($order->items->count() > 2)
                            <small class="text-muted">
                                +{{ $order->items->count() - 2 }} more item(s)
                            </small>
                        @endif
                    </div>
                    <div class="col-md-3 text-md-center">
                        <div class="text-muted small">Total</div>
                        <div class="fw-bold fs-6">
                            ₹{{ number_format($order->total_amount, 2) }}
                        </div>
                        <small class="text-muted">{{ strtoupper($order->payment_method) }}</small>
                    </div>
                    <div class="col-md-2 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('orders.show', $order) }}"
                           class="btn btn-sm btn-outline-primary d-block mb-1">
                            View Details
                        </a>
                        @if($order->isCancellable())
                        <form action="{{ route('orders.cancel', $order) }}" method="POST"
                              onsubmit="return confirm('Cancel this order?')">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-outline-danger w-100">
                                Cancel
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="mt-3">{{ $orders->links() }}</div>
    @endif

</div>
@endsection