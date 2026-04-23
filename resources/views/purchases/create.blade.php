@extends('layouts.app')

@section('title', 'Purchase — ' . $ebook->title)
@section('hide_newsletter', true)

@section('content')

{{-- Breadcrumb --}}
<div style="background:#f9fafb; border-bottom:1px solid #e5e7eb; padding:12px 0;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size:0.85rem;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ebooks.show', $ebook->slug) }}">{{ Str::limit($ebook->title, 30) }}</a></li>
                <li class="breadcrumb-item active">Purchase</li>
            </ol>
        </nav>
    </div>
</div>

<section style="padding:56px 0; background:#f9fafb; min-height:70vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">

                {{-- Ebook Summary Card --}}
                <div style="background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:24px; margin-bottom:24px;">
                    <div class="d-flex gap-4 align-items-center">
                        @if($ebook->cover_image)
                            <img src="{{ asset('storage/' . $ebook->cover_image) }}"
                                style="width:80px; height:100px; object-fit:cover; border-radius:10px; flex-shrink:0; box-shadow:0 4px 12px rgba(0,0,0,.12);"
                                alt="{{ $ebook->title }}">
                        @else
                            <div style="width:80px; height:100px; background:linear-gradient(135deg,#e0e7ff,#c7d2fe); border-radius:10px; flex-shrink:0; display:flex; align-items:center; justify-content:center;">
                                <i class="bi bi-book" style="font-size:1.8rem; color:#818cf8;"></i>
                            </div>
                        @endif
                        <div>
                            <span class="badge-cat d-inline-block mb-2">{{ $ebook->category }}</span>
                            <h5 style="font-family:'Playfair Display',serif; font-weight:700; color:#1a1a2e; margin-bottom:4px;">{{ $ebook->title }}</h5>
                            <p style="color:#6b7280; font-size:0.85rem; margin-bottom:8px;">by {{ $ebook->author }}</p>
                            <span class="price-tag">${{ number_format($ebook->price, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Pending payment warning --}}
                @if($existingPurchase)
                    <div style="background:#fffbeb; border:1px solid #fde68a; border-radius:12px; padding:16px 20px; margin-bottom:24px; font-size:0.88rem; color:#92400e;">
                        <i class="bi bi-clock-history me-2"></i>
                        <strong>You already have a pending payment</strong> for this ebook submitted on
                        {{ $existingPurchase->created_at->format('M d, Y') }}.
                        Please wait for admin approval or check your <a href="{{ route('library') }}" style="color:#f97316; font-weight:700;">library</a>.
                    </div>
                @endif

                {{-- Payment Instructions --}}
                <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-left:4px solid #22c55e; border-radius:12px; padding:24px; margin-bottom:24px;">
                    <h6 style="font-weight:700; color:#15803d; margin-bottom:14px; font-size:0.95rem;">
                        <i class="bi bi-bank me-2"></i>Payment Instructions
                    </h6>
                    <ol style="line-height:2.2; margin-bottom:0; color:#374151; font-size:0.88rem; padding-left:20px;">
                        <li>Transfer <strong style="color:#1a1a2e;">${{ number_format($ebook->price, 2) }}</strong> to our bank account</li>
                        <li>Bank: <strong>Example Bank</strong> &bull; Account: <strong>1234-5678-9000</strong></li>
                        <li>Account name: <strong>Ebook Store Inc.</strong></li>
                        <li>Take a screenshot or photo of the transfer receipt</li>
                        <li>Upload the proof below and submit your order</li>
                    </ol>
                </div>

                {{-- Upload Form --}}
                <div style="background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:32px;">
                    <h5 style="font-family:'Playfair Display',serif; font-weight:700; color:#1a1a2e; margin-bottom:24px;">
                        <i class="bi bi-upload me-2" style="color:#f97316;"></i>Upload Payment Proof
                    </h5>

                    <form action="{{ route('purchase.store', $ebook) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div style="margin-bottom:20px;">
                            <label for="payment_proof" style="font-weight:700; font-size:0.85rem; color:#374151; display:block; margin-bottom:8px;">
                                Payment Proof <span style="color:#ef4444;">*</span>
                            </label>
                            <input type="file" id="payment_proof" name="payment_proof"
                                accept=".jpg,.jpeg,.png,.pdf" required
                                class="@error('payment_proof') is-invalid @enderror"
                                style="width:100%; padding:12px 16px; border:1.5px solid #e5e7eb; border-radius:12px; font-size:0.88rem; background:#f9fafb; outline:none; cursor:pointer;"
                                onfocus="this.style.borderColor='#f97316'"
                                onblur="this.style.borderColor='#e5e7eb'">
                            <p style="color:#9ca3af; font-size:0.78rem; margin-top:6px; margin-bottom:0;">
                                <i class="bi bi-info-circle me-1"></i>Accepted: JPG, PNG, PDF — Max 5MB
                            </p>
                            @error('payment_proof')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div style="margin-bottom:28px;">
                            <label for="notes" style="font-weight:700; font-size:0.85rem; color:#374151; display:block; margin-bottom:8px;">
                                Notes <span style="color:#9ca3af; font-weight:400;">(optional)</span>
                            </label>
                            <textarea id="notes" name="notes" rows="3"
                                placeholder="e.g. Transfer reference number, date of transfer..."
                                class="@error('notes') is-invalid @enderror"
                                style="width:100%; padding:13px 16px; border:1.5px solid #e5e7eb; border-radius:12px; font-size:0.88rem; background:#f9fafb; outline:none; resize:vertical; font-family:inherit; transition:border .2s;"
                                onfocus="this.style.borderColor='#f97316';this.style.background='#fff'"
                                onblur="this.style.borderColor='#e5e7eb';this.style.background='#f9fafb'">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex flex-wrap gap-3">
                            <button type="submit"
                                style="background:#f97316; color:#fff; border:none; border-radius:30px; padding:13px 36px; font-weight:700; font-size:0.95rem; cursor:pointer; transition:background .2s; display:inline-flex; align-items:center; gap:8px;"
                                onmouseover="this.style.background='#ea6a0a'"
                                onmouseout="this.style.background='#f97316'">
                                <i class="bi bi-send"></i> Submit Payment
                            </button>
                            <a href="{{ route('ebooks.show', $ebook->slug) }}"
                                style="background:transparent; color:#6b7280; border:1.5px solid #e5e7eb; border-radius:30px; padding:12px 28px; font-weight:700; font-size:0.95rem; text-decoration:none; display:inline-flex; align-items:center; transition:all .2s;"
                                onmouseover="this.style.borderColor='#9ca3af';this.style.color='#374151'"
                                onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#6b7280'">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
