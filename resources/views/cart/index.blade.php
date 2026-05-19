@extends('layouts.app')
@section('title', 'My Cart')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-cart3 me-2 text-primary"></i>
            My Cart
            @if($cart->total_items > 0)
                <span class="badge bg-primary ms-1">{{ $cart->total_items }}</span>
            @endif
        </h4>
        <a href="{{ url('/medicines') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Continue Shopping
        </a>
    </div>

    @if($cart->items->isEmpty())
        {{-- Empty Cart State --}}
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="bi bi-cart-x text-muted" style="font-size:5rem;"></i>
            </div>
            <h5 class="text-muted fw-semibold">Your cart is empty</h5>
            <p class="text-muted">Browse our medicines and add items to your cart.</p>
            <a href="{{ url('/medicines') }}" class="btn btn-primary mt-2">
                <i class="bi bi-search me-2"></i>Browse Medicines
            </a>
        </div>

    @else
        <div class="row g-4">

            {{-- Left: Cart Items --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">
                            <i class="bi bi-bag me-2"></i>
                            {{ $cart->items->count() }} Item(s) in Cart
                        </span>
                        {{-- Clear Cart Button --}}
                        <form action="{{ route('cart.clear') }}" method="POST"
                              onsubmit="return confirm('Clear entire cart?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash me-1"></i> Clear Cart
                            </button>
                        </form>
                    </div>

                    <div class="card-body p-0">
                        @foreach($cart->items as $item)
                        <div class="cart-item p-3 border-bottom" id="cart-item-{{ $item->id }}">
                            <div class="row align-items-center">

                                {{-- Medicine Image --}}
                                <div class="col-2 col-md-1">
                                    <img src="{{ $item->medicine->image_url }}"
                                         alt="{{ $item->medicine->name }}"
                                         class="img-fluid rounded border"
                                         style="width:55px; height:55px; object-fit:cover;">
                                </div>

                                {{-- Medicine Info --}}
                                <div class="col-10 col-md-5">
                                    <h6 class="mb-0 fw-semibold">{{ $item->medicine->name }}</h6>
                                    <small class="text-muted">{{ $item->medicine->brand ?? '' }}</small>

                                    <div class="mt-1">
                                        {{-- Prescription badge --}}
                                        @if($item->medicine->requires_prescription)
                                            <span class="badge bg-danger me-1">
                                                <i class="bi bi-file-earmark-medical me-1"></i>Rx Required
                                            </span>
                                        @endif

                                        {{-- Category badge --}}
                                        <span class="badge bg-secondary">
                                            {{ $item->medicine->category->name }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Price --}}
                                <div class="col-md-2 mt-2 mt-md-0 text-center">
                                    <div class="fw-semibold text-primary">
                                        ₹{{ number_format($item->unit_price, 2) }}
                                    </div>
                                    @if($item->discount > 0)
                                        <small class="text-muted text-decoration-line-through">
                                            ₹{{ number_format($item->price, 2) }}
                                        </small>
                                        <small class="text-success d-block">
                                            {{ $item->discount }}% off
                                        </small>
                                    @endif
                                </div>

                                {{-- Quantity Controls --}}
                                <div class="col-md-2 mt-2 mt-md-0">
                                    <form action="{{ route('cart.update', $item) }}"
                                          method="POST"
                                          class="quantity-form">
                                        @csrf @method('PATCH')
                                        <div class="input-group input-group-sm">
                                            {{-- Minus Button --}}
                                            <button type="button"
                                                    class="btn btn-outline-secondary qty-btn"
                                                    data-action="decrease"
                                                    data-target="qty-{{ $item->id }}">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            {{-- Quantity Input --}}
                                            <input type="number"
                                                   name="quantity"
                                                   id="qty-{{ $item->id }}"
                                                   class="form-control text-center qty-input"
                                                   value="{{ $item->quantity }}"
                                                   min="1"
                                                   max="{{ $item->medicine->stock }}"
                                                   data-form="quantity-form-{{ $item->id }}">
                                            {{-- Plus Button --}}
                                            <button type="button"
                                                    class="btn btn-outline-secondary qty-btn"
                                                    data-action="increase"
                                                    data-target="qty-{{ $item->id }}"
                                                    data-max="{{ $item->medicine->stock }}">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted d-block text-center mt-1">
                                            Stock: {{ $item->medicine->stock }}
                                        </small>
                                    </form>
                                </div>

                                {{-- Subtotal + Remove --}}
                                <div class="col-md-2 mt-2 mt-md-0 text-end">
                                    <div class="fw-bold text-dark fs-6">
                                        ₹{{ number_format($item->subtotal, 2) }}
                                    </div>
                                    <form action="{{ route('cart.remove', $item) }}"
                                          method="POST"
                                          class="mt-1">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-link text-danger p-0"
                                                title="Remove item">
                                            <i class="bi bi-x-circle me-1"></i>Remove
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right: Order Summary --}}
            <div class="col-lg-4">

                {{-- Summary Card --}}
                <div class="card mb-3">
                    <div class="card-header bg-white fw-semibold">
                        <i class="bi bi-receipt me-2"></i>Order Summary
                    </div>
                    <div class="card-body">

                        {{-- Item wise summary --}}
                        @foreach($cart->items as $item)
                        <div class="d-flex justify-content-between mb-1 small">
                            <span class="text-muted text-truncate" style="max-width:60%">
                                {{ $item->medicine->name }} × {{ $item->quantity }}
                            </span>
                            <span>₹{{ number_format($item->subtotal, 2) }}</span>
                        </div>
                        @endforeach

                        <hr>

                        {{-- Subtotal --}}
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span>₹{{ number_format($cart->total_price, 2) }}</span>
                        </div>

                        {{-- Discount --}}
                        @if($cart->total_discount > 0)
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>Discount</span>
                            <span>- ₹{{ number_format($cart->total_discount, 2) }}</span>
                        </div>
                        @endif

                        {{-- Delivery --}}
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Delivery</span>
                            <span class="text-success fw-semibold">
                                @if($cart->final_amount >= 500)
                                    FREE
                                @else
                                    ₹40.00
                                @endif
                            </span>
                        </div>

                        <hr>

                        {{-- Total --}}
                        <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
                            <span>Total</span>
                            <span class="text-primary">
                                ₹{{ number_format($cart->final_amount + ($cart->final_amount >= 500 ? 0 : 40), 2) }}
                            </span>
                        </div>

                        {{-- Free delivery notice --}}
                        @if($cart->final_amount < 500)
                        <div class="alert alert-info py-2 small mb-3">
                            <i class="bi bi-truck me-1"></i>
                            Add ₹{{ number_format(500 - $cart->final_amount, 2) }} more for
                            <strong>FREE delivery!</strong>
                        </div>
                        @else
                        <div class="alert alert-success py-2 small mb-3">
                            <i class="bi bi-check-circle me-1"></i>
                            You qualify for <strong>FREE delivery!</strong>
                        </div>
                        @endif

                        {{-- Checkout Button --}}
                        @auth
                            <div class="d-grid">
                                <a href="{{ route('orders.checkout') }}"
                                   class="btn btn-success btn-lg">
                                    <i class="bi bi-lock me-2"></i>Proceed to Checkout
                                </a>
                            </div>
                        @else
                            <div class="d-grid gap-2">
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login to Checkout
                                </a>
                                <p class="text-center text-muted small mb-0">
                                    or
                                    <a href="{{ route('register') }}" class="text-decoration-none">
                                        create an account
                                    </a>
                                </p>
                            </div>
                        @endauth

                    </div>
                </div>

                {{-- Safety Notice --}}
                <div class="card border-0 bg-light">
                    <div class="card-body py-3">
                        <div class="d-flex gap-3 align-items-start mb-2">
                            <i class="bi bi-shield-check text-success fs-5"></i>
                            <div>
                                <div class="fw-semibold small">Safe & Secure Checkout</div>
                                <small class="text-muted">Your payment info is encrypted</small>
                            </div>
                        </div>
                        <div class="d-flex gap-3 align-items-start mb-2">
                            <i class="bi bi-arrow-counterclockwise text-info fs-5"></i>
                            <div>
                                <div class="fw-semibold small">Easy Returns</div>
                                <small class="text-muted">7-day return policy on eligible items</small>
                            </div>
                        </div>
                        <div class="d-flex gap-3 align-items-start">
                            <i class="bi bi-patch-check text-warning fs-5"></i>
                            <div>
                                <div class="fw-semibold small">100% Genuine Medicines</div>
                                <small class="text-muted">Sourced directly from manufacturers</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endif

</div>

@push('scripts')
<script>
// ─── Quantity +/- Buttons ──────────────────────────────────────────────────
document.querySelectorAll('.qty-btn').forEach(button => {
    button.addEventListener('click', function () {
        const action  = this.dataset.action;
        const inputId = this.dataset.target;
        const input   = document.getElementById(inputId);
        const max     = parseInt(this.dataset.max || 50);

        let value = parseInt(input.value);

        if (action === 'increase' && value < max) {
            value++;
        } else if (action === 'decrease' && value > 1) {
            value--;
        }

        input.value = value;

        // Auto-submit the quantity form
        input.closest('form').submit();
    });
});
</script>
@endpush
@endsection