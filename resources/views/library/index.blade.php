@extends('layouts.app')

@section('title', 'My Library')

@section('content')

{{-- Page Header --}}
<div style="background:linear-gradient(135deg,#1a1a2e 0%,#16213e 100%); padding:48px 0;">
    <div class="container">
        <p style="color:#f97316; font-weight:700; font-size:0.8rem; letter-spacing:1.5px; text-transform:uppercase; margin-bottom:8px;">
            <i class="bi bi-collection me-1"></i>Your Account
        </p>
        <h1 style="font-family:'Playfair Display',serif; font-size:2.2rem; font-weight:700; color:#fff; margin-bottom:6px;">My Library</h1>
        <p style="color:#9ca3af; margin-bottom:0;">Your purchased ebooks and payment history</p>
    </div>
</div>

<section style="padding:56px 0; background:#f9fafb; min-height:60vh;">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                @if(!$purchases->isEmpty())
                    <p class="text-muted mb-0" style="font-size:0.9rem;">
                        {{ $purchases->count() }} book(s) in your library
                    </p>
                @endif
            </div>
            <a href="{{ route('home') }}"
                style="background:#f97316; color:#fff; border-radius:25px; padding:10px 24px; font-weight:700; font-size:0.85rem; text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:background .2s;"
                onmouseover="this.style.background='#ea6a0a'"
                onmouseout="this.style.background='#f97316'">
                <i class="bi bi-search"></i> Browse More Books
            </a>
        </div>

        @if($purchases->isEmpty())
            <div style="text-align:center; padding:80px 20px; background:#fff; border-radius:20px; border:1px solid #e5e7eb;">
                <div style="width:100px; height:100px; background:#f9fafb; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 24px; border:2px dashed #e5e7eb;">
                    <i class="bi bi-collection" style="font-size:2.5rem; color:#d1d5db;"></i>
                </div>
                <h4 style="font-family:'Playfair Display',serif; font-weight:700; margin-bottom:8px;">Your library is empty</h4>
                <p style="color:#6b7280; margin-bottom:28px;">Browse our catalog and purchase your first ebook!</p>
                <a href="{{ route('home') }}"
                    style="background:#f97316; color:#fff; border-radius:30px; padding:13px 36px; font-weight:700; font-size:0.95rem; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:background .2s;"
                    onmouseover="this.style.background='#ea6a0a'"
                    onmouseout="this.style.background='#f97316'">
                    <i class="bi bi-search"></i> Browse Ebooks
                </a>
            </div>
        @else
            <div class="d-flex flex-column gap-3">
                @foreach($purchases as $purchase)
                    <div style="background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:24px; transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,.07)'" onmouseout="this.style.boxShadow='none'">
                        <div class="row align-items-center g-3">

                            {{-- Cover --}}
                            <div class="col-auto">
                                @if($purchase->ebook && $purchase->ebook->cover_image)
                                    <img src="{{ asset('storage/' . $purchase->ebook->cover_image) }}"
                                        style="width:72px; height:90px; object-fit:cover; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,.12);"
                                        alt="{{ $purchase->ebook->title }}">
                                @else
                                    <div style="width:72px; height:90px; background:linear-gradient(135deg,#e0e7ff,#c7d2fe); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                                        <i class="bi bi-book" style="font-size:1.5rem; color:#818cf8;"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="col">
                                <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                    <h5 style="font-family:'Playfair Display',serif; font-weight:700; margin-bottom:0; font-size:1.05rem; color:#1a1a2e;">
                                        {{ $purchase->ebook->title ?? 'Deleted Ebook' }}
                                    </h5>
                                    @if($purchase->payment_status === 'approved')
                                        <span style="background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0; border-radius:20px; padding:2px 12px; font-size:0.72rem; font-weight:700;">
                                            <i class="bi bi-check-circle-fill me-1"></i>Approved
                                        </span>
                                    @elseif($purchase->payment_status === 'pending')
                                        <span style="background:#fffbeb; color:#d97706; border:1px solid #fde68a; border-radius:20px; padding:2px 12px; font-size:0.72rem; font-weight:700;">
                                            <i class="bi bi-clock-fill me-1"></i>Pending Review
                                        </span>
                                    @else
                                        <span style="background:#fef2f2; color:#dc2626; border:1px solid #fecaca; border-radius:20px; padding:2px 12px; font-size:0.72rem; font-weight:700;">
                                            <i class="bi bi-x-circle-fill me-1"></i>Rejected
                                        </span>
                                    @endif
                                </div>
                                @if($purchase->ebook)
                                    <p style="color:#6b7280; font-size:0.82rem; margin-bottom:6px;">by <strong>{{ $purchase->ebook->author }}</strong></p>
                                @endif
                                <div class="d-flex flex-wrap gap-3" style="font-size:0.8rem; color:#9ca3af;">
                                    <span><i class="bi bi-tag me-1 text-accent"></i>${{ number_format($purchase->amount, 2) }}</span>
                                    <span><i class="bi bi-calendar3 me-1"></i>{{ $purchase->created_at->format('M d, Y') }}</span>
                                    @if($purchase->notes && $purchase->payment_status === 'pending')
                                        <span><i class="bi bi-chat-text me-1"></i>{{ Str::limit($purchase->notes, 50) }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Action --}}
                            <div class="col-auto text-center">
                                @if($purchase->isApproved() && $purchase->ebook)
                                    <a href="{{ route('library.download', $purchase->ebook) }}"
                                        style="background:#f97316; color:#fff; border-radius:25px; padding:10px 24px; font-weight:700; font-size:0.85rem; text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:background .2s;"
                                        onmouseover="this.style.background='#ea6a0a'"
                                        onmouseout="this.style.background='#f97316'">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                @elseif($purchase->isPending())
                                    <div>
                                        <div class="spinner-border spinner-border-sm mb-1" style="color:#d97706;" role="status"></div>
                                        <div style="font-size:0.75rem; color:#9ca3af;">Awaiting approval</div>
                                    </div>
                                @else
                                    <div>
                                        <i class="bi bi-x-circle-fill d-block mb-1" style="font-size:1.4rem; color:#dc2626;"></i>
                                        <div style="font-size:0.75rem; color:#9ca3af;">Rejected</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($purchase->payment_status === 'rejected' && $purchase->notes)
                            <div style="margin-top:14px; background:#fef2f2; border:1px solid #fecaca; border-radius:10px; padding:12px 16px; font-size:0.82rem; color:#dc2626;">
                                <i class="bi bi-info-circle me-1"></i>
                                <strong>Rejection reason:</strong> {{ $purchase->notes }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
