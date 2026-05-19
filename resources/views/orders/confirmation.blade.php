@extends('layouts.app')
@section('title', 'Order Confirmed')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Success Banner --}}
            <div class="text-center mb-4">
                <div class="mb-3">
                    <i class="bi bi-check-circle-fill text-success"
                       style="font-size:5rem;"></i>
                </div>
                <h3 class="fw-bold text-success">Order Placed Successfully!</h3>
                <p class="text-muted fs-6">
                    Thank you for your order. We'll notify you when it ships.
                </p>
            </div>

            {{-- Order Info Card --}}
            <div class="card mb-4">
                <div class="card-body p-4">
                    <div class="row text-center g-3 mb-3">
                        <div class="col-md-3">
                            <div class="text-muted small">Order Number</div>
                            <div class="fw-bold text-primary">{{ $order->order_number }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-muted small">Date</div>
                            <div class="fw-bold">{{ $order->created_at->format('d M Y') }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-muted small">Status</div>
                            <span class="badge bg-{{ $order->status_badge }} fs-6">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="col-md-3">
                            <div class="text-muted small">Payment</div>
                            <div class="fw-bold">{{ strtoupper($order->payment_method) }}</div>
                        </div>
                    </div>

                    <hr>

                    {{-- Items --}}
                    <h6 class="fw-semibold mb-3">Items Ordered</h6>
                    @foreach($order->items as $item)
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                        <div>
                            <div class="fw-semibold">{{ $item->medicine_name }}</div>
                            <small class="text-muted">
                                {{ $item->medicine_brand ?? '' }} × {{ $item->quantity }}
                            </small>
                        </div>
                        <div class="fw-semibold">₹{{ number_format($item->subtotal, 2) }}</div>
                    </div>
                    @endforeach

                    {{-- Total --}}
                    <div class="d-flex justify-content-between mt-3">
                        <span class="text-muted">Delivery Charge</span>
                        <span>
                            {{ $order->delivery_charge > 0 ? '₹'.number_format($order->delivery_charge,2) : 'FREE' }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold fs-5 mt-2">
                        <span>Total Paid</span>
                        <span class="text-success">₹{{ number_format($order->total_amount, 2) }}</span>
                    </div>

                    <hr>

                    {{-- Delivery Address --}}
                    <h6 class="fw-semibold mb-2">Delivery To</h6>
                    <p class="mb-0">
                        <strong>{{ $order->delivery_name }}</strong><br>
                        {{ $order->delivery_address }},<br>
                        {{ $order->delivery_city }},
                        {{ $order->delivery_state }} - {{ $order->delivery_pincode }}<br>
                        <i class="bi bi-telephone me-1"></i> {{ $order->delivery_phone }}
                    </p>

                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('orders.show', $order) }}"
                   class="btn btn-primary">
                    <i class="bi bi-eye me-2"></i>Track Order
                </a>
                <a href="{{ url('/medicines') }}"
                   class="btn btn-outline-primary">
                    <i class="bi bi-capsule me-2"></i>Continue Shopping
                </a>
            </div>

        </div>
    </div>
</div>
@endsection