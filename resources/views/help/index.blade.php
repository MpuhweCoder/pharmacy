@extends('layouts.app')

@section('title', 'Help Center')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-2">
                <i class="bi bi-question-circle me-2"></i>
                Help Center
            </h1>
            <p class="text-muted">Find answers to common questions or contact our support team</p>
        </div>
    </div>

    {{-- Quick Contact Card --}}
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto">
            <div class="card bg-gradient border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white p-4 text-center">
                    <h5 class="mb-2">
                        <i class="bi bi-chat-left-dots fs-2 me-2"></i>
                        Need Help?
                    </h5>
                    <p class="mb-3">Can't find the answer you're looking for? Contact our support team.</p>
                    <a href="{{ route('help.contact') }}" class="btn btn-light">
                        <i class="bi bi-send me-1"></i>Contact Support
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- FAQs --}}
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h3 class="mb-4">
                <i class="bi bi-patch-question me-2"></i>
                Frequently Asked Questions
            </h3>

            <div class="accordion" id="faqAccordion">
                @foreach($faqs as $key => $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button 
                                class="accordion-button @if($key > 0) collapsed @endif" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#faq{{ $key }}"
                            >
                                <i class="bi bi-question-lg me-2 text-primary"></i>
                                {{ $faq['question'] }}
                            </button>
                        </h2>
                        <div 
                            id="faq{{ $key }}" 
                            class="accordion-collapse collapse @if($key === 0) show @endif" 
                            data-bs-parent="#faqAccordion"
                        >
                            <div class="accordion-body">
                                {{ $faq['answer'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Additional Support Options --}}
    <div class="row mt-5">
        <div class="col-lg-8 mx-auto">
            <h4 class="mb-4">Other Support Options</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-envelope fs-1 text-primary mb-3"></i>
                            <h5 class="card-title">Email Support</h5>
                            <p class="card-text text-muted small">
                                support@pharmacy.test
                            </p>
                            <p class="text-muted small">Response time: 24-48 hours</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-telephone fs-1 text-success mb-3"></i>
                            <h5 class="card-title">Phone Support</h5>
                            <p class="card-text text-muted small">
                                +1 (234) 567-890
                            </p>
                            <p class="text-muted small">Mon-Fri: 9 AM - 6 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
