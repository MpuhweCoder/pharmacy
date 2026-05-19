@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary btn-sm me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h4 class="fw-bold mb-0">
            <i class="bi bi-bag-check me-2 text-success"></i>Checkout
        </h4>
    </div>

    {{-- Checkout Steps Indicator --}}
    <div class="d-flex align-items-center mb-4 gap-2">
        <span class="badge bg-success rounded-pill px-3 py-2">
            <i class="bi bi-check me-1"></i>1. Cart
        </span>
        <div class="flex-fill border-top border-2"></div>
        <span class="badge bg-primary rounded-pill px-3 py-2">2. Delivery & Payment</span>
        <div class="flex-fill border-top"></div>
        <span class="badge bg-secondary rounded-pill px-3 py-2">3. Confirmation</span>
    </div>

    <form action="{{ route('orders.store') }}" method="POST" id="checkoutForm">
        @csrf

        <div class="row g-4">

            {{-- Left: Delivery + Payment --}}
            <div class="col-lg-7">

                {{-- Delivery Address --}}
                <div class="card mb-4">
                    <div class="card-header bg-white fw-semibold">
                        <i class="bi bi-geo-alt me-2 text-primary"></i>Delivery Address
                    </div>
                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="delivery_name"
                                       class="form-control @error('delivery_name') is-invalid @enderror"
                                       value="{{ old('delivery_name', $user->name) }}"
                                       placeholder="Full name">
                                @error('delivery_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Phone Number <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">+91</span>
                                    <input type="text" name="delivery_phone"
                                           class="form-control @error('delivery_phone') is-invalid @enderror"
                                           value="{{ old('delivery_phone', $user->phone) }}"
                                           placeholder="10-digit number"
                                           maxlength="10">
                                </div>
                                @error('delivery_phone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    Address <span class="text-danger">*</span>
                                </label>
                                <textarea name="delivery_address" rows="2"
                                          class="form-control @error('delivery_address') is-invalid @enderror"
                                          placeholder="House/Flat no., Street, Area">{{ old('delivery_address', $user->address) }}</textarea>
                                @error('delivery_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    City <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="delivery_city"
                                       class="form-control @error('delivery_city') is-invalid @enderror"
                                       value="{{ old('delivery_city') }}"
                                       placeholder="City">
                                @error('delivery_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    State <span class="text-danger">*</span>
                                </label>
                                <select name="delivery_state"
                                        class="form-select @error('delivery_state') is-invalid @enderror">
                                    <option value="">Select State</option>
                                    @foreach([
                                        'Andhra Pradesh','Assam','Bihar','Delhi','Goa',
                                        'Gujarat','Haryana','Karnataka','Kerala','Madhya Pradesh',
                                        'Maharashtra','Odisha','Punjab','Rajasthan','Tamil Nadu',
                                        'Telangana','Uttar Pradesh','West Bengal'
                                    ] as $state)
                                        <option value="{{ $state }}"
                                            {{ old('delivery_state') === $state ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('delivery_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    Pincode <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="delivery_pincode"
                                       class="form-control @error('delivery_pincode') is-invalid @enderror"
                                       value="{{ old('delivery_pincode') }}"
                                       placeholder="6-digit pincode"
                                       maxlength="6">
                                @error('delivery_pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Order Notes (Optional)</label>
                                <textarea name="notes" rows="2" class="form-control"
                                          placeholder="Any special instructions for delivery...">{{ old('notes') }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="card">
                    <div class="card-header bg-white fw-semibold">
                        <i class="bi bi-credit-card me-2 text-primary"></i>Payment Method
                    </div>
                    <div class="card-body">
                        <div class="row g-3">

                            {{-- Cash on Delivery --}}
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="payment_method"
                                       id="cod" value="cod" checked>
                                <label class="btn btn-outline-secondary w-100 p-3 text-start"
                                       for="cod">
                                    <i class="bi bi-cash-coin fs-4 d-block text-success mb-1"></i>
                                    <span class="fw-semibold">Cash on Delivery</span><br>
                                    <small class="text-muted">Pay when delivered</small>
                                </label>
                            </div>

                            {{-- Razorpay --}}
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="payment_method"
                                       id="razorpay" value="razorpay">
                                <label class="btn btn-outline-secondary w-100 p-3 text-start"
                                       for="razorpay">
                                    <i class="bi bi-credit-card fs-4 d-block text-primary mb-1"></i>
                                    <span class="fw-semibold">Razorpay</span><br>
                                    <small class="text-muted">Card / Net Banking</small>
                                </label>
                            </div>

                            {{-- UPI --}}
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="payment_method"
                                       id="upi" value="upi">
                                <label class="btn btn-outline-secondary w-100 p-3 text-start"
                                       for="upi">
                                    <i class="bi bi-phone fs-4 d-block text-warning mb-1"></i>
                                    <span class="fw-semibold">UPI</span><br>
                                    <small class="text-muted">GPay / PhonePe</small>
                                </label>
                            </div>

                        </div>

                        @error('payment_method')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            {{-- Right: Order Summary --}}
            <div class="col-lg-5">
                <div class="card sticky-top" style="top:80px;">
                    <div class="card-header bg-white fw-semibold">
                        <i class="bi bi-receipt me-2"></i>Order Summary
                    </div>
                    <div class="card-body">

                        {{-- Items --}}
                        @foreach($cart->items as $item)
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                            <img src="{{ $item->medicine->image_url }}"
                                 alt="{{ $item->medicine->name }}"
                                 width="45" height="45"
                                 class="rounded border object-fit-cover me-3">
                            <div class="flex-fill">
                                <div class="fw-semibold small">{{ $item->medicine->name }}</div>
                                <small class="text-muted">Qty: {{ $item->quantity }}</small>
                            </div>
                            <div class="fw-semibold">
                                ₹{{ number_format($item->subtotal, 2) }}
                            </div>
                        </div>
                        @endforeach

                        {{-- Pricing breakdown --}}
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Subtotal</span>
                            <span>₹{{ number_format($cart->total_price, 2) }}</span>
                        </div>

                        @if($cart->total_discount > 0)
                        <div class="d-flex justify-content-between mb-1 text-success">
                            <span>Discount</span>
                            <span>- ₹{{ number_format($cart->total_discount, 2) }}</span>
                        </div>
                        @endif

                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Delivery</span>
                            <span class="{{ $cart->final_amount >= 500 ? 'text-success fw-semibold' : '' }}">
                                {{ $cart->final_amount >= 500 ? 'FREE' : '₹40.00' }}
                            </span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                            <span>Total</span>
                            <span class="text-primary">
                                ₹{{ number_format($cart->final_amount + ($cart->final_amount >= 500 ? 0 : 40), 2) }}
                            </span>
                        </div>

                        {{-- Place Order Button --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg"
                                    id="placeOrderBtn">
                                <i class="bi bi-bag-check me-2"></i>Place Order
                            </button>
                        </div>

                        <p class="text-center text-muted small mt-2 mb-0">
                            <i class="bi bi-shield-lock me-1"></i>
                            Safe & Secure Checkout
                        </p>

                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

@push('scripts')
<script>
// Prevent double-submit
document.getElementById('checkoutForm').addEventListener('submit', function () {
    const btn = document.getElementById('placeOrderBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Placing Order...';
});
</script>
@endpush
@endsection