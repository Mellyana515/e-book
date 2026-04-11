@extends('layouts.app')

@section('title', 'BookStore — Your Digital Library')

@section('content')

{{-- ═══════════════════════════ HERO ═══════════════════════════ --}}
<section class="hero-section">
    <div class="hero-bg-circles">
        <div class="hero-circle hero-circle-1"></div>
        <div class="hero-circle hero-circle-2"></div>
        <div class="hero-circle hero-circle-3"></div>
    </div>
    <div class="container py-5" style="position:relative;z-index:1;">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="hero-badge mb-3">
                    <i class="bi bi-lightning-fill me-1"></i> New Arrivals Every Week
                </div>
                <h1 class="hero-heading">
                    Discover &amp; Read<br>
                    The Best <span class="text-accent">Ebooks</span><br>
                    Online
                </h1>
                <p class="hero-subtext">
                    Over {{ $ebooks->total() }}+ premium ebooks across programming, design,
                    business, fiction &amp; more — all instantly downloadable.
                </p>
                <form action="{{ route('home') }}" method="GET" class="hero-search-form">
                    <div class="hero-search-wrap">
                        <i class="bi bi-search hero-search-icon"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by title, author, category...">
                        <button type="submit">Search</button>
                    </div>
                </form>
                <div class="hero-stats mt-4">
                    <div class="hero-stat">
                        <span class="hero-stat-num">{{ $ebooks->total() }}+</span>
                        <span class="hero-stat-label">Ebooks</span>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div class="hero-stat">
                        <span class="hero-stat-num">{{ count($categories) }}+</span>
                        <span class="hero-stat-label">Categories</span>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div class="hero-stat">
                        <span class="hero-stat-num">PDF</span>
                        <span class="hero-stat-label">Format</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-flex justify-content-center">
                <div class="hero-visual">
                    <div class="hero-book-main">
                        <i class="bi bi-book-half"></i>
                        <div class="hero-book-badge">
                            <i class="bi bi-star-fill"></i> Top Rated
                        </div>
                    </div>
                    <div class="hero-float-card hero-float-1">
                        <i class="bi bi-download me-2" style="color:#f97316;"></i>
                        <span>Instant Download</span>
                    </div>
                    <div class="hero-float-card hero-float-2">
                        <i class="bi bi-people me-2" style="color:#10b981;"></i>
                        <span>1,200+ Readers</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════ CATEGORY CARDS ════════════════════════ --}}
<section class="category-section">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="section-eyebrow">Browse by Genre</span>
            <h2 class="section-title">Popular Categories</h2>
            <div class="section-divider mx-auto"></div>
        </div>
        <div class="row g-3 justify-content-center">
            @php
                $catData = [
                    'Programming' => ['icon'=>'bi-code-slash',  'color'=>'#3b82f6', 'bg'=>'#eff6ff'],
                    'Design'      => ['icon'=>'bi-palette',     'color'=>'#8b5cf6', 'bg'=>'#f5f3ff'],
                    'Business'    => ['icon'=>'bi-briefcase',   'color'=>'#f59e0b', 'bg'=>'#fffbeb'],
                    'Fiction'     => ['icon'=>'bi-book',        'color'=>'#ec4899', 'bg'=>'#fdf2f8'],
                    'Marketing'   => ['icon'=>'bi-megaphone',   'color'=>'#10b981', 'bg'=>'#ecfdf5'],
                    'Science'     => ['icon'=>'bi-flask',       'color'=>'#06b6d4', 'bg'=>'#ecfeff'],
                    'Math'        => ['icon'=>'bi-calculator',  'color'=>'#f97316', 'bg'=>'#fff7ed'],
                    'History'     => ['icon'=>'bi-hourglass',   'color'=>'#6b7280', 'bg'=>'#f9fafb'],
                ];
            @endphp

            @foreach($categories as $cat)
                @php
                    $cd = $catData[$cat] ?? ['icon'=>'bi-tag','color'=>'#6b7280','bg'=>'#f9fafb'];
                    $isActive = request('category') === $cat;
                @endphp
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="{{ route('home', array_merge(request()->except('page'), ['category' => $cat])) }}"
                        class="cat-card {{ $isActive ? 'cat-card-active' : '' }}"
                        style="--cat-color:{{ $cd['color'] }}; --cat-bg:{{ $cd['bg'] }};">
                        <div class="cat-card-icon">
                            <i class="bi {{ $cd['icon'] }}"></i>
                        </div>
                        <span class="cat-card-label">{{ $cat }}</span>
                        @if($isActive)
                            <span class="cat-card-check"><i class="bi bi-check-circle-fill"></i></span>
                        @endif
                    </a>
                </div>
            @endforeach

            {{-- All Books --}}
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="{{ route('home') }}"
                    class="cat-card {{ !request('category') ? 'cat-card-active' : '' }}"
                    style="--cat-color:#1a1a2e; --cat-bg:#f1f5f9;">
                    <div class="cat-card-icon">
                        <i class="bi bi-grid-3x3-gap"></i>
                    </div>
                    <span class="cat-card-label">All Books</span>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════ BOOK GRID ════════════════════════ --}}
