<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BookStore') — BookStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:   #1a1a2e;
            --accent:    #f97316;
            --accent-dk: #ea6a0a;
            --star:      #fbbf24;
            --muted:     #6b7280;
            --light-bg:  #f9fafb;
            --border:    #e5e7eb;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Nunito', sans-serif;
            background: #fff;
            color: #1a1a2e;
        }

        h1, h2, h3, h4, h5, .font-serif {
            font-family: 'Playfair Display', serif;
        }

        /* ─── TOP BAR ─── */
        .topbar {
            background: var(--primary);
            color: #d1d5db;
            font-size: 0.78rem;
            padding: 6px 0;
        }
        .topbar a { color: #d1d5db; text-decoration: none; }
        .topbar a:hover { color: #fff; }

        /* ─── NAVBAR ─── */
        .main-navbar {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 10px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
        }
        .main-navbar .navbar-collapse {
            background: #fff;
        }
        .navbar-brand-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.55rem;
            font-weight: 700;
            color: var(--primary) !important;
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        .navbar-brand-logo span { color: var(--accent); }

        .nav-link-custom {
            color: #374151 !important;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 8px 14px !important;
            border-radius: 6px;
            transition: all .2s;
            text-decoration: none;
        }
        .nav-link-custom:hover,
        .nav-link-custom.active {
            color: var(--accent) !important;
            background: #fff7ed;
        }

        .navbar-search {
            position: relative;
            width: 240px;
        }
        .navbar-search input {
            border: 1.5px solid var(--border);
            border-radius: 25px;
            padding: 7px 16px 7px 38px;
            font-size: 0.85rem;
            width: 100%;
            outline: none;
            transition: border .2s;
            background: #f9fafb;
        }
        .navbar-search input:focus { border-color: var(--accent); background: #fff; }
        .navbar-search .search-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 0.9rem;
        }

        .btn-accent {
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 25px;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 8px 20px;
            transition: background .2s, transform .15s;
        }
        .btn-accent:hover { background: var(--accent-dk); color: #fff; transform: translateY(-1px); }

        .btn-outline-accent {
            background: transparent;
            color: var(--accent);
            border: 1.5px solid var(--accent);
            border-radius: 25px;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 7px 18px;
            transition: all .2s;
        }
        .btn-outline-accent:hover { background: var(--accent); color: #fff; }

        /* ─── COLLAPSE FALLBACK (if Bootstrap JS slow to load) ─── */
        .collapse:not(.show) { display: none; }

        /* ─── ALERTS ─── */
        .alert-wrap { padding-top: 16px; }

        /* ─── BOOK CARD ─── */
        .book-card {
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            transition: box-shadow .25s, transform .25s;
            position: relative;
        }
        .book-card:hover {
            box-shadow: 0 10px 36px rgba(0,0,0,.12);
            transform: translateY(-4px);
        }
        .book-cover-wrap {
            position: relative;
            overflow: hidden;
            height: 240px;
            background: #f3f4f6;
        }
        .book-cover-wrap img,
        .book-cover-placeholder {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .book-cover-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        }
        .book-cover-overlay {
            position: absolute;
            inset: 0;
            background: rgba(26,26,46,.55);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity .25s;
        }
        .book-card:hover .book-cover-overlay { opacity: 1; }

        .badge-cat {
            background: #fff7ed;
            color: var(--accent);
            font-size: 0.7rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .star-rating { color: var(--star); font-size: 0.78rem; letter-spacing: 1px; }
        .price-tag { font-size: 1.2rem; font-weight: 700; color: var(--accent); font-family: 'Nunito', sans-serif; }
        .price-old { font-size: 0.85rem; color: var(--muted); text-decoration: line-through; }

        /* ─── SECTION TITLES ─── */
        .section-title { font-size: 1.85rem; font-weight: 700; color: var(--primary); }
        .section-sub { color: var(--muted); font-size: 0.95rem; }
        .section-divider {
            width: 48px; height: 4px;
            background: var(--accent);
            border-radius: 4px;
            margin-bottom: 24px;
        }

        /* ─── CATEGORY PILLS ─── */
        .cat-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 18px;
            border: 1.5px solid var(--border);
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            text-decoration: none;
            transition: all .2s;
            background: #fff;
        }
        .cat-pill:hover,
        .cat-pill.active {
            border-color: var(--accent);
            color: var(--accent);
            background: #fff7ed;
        }

        /* ─── FEATURES ─── */
        .feature-icon {
            width: 60px; height: 60px;
            background: #fff7ed;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            color: var(--accent);
            margin-bottom: 16px;
        }

        /* ─── NEWSLETTER ─── */
        .newsletter-section {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #fff;
            padding: 72px 0;
        }
        .newsletter-section input {
            border: none;
            border-radius: 30px 0 0 30px;
            padding: 14px 24px;
            font-size: 0.9rem;
            width: 100%;
            outline: none;
        }
        .newsletter-section button {
            border-radius: 0 30px 30px 0;
            padding: 14px 28px;
            background: var(--accent);
            color: #fff;
            border: none;
            font-weight: 700;
            white-space: nowrap;
            transition: background .2s;
        }
        .newsletter-section button:hover { background: var(--accent-dk); }

        /* ─── FOOTER ─── */
        footer {
            background: #111827;
            color: #9ca3af;
            padding: 60px 0 0;
            font-size: 0.88rem;
        }
        footer h6 { color: #f9fafb; font-weight: 700; font-size: 0.95rem; margin-bottom: 16px; letter-spacing: .3px; }
        footer a { color: #9ca3af; text-decoration: none; transition: color .2s; }
        footer a:hover { color: var(--accent); }
        footer li { margin-bottom: 8px; }
        .footer-brand { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 700; color: #fff; }
        .footer-brand span { color: var(--accent); }
        .footer-bottom { border-top: 1px solid #1f2937; padding: 20px 0; margin-top: 48px; font-size: 0.8rem; }
        .social-btn {
            width: 36px; height: 36px;
            background: #1f2937;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            text-decoration: none;
            transition: background .2s, color .2s;
        }
        .social-btn:hover { background: var(--accent); color: #fff; }

        /* ─── PAGINATION ─── */
        .pagination .page-link {
            border-radius: 8px !important;
            margin: 0 2px;
            color: var(--primary);
            border: 1px solid var(--border);
            font-weight: 600;
            font-size: 0.88rem;
        }
        .pagination .page-item.active .page-link {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }
        .pagination .page-link:hover { background: #fff7ed; color: var(--accent); border-color: var(--accent); }

        /* ─── BREADCRUMB ─── */
        .breadcrumb-item + .breadcrumb-item::before { color: #9ca3af; }
        .breadcrumb-item a { color: var(--accent); text-decoration: none; }
        .breadcrumb-item.active { color: var(--muted); }

        /* ─── MISC ─── */
        .divider-light { border-color: var(--border); }
        .text-accent { color: var(--accent) !important; }
        .bg-accent { background: var(--accent) !important; }
        .rounded-xl { border-radius: 16px !important; }

        /* ═══════════════════════════ HOME PAGE ═══════════════════════════ */

        /* ── Hero ── */
        .hero-section {
            background: linear-gradient(135deg, #0f0c29 0%, #1a1a2e 40%, #16213e 70%, #0f3460 100%);
            min-height: 560px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .hero-bg-circles { position: absolute; inset: 0; pointer-events: none; }
        .hero-circle { position: absolute; border-radius: 50%; }
        .hero-circle-1 { width: 480px; height: 480px; top: -140px; right: -100px; background: radial-gradient(circle, rgba(249,115,22,.15) 0%, transparent 70%); }
        .hero-circle-2 { width: 320px; height: 320px; bottom: -120px; left: -60px; background: radial-gradient(circle, rgba(99,102,241,.12) 0%, transparent 70%); }
        .hero-circle-3 { width: 200px; height: 200px; top: 60px; left: 38%; background: radial-gradient(circle, rgba(249,115,22,.07) 0%, transparent 70%); }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(249,115,22,.18);
            color: #fb923c;
            border: 1px solid rgba(249,115,22,.3);
            border-radius: 30px;
            padding: 6px 16px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: .5px;
        }
        .hero-heading {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.2rem, 4.5vw, 3.4rem);
            font-weight: 700;
            color: #fff;
            line-height: 1.18;
            margin-bottom: 20px;
        }
        .hero-subtext {
            color: #94a3b8;
            font-size: 1.05rem;
            max-width: 500px;
            line-height: 1.85;
            margin-bottom: 32px;
        }
        .hero-search-form { max-width: 520px; }
        .hero-search-wrap {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 50px;
            padding: 6px 6px 6px 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,.25);
            position: relative;
        }
        .hero-search-icon { color: #9ca3af; margin-right: 8px; font-size: 1rem; flex-shrink: 0; }
        .hero-search-wrap input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 0.92rem;
            color: #1a1a2e;
            background: transparent;
            min-width: 0;
        }
        .hero-search-wrap button {
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 40px;
            padding: 11px 28px;
            font-weight: 700;
            font-size: 0.88rem;
            white-space: nowrap;
            transition: background .2s;
            flex-shrink: 0;
        }
        .hero-search-wrap button:hover { background: var(--accent-dk); }

        .hero-stats { display: flex; align-items: center; gap: 0; }
        .hero-stat { text-align: left; }
        .hero-stat-num { display: block; font-size: 1.5rem; font-weight: 700; color: #fff; line-height: 1; }
        .hero-stat-label { display: block; font-size: 0.78rem; color: #64748b; margin-top: 2px; }
        .hero-stat-divider { width: 1px; height: 40px; background: #334155; margin: 0 24px; }

        /* Hero visual */
        .hero-visual { position: relative; width: 320px; height: 380px; }
        .hero-book-main {
            width: 260px;
            height: 320px;
            background: linear-gradient(145deg, rgba(249,115,22,.18) 0%, rgba(99,102,241,.14) 100%);
            border: 1px solid rgba(249,115,22,.25);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 6rem;
            color: rgba(249,115,22,.6);
            position: relative;
            margin: auto;
            box-shadow: 0 24px 64px rgba(0,0,0,.35);
        }
        .hero-book-badge {
            position: absolute;
            top: -14px;
            right: -14px;
            background: var(--accent);
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 8px 14px;
            border-radius: 20px;
            white-space: nowrap;
            box-shadow: 0 4px 16px rgba(249,115,22,.4);
        }
        .hero-float-card {
            position: absolute;
            background: #fff;
            border-radius: 12px;
            padding: 10px 16px;
            font-size: 0.8rem;
            font-weight: 700;
            color: #1a1a2e;
            display: flex;
            align-items: center;
            box-shadow: 0 8px 32px rgba(0,0,0,.18);
            white-space: nowrap;
        }
        .hero-float-1 { bottom: 30px; left: -20px; animation: floatY 3s ease-in-out infinite; }
        .hero-float-2 { top: 30px; right: -20px; animation: floatY 3s ease-in-out infinite .8s; }
        @keyframes floatY {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        /* ── Category Cards ── */
        .category-section { padding: 64px 0 48px; background: #fff; }
        .section-eyebrow {
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 8px;
        }
        .section-header { }

        .cat-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 24px 12px;
            border: 1.5px solid var(--border);
            border-radius: 16px;
            text-decoration: none;
            transition: all .25s;
            position: relative;
            background: #fff;
        }
        .cat-card:hover {
            border-color: var(--cat-color);
            background: var(--cat-bg);
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0,0,0,.08);
        }
        .cat-card-active {
            border-color: var(--cat-color);
            background: var(--cat-bg);
            box-shadow: 0 8px 24px rgba(0,0,0,.08);
        }
        .cat-card-icon {
            width: 54px;
            height: 54px;
            background: var(--cat-bg, #f9fafb);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--cat-color, #6b7280);
            transition: background .25s;
        }
        .cat-card:hover .cat-card-icon,
        .cat-card-active .cat-card-icon {
            background: var(--cat-color);
            color: #fff;
        }
        .cat-card-label {
            font-size: 0.82rem;
            font-weight: 700;
            color: #374151;
            text-align: center;
        }
        .cat-card-check {
            position: absolute;
            top: 8px;
            right: 8px;
            color: var(--cat-color);
            font-size: 0.9rem;
        }

        /* ── Books Section ── */
        .books-section { padding: 60px 0; background: #f9fafb; }

        .btn-clear-filter {
            display: inline-flex;
            align-items: center;
            border: 1.5px solid var(--accent);
            color: var(--accent);
            background: #fff;
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 700;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all .2s;
        }
        .btn-clear-filter:hover { background: var(--accent); color: #fff; }

        /* Book cards (new) */
        .book-card { background: #fff; border-radius: 16px; border: 1px solid var(--border); overflow: hidden; transition: box-shadow .25s, transform .25s; position: relative; }
        .book-card:hover { box-shadow: 0 16px 48px rgba(0,0,0,.12); transform: translateY(-5px); }
        .book-cover-wrap { position: relative; height: 240px; background: #f3f4f6; overflow: hidden; }
        .book-cover-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform .35s; }
        .book-card:hover .book-cover-wrap img { transform: scale(1.05); }
        .book-cover-placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
            font-size: 3.5rem; color: #a5b4fc;
            transition: transform .35s;
        }
        .book-card:hover .book-cover-placeholder { transform: scale(1.05); }
        .book-cover-overlay {
            position: absolute; inset: 0;
            background: rgba(26,26,46,.55);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; transition: opacity .25s;
        }
        .book-card:hover .book-cover-overlay { opacity: 1; }
        .btn-quickview {
            background: #fff;
            color: #1a1a2e;
            border-radius: 30px;
            padding: 10px 24px;
            font-weight: 700;
            font-size: 0.82rem;
            text-decoration: none;
            transition: all .2s;
        }
        .btn-quickview:hover { background: var(--accent); color: #fff; }
        .book-badge-cat {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(255,255,255,.92);
            color: var(--accent);
            font-size: 0.68rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }
        .book-body { padding: 16px; display: flex; flex-direction: column; gap: 4px; }
        .book-title { font-family: 'Playfair Display', serif; font-size: 0.95rem; font-weight: 700; line-height: 1.4; margin: 0; }
        .book-title a { color: #1a1a2e; text-decoration: none; }
        .book-title a:hover { color: var(--accent); }
        .book-author { color: #6b7280; font-size: 0.78rem; margin: 0; }
        .book-stars { color: #fbbf24; font-size: 0.75rem; letter-spacing: 1px; }
        .book-stars span { color: #6b7280; font-size: 0.72rem; margin-left: 4px; }
        .book-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 8px; padding-top: 10px; border-top: 1px solid #f3f4f6; }
        .book-price { font-size: 1.2rem; font-weight: 700; color: var(--accent); }
        .btn-buy {
            background: var(--accent);
            color: #fff;
            border-radius: 20px;
            padding: 6px 18px;
            font-weight: 700;
            font-size: 0.78rem;
            text-decoration: none;
            transition: background .2s;
        }
        .btn-buy:hover { background: var(--accent-dk); color: #fff; }

        /* Empty state */
        .empty-state { text-align: center; padding: 80px 0; }
        .empty-state-icon { width: 100px; height: 100px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 2.5rem; color: #d1d5db; }
        .empty-state h4 { font-weight: 700; margin-bottom: 8px; }
        .empty-state p { color: #6b7280; margin-bottom: 24px; }
        .btn-accent-pill { background: var(--accent); color: #fff; border-radius: 30px; padding: 12px 32px; font-weight: 700; text-decoration: none; font-size: 0.95rem; }
        .btn-accent-pill:hover { background: var(--accent-dk); color: #fff; }

        /* ── Promo Banner ── */
        .promo-banner { background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%); padding: 64px 0; }
        .promo-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 24px;
        }
        .promo-text h2 { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 700; color: #fff; margin-bottom: 8px; }
        .promo-text p { color: #94a3b8; margin: 0; }
        .promo-actions { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn-promo-primary {
            background: var(--accent);
            color: #fff;
            border-radius: 40px;
            padding: 13px 32px;
            font-weight: 700;
            text-decoration: none;
            font-size: 0.95rem;
            transition: background .2s;
        }
        .btn-promo-primary:hover { background: var(--accent-dk); color: #fff; }
        .btn-promo-outline {
            background: transparent;
            color: #fff;
            border: 1.5px solid rgba(255,255,255,.3);
            border-radius: 40px;
            padding: 12px 28px;
            font-weight: 700;
            text-decoration: none;
            font-size: 0.95rem;
            transition: all .2s;
        }
        .btn-promo-outline:hover { border-color: #fff; background: rgba(255,255,255,.08); }

        /* ── Features ── */
        .features-section { padding: 72px 0; background: #fff; }
        .feature-box { padding: 32px 20px; border-radius: 16px; transition: all .25s; }
        .feature-box:hover { background: #f9fafb; transform: translateY(-4px); box-shadow: 0 8px 32px rgba(0,0,0,.06); }
        .feature-box .feature-icon {
            width: 64px; height: 64px;
            background: #fff7ed;
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.7rem;
            color: var(--accent);
            margin: 0 auto 16px;
            transition: all .25s;
        }
        .feature-box:hover .feature-icon { background: var(--accent); color: #fff; }
        .feature-box h6 { font-weight: 700; font-size: 1rem; margin-bottom: 8px; color: #1a1a2e; }
        .feature-box p { color: #6b7280; font-size: 0.85rem; line-height: 1.7; margin: 0; }
    </style>
    @yield('styles')
</head>
<body>

    {{-- Top bar --}}
    <div class="topbar d-none d-md-block">
        <div class="container d-flex justify-content-between align-items-center">
            <span><i class="bi bi-envelope me-1"></i> support@bookstore.com</span>
            <span>
                @guest
                    <a href="{{ route('login') }}">Login</a>
                    &nbsp;|&nbsp;
                    <a href="{{ route('register') }}">Register</a>
                @endguest
                @auth
                    Welcome, <strong class="text-white">{{ auth()->user()->name }}</strong>
                @endauth
            </span>
        </div>
    </div>

    @hasSection('hide_navbar')
    @else
    {{-- Main Navbar --}}
    <nav class="main-navbar navbar navbar-expand-lg">
        <div class="container">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="navbar-brand-logo me-4">
                <i class="bi bi-book-half me-1 text-accent"></i>Book<span>Store</span>
            </a>

            {{-- Mobile toggler --}}
            <button class="navbar-toggler border-0 ms-auto" type="button"
                data-bs-toggle="collapse" data-bs-target="#mainNavMenu"
                aria-controls="mainNavMenu" aria-expanded="false"
                style="font-size:1.3rem; color:var(--primary); box-shadow:none;">
                <i class="bi bi-list"></i>
            </button>

            {{-- Collapsible content --}}
            <div class="collapse navbar-collapse" id="mainNavMenu">
                {{-- Nav links --}}
                <ul class="navbar-nav me-auto align-items-lg-center gap-lg-1 mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link-custom {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom" href="{{ route('home') }}">Browse</a>
                    </li>
                    @auth
                        @if(!auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link-custom {{ request()->routeIs('library') ? 'active' : '' }}" href="{{ route('library') }}">My Library</a>
                            </li>
                        @endif
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link-custom {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-1"></i>Admin
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>

                {{-- Search --}}
                <form action="{{ route('home') }}" method="GET" class="me-2 my-2 my-lg-0">
                    <div class="navbar-search">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" name="search" placeholder="Search books..." value="{{ request('search') }}">
                    </div>
                </form>

                {{-- Auth buttons --}}
                <div class="d-flex align-items-center gap-2 my-2 my-lg-0">
                    @guest
                        <a href="{{ route('login') }}" class="btn-outline-accent text-decoration-none">Login</a>
                        <a href="{{ route('register') }}" class="btn-accent text-decoration-none">Register</a>
                    @endguest
                    @auth
                        <div class="dropdown">
                            <button class="btn-outline-accent dropdown-toggle border-0 d-flex align-items-center gap-2"
                                data-bs-toggle="dropdown"
                                style="background:#fff7ed; border:1.5px solid var(--accent) !important; border-radius:25px; padding:7px 16px; font-weight:700; font-size:0.85rem; color:var(--accent);">
                                <i class="bi bi-person-circle"></i>
                                {{ Str::limit(auth()->user()->name, 12) }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius:12px; min-width:200px;">
                                <li><span class="dropdown-item-text text-muted small">{{ auth()->user()->email }}</span></li>
                                <li><hr class="dropdown-divider my-1"></li>
                                @if(!auth()->user()->isAdmin())
                                    <li>
                                        <a class="dropdown-item" href="{{ route('library') }}">
                                            <i class="bi bi-collection me-2 text-accent"></i>My Library
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    @endif

    {{-- Flash Messages --}}
    <div class="container alert-wrap">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i>{{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <main>
        @yield('content')
    </main>

    {{-- Newsletter --}}
    @hasSection('hide_newsletter')
    @else
    <section class="newsletter-section">
        <div class="container text-center">
            <p class="text-accent fw-bold mb-2" style="letter-spacing: 1px; font-size: 0.85rem; text-transform: uppercase;">Stay Updated</p>
            <h2 class="text-white mb-2" style="font-size: 2rem;">Get New Books Straight to Your Inbox</h2>
            <p style="color: #9ca3af; margin-bottom: 32px;">Subscribe and be the first to know about new releases and exclusive deals.</p>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="d-flex">
                        <input type="email" placeholder="Your email address...">
                        <button type="button">Subscribe <i class="bi bi-arrow-right ms-1"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Footer --}}
    <footer>
        <div class="container">
            <div class="row g-5">
                <div class="col-md-4">
                    <div class="footer-brand mb-3"><i class="bi bi-book-half me-2" style="color: var(--accent);"></i>Book<span>Store</span></div>
                    <p style="line-height: 1.8; max-width: 280px;">Your curated digital library for the best ebooks across all genres — programming, design, business & more.</p>
                    <div class="d-flex gap-2 mt-3">
                        <a href="#" class="social-btn"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}"><i class="bi bi-chevron-right me-1" style="font-size: .7rem;"></i>Home</a></li>
                        <li><a href="{{ route('home') }}"><i class="bi bi-chevron-right me-1" style="font-size: .7rem;"></i>Browse Books</a></li>
                        @guest
                            <li><a href="{{ route('login') }}"><i class="bi bi-chevron-right me-1" style="font-size: .7rem;"></i>Login</a></li>
                            <li><a href="{{ route('register') }}"><i class="bi bi-chevron-right me-1" style="font-size: .7rem;"></i>Register</a></li>
                        @endguest
                        @auth
                            <li><a href="{{ route('library') }}"><i class="bi bi-chevron-right me-1" style="font-size: .7rem;"></i>My Library</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="col-6 col-md-2">
                    <h6>Categories</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home', ['category' => 'Programming']) }}"><i class="bi bi-chevron-right me-1" style="font-size: .7rem;"></i>Programming</a></li>
                        <li><a href="{{ route('home', ['category' => 'Design']) }}"><i class="bi bi-chevron-right me-1" style="font-size: .7rem;"></i>Design</a></li>
                        <li><a href="{{ route('home', ['category' => 'Business']) }}"><i class="bi bi-chevron-right me-1" style="font-size: .7rem;"></i>Business</a></li>
                        <li><a href="{{ route('home', ['category' => 'Fiction']) }}"><i class="bi bi-chevron-right me-1" style="font-size: .7rem;"></i>Fiction</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6>Payment Info</h6>
                    <p>We accept manual bank transfer payments. Simply upload your proof of transfer and our team will approve your purchase shortly.</p>
                    <div class="d-flex gap-2 flex-wrap mt-2">
                        <span class="badge" style="background: #1f2937; color: #9ca3af; padding: 6px 12px; border-radius: 6px; font-size: 0.78rem;">
                            <i class="bi bi-bank me-1"></i>Bank Transfer
                        </span>
                        <span class="badge" style="background: #1f2937; color: #9ca3af; padding: 6px 12px; border-radius: 6px; font-size: 0.78rem;">
                            <i class="bi bi-shield-check me-1"></i>Secure
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
                <span>&copy; {{ date('Y') }} BookStore. All rights reserved.</span>
                <span>Made with <i class="bi bi-heart-fill" style="color: var(--accent);"></i> for book lovers</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
