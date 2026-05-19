{{--
    Reusable Add to Cart button component.
    Usage: <x-add-to-cart :medicine="$medicine" />
--}}
<form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form d-inline">
    @csrf
    <input type="hidden" name="medicine_id" value="{{ $medicine->id }}">
    <input type="hidden" name="quantity" value="1">

    @if(!$medicine->is_active || $medicine->stock === 0)
        {{-- Out of stock state --}}
        <button type="button" class="btn btn-secondary btn-sm" disabled>
            <i class="bi bi-x-circle me-1"></i>Out of Stock
        </button>

    @elseif($medicine->requires_prescription && !auth()->check())
        {{-- Prescription required, not logged in --}}
        <a href="{{ route('login') }}" class="btn btn-warning btn-sm">
            <i class="bi bi-file-earmark-medical me-1"></i>Login to Buy
        </a>

    @else
        {{-- Normal add to cart --}}
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="bi bi-cart-plus me-1"></i>Add to Cart
        </button>
    @endif
</form>