<section class="books-section">
    <div class="container">

        {{-- Header --}}
        <div class="d-flex flex-wrap align-items-end justify-content-between mb-4 gap-3">
            <div>
                <span class="section-eyebrow">
                    {{ request('category') ?: (request('search') ? 'Search Results' : 'Featured') }}
                </span>
                <h2 class="section-title mb-1">
                    @if(request('search'))
                        Results for "{{ request('search') }}"
                    @elseif(request('category'))
                        {{ request('category') }} Books
                    @else
                        Featured Books
                    @endif
                </h2>
                <div class="section-divider"></div>
            </div>
            @if(request('search') || request('category'))
                <a href="{{ route('home') }}" class="btn-clear-filter">
                    <i class="bi bi-x-circle me-1"></i>Clear Filter
                </a>
            @endif
        </div>

        @if(request('search') || request('category'))
            <p class="text-muted mb-4" style="font-size:0.9rem;">
                Found <strong>{{ $ebooks->total() }}</strong> result(s)
                @if(request('search')) for "<strong>{{ request('search') }}</strong>"@endif
                @if(request('category')) in <strong>{{ request('category') }}</strong>@endif
            </p>
        @endif

        @if($ebooks->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon"><i class="bi bi-search"></i></div>
                <h4>No books found</h4>
                <p>Try different search terms or browse all categories</p>
                <a href="{{ route('home') }}" class="btn-accent-pill">Browse All Books</a>
            </div>
        @else
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">
                @foreach($ebooks as $ebook)
                    <div class="col">
                        <div class="book-card h-100">
                            <div class="book-cover-wrap">
                                @if($ebook->cover_image)
                                    <img src="{{ asset('storage/' . $ebook->cover_image) }}" alt="{{ $ebook->title }}">
                                @else
                                    <div class="book-cover-placeholder">
                                        <i class="bi bi-book"></i>
                                    </div>
                                @endif
                                <div class="book-cover-overlay">
                                    <a href="{{ route('ebooks.show', $ebook->slug) }}" class="btn-quickview">
                                        <i class="bi bi-eye me-1"></i>Quick View
                                    </a>
                                </div>
                                <span class="book-badge-cat">{{ $ebook->category }}</span>
                            </div>
                            <div class="book-body">
                                <h6 class="book-title">
                                    <a href="{{ route('ebooks.show', $ebook->slug) }}">
                                        {{ Str::limit($ebook->title, 48) }}
                                    </a>
                                </h6>
                                <p class="book-author">by <strong>{{ $ebook->author }}</strong></p>
                                <div class="book-stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                    <span>(4.5)</span>
                                </div>
                                <div class="book-footer">
                                    <span class="book-price">${{ number_format($ebook->price, 2) }}</span>
                                    <a href="{{ route('ebooks.show', $ebook->slug) }}" class="btn-buy">
                                        <i class="bi bi-bag me-1"></i>Buy
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($ebooks->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $ebooks->withQueryString()->links() }}
                </div>
            @endif
        @endif
    </div>
</section>

{{-- ════════════════════════ PROMO BANNER ════════════════════════ --}}
<section class="promo-banner">
    <div class="container">
        <div class="promo-inner">
            <div class="promo-text">
                <h2>Start Reading Today</h2>
                <p>Create a free account and unlock access to hundreds of premium ebooks.</p>
            </div>
            <div class="promo-actions">
                @guest
                    <a href="{{ route('register') }}" class="btn-promo-primary">Get Started Free</a>
                    <a href="{{ route('login') }}" class="btn-promo-outline">Sign In</a>
                @else
                    <a href="{{ route('home') }}" class="btn-promo-primary">Browse Books</a>
                    <a href="{{ route('library') }}" class="btn-promo-outline">My Library</a>
                @endguest
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════ FEATURES ════════════════════════ --}}
<section class="features-section">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="section-eyebrow">Why Choose Us</span>
            <h2 class="section-title">The Best Place to Find Ebooks</h2>
            <div class="section-divider mx-auto"></div>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-3 col-6">
                <div class="feature-box">
                    <div class="feature-icon"><i class="bi bi-collection"></i></div>
                    <h6>Huge Collection</h6>
                    <p>Thousands of ebooks across every genre you can imagine.</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="feature-box">
                    <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                    <h6>Secure Payment</h6>
                    <p>Safe bank transfer with fast approval by our team.</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="feature-box">
                    <div class="feature-icon"><i class="bi bi-download"></i></div>
                    <h6>Instant Download</h6>
                    <p>Download immediately after your payment is approved.</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="feature-box">
                    <div class="feature-icon"><i class="bi bi-headset"></i></div>
                    <h6>24/7 Support</h6>
                    <p>Our friendly team is ready to help you any time.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
