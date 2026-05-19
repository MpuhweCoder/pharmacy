@extends('layouts.app')
@section('title', 'Order Details')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('orders.index') }}" class="text-muted text-decoration-none small">
                <i class="bi bi-arrow-left me-1"></i>My Orders
            </a>
            <h4 class="fw-bold mb-0 mt-1">
                Order {{ $order->order_number }}
            </h4>
        </div>
        @if($order->isCancellable())
        <form action="{{ route('orders.cancel', $order) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to cancel this order?')">
            @csrf @method('PATCH')
            <button class="btn btn-outline-danger btn-sm">
                <i class="bi bi-x-circle me-1"></i>Cancel Order
            </button>
        </form>
        @endif
    </div>

    {{-- Order Tracking Timeline --}}
    <div class="card mb-4">
        <div class="card-header bg-white fw-semibold">
            <i class="bi bi-geo-alt me-2"></i>Order Tracking
        </div>
        <div class="card-body py-4">
            @php
                $steps = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
                $currentIndex = array_search($order->status, $steps);
                if ($order->status === 'cancelled') $currentIndex = -1;
            @endphp

            @if($order->status === 'cancelled')
                <div class="text-center text-danger">
                    <i class="bi bi-x-circle-fill fs-3 mb-2"></i>
                    <div class="fw-bold">Order Cancelled</div>
                    @if($order->cancelled_at)
                        <small class="text-muted">
                            {{ $order->cancelled_at->format('d M Y, h:i A') }}
                        </small>
                    @endif
                </div>
            @else
                <div class="d-flex justify-content-between position-relative">
                    {{-- Progress Line --}}
                    <div class="position-absolute top-50 start-0 w-100 border-top border-2"
                         style="z-index:0; margin-top:-12px;"></div>

                    @foreach($steps as $i => $step)
                    @php
                        $isDone    = $i <= $currentIndex;
                        $isCurrent = $i === $currentIndex;
                    @endphp
                    <div class="text-center flex-fill position-relative" style="z-index:1;">
                        <div class="rounded-circle mx-auto d-flex align-items-center
                                    justify-content-center mb-2 fw-bold"
                             style="width:36px;height:36px;
                                    background:{{ $isDone ? '#198754' : '#dee2e6' }};
                                    color:{{ $isDone ? '#fff' : '#6c757d' }};
                                    border: 3px solid {{ $isCurrent ? '#0d6efd' : 'transparent' }}">
                            @if($isDone)
                                <i class="bi bi-check fs-6"></i>
                            @else
                                {{ $i + 1 }}
                            @endif
                        </div>
                        <div class="small fw-semibold {{ $isCurrent ? 'text-primary' : ($isDone ? 'text-success' : 'text-muted') }}">
                            {{ ucfirst($step) }}
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="row g-4">

        {{-- Order Items --}}
        <div class="col-md-7">
            <div class="card">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-bag me-2"></i>Items Ordered
                </div>
                <div class="card-body p-0">
                    @foreach($order->items as $item)
                    <div class="d-flex align-items-center p-3 border-bottom">
                        <img src="{{ $item->medicine->image_url ?? asset('images/medicine-placeholder.png') }}"
                             alt="{{ $item->medicine_name }}"
                             width="55" height="55"
                             class="rounded border me-3 object-fit-cover">
                        <div class="flex-fill">
                            <div class="fw-semibold">{{ $item->medicine_name }}</div>
                            <small class="text-muted">
                                {{ $item->medicine_brand ?? '' }}
                            </small>
                            <div class="small text-muted">
                                ₹{{ number_format($item->unit_price, 2) }} × {{ $item->quantity }}
                            </div>
                        </div>
                        <div class="fw-bold">
                            ₹{{ number_format($item->subtotal, 2) }}
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Subtotal</span>
                        <span>₹{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    @if($order->discount_amount > 0)
                    <div class="d-flex justify-content-between mb-1 text-success">
                        <span>Discount</span>
                        <span>- ₹{{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Delivery</span>
                        <span>
                            {{ $order->delivery_charge > 0
                                ? '₹'.number_format($order->delivery_charge, 2)
                                : 'FREE' }}
                        </span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span class="text-success">
                            ₹{{ number_format($order->total_amount, 2) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Delivery + Payment Info --}}
        <div class="col-md-5">

            {{-- Delivery Address --}}
            <div class="card mb-3">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-geo-alt me-2"></i>Delivery Address
                </div>
                <div class="card-body">
                    <p class="mb-0">
                        <strong>{{ $order->delivery_name }}</strong><br>
                        {{ $order->delivery_address }}<br>
                        {{ $order->delivery_city }},
                        {{ $order->delivery_state }} - {{ $order->delivery_pincode }}<br>
                        <i class="bi bi-telephone me-1 text-muted"></i>{{ $order->delivery_phone }}
                    </p>
                </div>
            </div>

            {{-- Payment Info --}}
            <div class="card">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-credit-card me-2"></i>Payment Info
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Method</span>
                        <span class="fw-semibold">
                            {{ strtoupper($order->payment_method) }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Status</span>
                        <span class="badge bg-{{ $order->payment_badge }} fs-6">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    @if($order->notes)
                    <hr>
                    <div class="small text-muted">
                        <strong>Note:</strong> {{ $order->notes }}
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>
@endsection