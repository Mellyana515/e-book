@extends('layouts.app')

@section('title', $ebook->title)

@section('content')

{{-- Breadcrumb --}}
<div style="background:#f9fafb; border-bottom:1px solid #e5e7eb; padding:12px 0;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size:0.85rem;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('home', ['category' => $ebook->category]) }}">{{ $ebook->category }}</a></li>
                <li class="breadcrumb-item active">{{ Str::limit($ebook->title, 40) }}</li>
            </ol>
        </nav>
    </div>
</div>

<section style="padding: 56px 0;">
    <div class="container">
        <div class="row g-5">

            {{-- Book Cover --}}
            <div class="col-md-4 col-lg-3">
                <div class="sticky-top" style="top: 90px;">
                    @if($ebook->cover_image)
                        <img src="{{ asset('storage/' . $ebook->cover_image) }}"
                            class="img-fluid w-100"
                            alt="{{ $ebook->title }}"
                            style="border-radius:16px; box-shadow:0 20px 60px rgba(0,0,0,.15); max-height:420px; object-fit:cover;">
                    @else
                        <div style="height:360px; border-radius:16px; background:linear-gradient(135deg,#e0e7ff,#c7d2fe); display:flex; align-items:center; justify-content:center; box-shadow:0 20px 60px rgba(0,0,0,.1);">
                            <i class="bi bi-book" style="font-size:5rem; color:#818cf8; opacity:.7;"></i>
                        </div>
                    @endif

                    {{-- Price box under cover --}}
                    <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:12px; padding:20px; margin-top:20px; text-align:center;">
                        <div class="price-tag mb-1">${{ number_format($ebook->price, 2) }}</div>
                        <p style="color:#6b7280; font-size:0.8rem; margin-bottom:0;">One-time purchase • PDF format</p>
                    </div>
                </div>
            </div>

            {{-- Details --}}
            <div class="col-md-8 col-lg-9">
                <span class="badge-cat d-inline-block mb-3">{{ $ebook->category }}</span>

                <h1 style="font-family:'Playfair Display',serif; font-size:clamp(1.6rem,3vw,2.4rem); font-weight:700; color:#1a1a2e; line-height:1.3; margin-bottom:10px;">
                    {{ $ebook->title }}
                </h1>

                <p style="color:#6b7280; font-size:0.95rem; margin-bottom:20px;">
                    <i class="bi bi-person me-1"></i>by <strong style="color:#374151;">{{ $ebook->author }}</strong>
                </p>

                {{-- Star Rating --}}
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="star-rating" style="font-size:1rem;">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                    </div>
                    <span style="color:#6b7280; font-size:0.85rem;">4.5 out of 5</span>
                    <span style="color:#d1d5db;">•</span>
                    <span style="color:#6b7280; font-size:0.85rem;">PDF Format</span>
                </div>

                <hr style="border-color:#e5e7eb; margin-bottom:28px;">

                {{-- Price --}}
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="price-tag" style="font-size:2rem;">${{ number_format($ebook->price, 2) }}</span>
                </div>

                {{-- CTA --}}
                <div class="mb-5">
                    @if($isPurchased)
                        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; padding:20px 24px; display:inline-flex; align-items:flex-start; gap:14px;">
                            <i class="bi bi-check-circle-fill text-success" style="font-size:1.5rem; margin-top:2px;"></i>
                            <div>
                                <strong style="color:#15803d;">You own this ebook!</strong>
                                <div class="mt-1 d-flex gap-3 flex-wrap" style="font-size:0.88rem;">
                                    <a href="{{ route('library.download', $ebook) }}"
                                        style="background:#16a34a; color:#fff; border-radius:20px; padding:7px 20px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                                        <i class="bi bi-download"></i> Download PDF
                                    </a>
                                    <a href="{{ route('library') }}"
                                        style="color:#16a34a; font-weight:600; text-decoration:none; padding:7px 0; display:inline-flex; align-items:center; gap:4px;">
                                        <i class="bi bi-collection"></i> My Library
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        @auth
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                <a href="{{ route('purchase.create', $ebook) }}"
                                    style="background:#f97316; color:#fff; border:none; border-radius:40px; padding:14px 40px; font-weight:700; font-size:1rem; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:background .2s;"
                                    onmouseover="this.style.background='#ea6a0a'"
                                    onmouseout="this.style.background='#f97316'">
                                    <i class="bi bi-cart-plus"></i>
                                    Purchase — ${{ number_format($ebook->price, 2) }}
                                </a>
                                <div style="font-size:0.8rem; color:#6b7280;">
                                    <i class="bi bi-shield-check me-1 text-success"></i>Secure bank transfer
                                </div>
                            </div>
                        @else
                            <div class="d-flex flex-wrap gap-3">
                                <a href="{{ route('login') }}"
                                    style="background:#f97316; color:#fff; border-radius:40px; padding:14px 40px; font-weight:700; font-size:1rem; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:background .2s;"
                                    onmouseover="this.style.background='#ea6a0a'"
                                    onmouseout="this.style.background='#f97316'">
                                    <i class="bi bi-box-arrow-in-right"></i> Login to Purchase
                                </a>
                                <a href="{{ route('register') }}"
                                    style="background:transparent; color:#f97316; border:1.5px solid #f97316; border-radius:40px; padding:13px 32px; font-weight:700; font-size:1rem; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:all .2s;"
                                    onmouseover="this.style.background='#f97316';this.style.color='#fff'"
                                    onmouseout="this.style.background='transparent';this.style.color='#f97316'">
                                    Create Account
                                </a>
                            </div>
                        @endauth
                    @endif
                </div>

                {{-- Description --}}
                <div style="background:#f9fafb; border-radius:16px; padding:28px; margin-bottom:24px; border:1px solid #e5e7eb;">
                    <h5 style="font-family:'Playfair Display',serif; font-weight:700; margin-bottom:14px; color:#1a1a2e;">
                        <i class="bi bi-file-text me-2" style="color:#f97316;"></i>About This Book
                    </h5>
                    <p style="line-height:1.9; color:#374151; margin-bottom:0;">{{ $ebook->description }}</p>
                </div>

                {{-- Meta cards --}}
                <div class="row g-3">
                    <div class="col-sm-4">
                        <div style="border:1px solid #e5e7eb; border-radius:12px; padding:20px; text-align:center; background:#fff; transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,.08)'" onmouseout="this.style.boxShadow='none'">
                            <i class="bi bi-person-fill" style="font-size:1.6rem; color:#f97316; display:block; margin-bottom:8px;"></i>
                            <div style="color:#9ca3af; font-size:0.75rem; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px;">Author</div>
                            <div style="font-weight:700; font-size:0.9rem; color:#1a1a2e;">{{ $ebook->author }}</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div style="border:1px solid #e5e7eb; border-radius:12px; padding:20px; text-align:center; background:#fff; transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,.08)'" onmouseout="this.style.boxShadow='none'">
                            <i class="bi bi-tag-fill" style="font-size:1.6rem; color:#f97316; display:block; margin-bottom:8px;"></i>
                            <div style="color:#9ca3af; font-size:0.75rem; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px;">Category</div>
                            <div style="font-weight:700; font-size:0.9rem; color:#1a1a2e;">{{ $ebook->category }}</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div style="border:1px solid #e5e7eb; border-radius:12px; padding:20px; text-align:center; background:#fff; transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,.08)'" onmouseout="this.style.boxShadow='none'">
                            <i class="bi bi-filetype-pdf" style="font-size:1.6rem; color:#f97316; display:block; margin-bottom:8px;"></i>
                            <div style="color:#9ca3af; font-size:0.75rem; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px;">Format</div>
                            <div style="font-weight:700; font-size:0.9rem; color:#1a1a2e;">PDF</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
