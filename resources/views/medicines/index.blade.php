@extends('layouts.app')
@section('title', 'Browse Medicines')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-capsule me-2 text-primary"></i>Browse Medicines
        </h4>
    </div>

    {{-- Category Filter Pills --}}
    <div class="mb-4">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('medicines.index') }}"
               class="btn btn-sm {{ !request('category') ? 'btn-primary' : 'btn-outline-primary' }}">
                All
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('medicines.index', ['category' => $cat->id]) }}"
                   class="btn btn-sm {{ request('category') == $cat->id ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi {{ $cat->icon }} me-1"></i>{{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Medicine Cards Grid --}}
    <div class="row g-3">
        @forelse($medicines as $medicine)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 medicine-card">

                {{-- Badge overlays --}}
                <div class="position-relative">
                    <img src="{{ $medicine->image_url }}"
                         alt="{{ $medicine->name }}"
                         class="card-img-top"
                         style="height:160px; object-fit:contain; padding:1rem; background:#f8f9fa;">

                    @if($medicine->discount > 0)
                        <span class="position-absolute top-0 end-0 badge bg-success m-2">
                            {{ $medicine->discount }}% OFF
                        </span>
                    @endif

                    @if($medicine->stock === 0)
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                             style="background:rgba(0,0,0,0.5); border-radius:0.375rem 0.375rem 0 0;">
                            <span class="badge bg-danger fs-6">Out of Stock</span>
                        </div>
                    @elseif($medicine->isLowStock())
                        <span class="position-absolute top-0 start-0 badge bg-warning text-dark m-2">
                            Only {{ $medicine->stock }} left
                        </span>
                    @endif
                </div>

                <div class="card-body d-flex flex-column p-3">
                    {{-- Category --}}
                    <span class="badge bg-secondary mb-1 align-self-start small">
                        {{ $medicine->category->name }}
                    </span>

                    {{-- Name --}}
                    <h6 class="card-title mb-1 fw-semibold" style="font-size:0.9rem;">
                        {{ $medicine->name }}
                    </h6>

                    {{-- Brand --}}
                    @if($medicine->brand)
                        <small class="text-muted mb-2">{{ $medicine->brand }}</small>
                    @endif

                    {{-- Prescription badge --}}
                    @if($medicine->requires_prescription)
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger mb-2 align-self-start"
                              style="font-size:0.7rem;">
                            <i class="bi bi-file-earmark-medical me-1"></i>Prescription Required
                        </span>
                    @endif

                    <div class="mt-auto">
                        {{-- Price --}}
                        <div class="mb-2">
                            <span class="fw-bold text-primary fs-6">
                                ₹{{ number_format($medicine->final_price, 2) }}
                            </span>
                            @if($medicine->discount > 0)
                                <small class="text-muted text-decoration-line-through ms-1">
                                    ₹{{ number_format($medicine->price, 2) }}
                                </small>
                            @endif
                        </div>

                        {{-- Add to Cart Button --}}
                        <x-add-to-cart :medicine="$medicine" />
                    </div>
                </div>

            </div>
        </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="bi bi-search fs-1 d-block mb-3"></i>
                <h6>No medicines found.</h6>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $medicines->links() }}
    </div>

</div>
@endsection