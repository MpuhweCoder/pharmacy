@extends('layouts.app')

@section('title', 'Contact Support')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h4 class="card-title mb-0">
                        <i class="bi bi-chat-dots me-2"></i>
                        Contact Support
                    </h4>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4">
                        Have a question or need assistance? Please fill out the form below and our support team will get back to you shortly.
                    </p>

                    <form action="{{ route('help.submit') }}" method="POST">
                        @csrf

                        {{-- Category --}}
                        <div class="mb-3">
                            <label for="category" class="form-label">
                                <strong>Category</strong>
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="">-- Select a category --</option>
                                <option value="orders" {{ old('category') === 'orders' ? 'selected' : '' }}>Orders & Delivery</option>
                                <option value="prescriptions" {{ old('category') === 'prescriptions' ? 'selected' : '' }}>Prescriptions</option>
                                <option value="technical" {{ old('category') === 'technical' ? 'selected' : '' }}>Technical Issues</option>
                                <option value="payment" {{ old('category') === 'payment' ? 'selected' : '' }}>Payment Issues</option>
                                <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Subject --}}
                        <div class="mb-3">
                            <label for="subject" class="form-label">
                                <strong>Subject</strong>
                                <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('subject') is-invalid @enderror" 
                                id="subject" 
                                name="subject"
                                value="{{ old('subject') }}"
                                placeholder="Brief description of your issue"
                                required
                            >
                            @error('subject')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Message --}}
                        <div class="mb-3">
                            <label for="message" class="form-label">
                                <strong>Message</strong>
                                <span class="text-danger">*</span>
                            </label>
                            <textarea 
                                class="form-control @error('message') is-invalid @enderror" 
                                id="message" 
                                name="message"
                                rows="6"
                                placeholder="Please provide details about your issue..."
                                required
                            >{{ old('message') }}</textarea>
                            <small class="form-text text-muted">Max 5000 characters</small>
                            @error('message')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-end mt-4">
                            <a href="{{ route('help.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-1"></i>Send Message
                            </button>
                        </div>
                    </form>

                    {{-- Contact Info --}}
                    <hr class="my-4">
                    <div class="alert alert-info" role="alert">
                        <h6 class="alert-heading">
                            <i class="bi bi-info-circle me-2"></i>Other Ways to Reach Us
                        </h6>
                        <p class="mb-2">
                            <strong>Email:</strong> <a href="mailto:support@pharmacy.test">support@pharmacy.test</a>
                        </p>
                        <p class="mb-2">
                            <strong>Phone:</strong> <a href="tel:+1234567890">+1 (234) 567-890</a>
                        </p>
                        <p class="mb-0">
                            <strong>Hours:</strong> Monday - Friday, 9:00 AM - 6:00 PM
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('help.index') }}" class="text-decoration-none">
                    <i class="bi bi-chevron-left me-1"></i>Back to Help Center
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
