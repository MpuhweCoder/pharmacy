@extends('layouts.app')
@section('title', 'Order Details')

@section('content')
<div class="container-fluid">
    <div class="row">

        @include('admin.partials.sidebar')

        <div class="col-md-10">
            <div class="main-content">

                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <a href="{{ route('admin.orders.index') }}"
                           class="text-muted text-decoration-none small">
                            <i class="bi bi-arrow-left me-1"></i> All Orders
                        </a>
                        <h4 class="fw-bold mb-0 mt-1">
                            Order {{ $order->order_number }}
                        </h4>
                    </div>
                    <span class="badge bg-{{ $order->status_badge }} fs-6 px-3 py-2">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="row g-4">

                    {{-- Left: Items + Timeline --}}
                    <div class="col-md-8">

                        {{-- Update Status --}}
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-primary text-white fw-semibold">
                                <i class="bi bi-arrow-repeat me-2"></i>Update Order Status
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.orders.status', $order) }}"
                                      method="POST"
                                      class="d-flex gap-3 align-items-end">
                                    @csrf @method('PATCH')
                                    <div class="flex-fill">
                                        <label class="form-label fw-semibold">New Status</label>
                                        <select name="status" class="form-select">
                                            @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $s)
                                            <option value="{{ $s }}"
                                                {{ $order->status === $s ? 'selected' : '' }}>
                                                {{ ucfirst($s) }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary"
                                            onclick="return confirm('Update order status?')">
                                        <i class="bi bi-check me-1"></i>Update
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Order Items --}}
                        <div class="card mb-4">
                            <div class="card-header bg-white fw-semibold">
                                <i class="bi bi-bag me-2"></i>
                                Items ({{ $order->items->count() }})
                            </div>
                            <div class="card-body p-0">
                                @foreach($order->items as $item)
                                <div class="d-flex align-items-center p-3 border-bottom">
                                    <img src="{{ $item->medicine->image_url ?? asset('images/medicine-placeholder.png') }}"
                                         alt="{{ $item->medicine_name }}"
                                         width="50" height="50"
                                         class="rounded border me-3 object-fit-cover">
                                    <div class="flex-fill">
                                        <div class="fw-semibold">{{ $item->medicine_name }}</div>
                                        <small class="text-muted">{{ $item->medicine_brand ?? '' }}</small>
                                    </div>
                                    <div class="text-center me-4">
                                        <div class="small text-muted">Qty</div>
                                        <div class="fw-bold">{{ $item->quantity }}</div>
                                    </div>
                                    <div class="text-center me-4">
                                        <div class="small text-muted">Unit Price</div>
                                        <div>₹{{ number_format($item->unit_price, 2) }}</div>
                                    </div>
                                    <div class="text-end">
                                        <div class="small text-muted">Subtotal</div>
                                        <div class="fw-bold">
                                            ₹{{ number_format($item->subtotal, 2) }}
                                        </div>
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

                    {{-- Right: Customer + Delivery + Payment --}}
                    <div class="col-md-4">

                        {{-- Customer Info --}}
                        <div class="card mb-3">
                            <div class="card-header bg-white fw-semibold">
                                <i class="bi bi-person me-2"></i>Customer
                            </div>
                            <div class="card-body">
                                <div class="fw-semibold">{{ $order->user->name }}</div>
                                <div class="text-muted small">{{ $order->user->email }}</div>
                                <div class="text-muted small">{{ $order->user->phone }}</div>
                            </div>
                        </div>

                        {{-- Delivery Address --}}
                        <div class="card mb-3">
                            <div class="card-header bg-white fw-semibold">
                                <i class="bi bi-geo-alt me-2"></i>Delivery Address
                            </div>
                            <div class="card-body small">
                                <strong>{{ $order->delivery_name }}</strong><br>
                                {{ $order->delivery_address }}<br>
                                {{ $order->delivery_city }},
                                {{ $order->delivery_state }} - {{ $order->delivery_pincode }}<br>
                                <i class="bi bi-telephone me-1"></i>{{ $order->delivery_phone }}
                            </div>
                        </div>

                        {{-- Payment Info --}}
                        <div class="card mb-3">
                            <div class="card-header bg-white fw-semibold">
                                <i class="bi bi-credit-card me-2"></i>Payment
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Method</span>
                                    <span class="fw-semibold">
                                        {{ strtoupper($order->payment_method) }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted small">Status</span>
                                    <span class="badge bg-{{ $order->payment_badge }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Order Timeline --}}
                        <div class="card">
                            <div class="card-header bg-white fw-semibold">
                                <i class="bi bi-clock-history me-2"></i>Timeline
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="bi bi-circle-fill text-warning me-2 small"></i>
                                        <strong>Placed:</strong>
                                        <span class="text-muted small">
                                            {{ $order->created_at->format('d M Y, h:i A') }}
                                        </span>
                                    </li>
                                    @if($order->confirmed_at)
                                    <li class="mb-2">
                                        <i class="bi bi-circle-fill text-info me-2 small"></i>
                                        <strong>Confirmed:</strong>
                                        <span class="text-muted small">
                                            {{ $order->confirmed_at->format('d M Y, h:i A') }}
                                        </span>
                                    </li>
                                    @endif
                                    @if($order->shipped_at)
                                    <li class="mb-2">
                                        <i class="bi bi-circle-fill text-primary me-2 small"></i>
                                        <strong>Shipped:</strong>
                                        <span class="text-muted small">
                                            {{ $order->shipped_at->format('d M Y, h:i A') }}
                                        </span>
                                    </li>
                                    @endif
                                    @if($order->delivered_at)
                                    <li class="mb-2">
                                        <i class="bi bi-circle-fill text-success me-2 small"></i>
                                        <strong>Delivered:</strong>
                                        <span class="text-muted small">
                                            {{ $order->delivered_at->format('d M Y, h:i A') }}
                                        </span>
                                    </li>
                                    @endif
                                    @if($order->cancelled_at)
                                    <li class="mb-2">
                                        <i class="bi bi-circle-fill text-danger me-2 small"></i>
                                        <strong>Cancelled:</strong>
                                        <span class="text-muted small">
                                            {{ $order->cancelled_at->format('d M Y, h:i A') }}
                                        </span>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection