<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EBook — Perpustakaan Digital</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300;0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;1,14..32,400&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <style>
    :root {
      --primary: #2563eb;
      --primary-light: #3b82f6;
      --primary-dark: #1d4ed8;
      --primary-glow: rgba(37,99,235,0.18);
      --ink: #0f172a;
      --ink-2: #1e293b;
      --muted: #64748b;
      --muted-2: #94a3b8;
      --border: #e2e8f0;
      --surface: #fff;
      --bg: #f1f5f9;
      --radius-xl: 20px;
      --radius-2xl: 28px;
      --shadow-sm: 0 2px 8px rgba(15,23,42,0.06);
      --shadow-md: 0 8px 24px rgba(15,23,42,0.1);
      --shadow-lg: 0 20px 48px rgba(15,23,42,0.14);
      --ease-spring: cubic-bezier(0.34,1.56,0.64,1);
      --ease-smooth: cubic-bezier(0.16,1,0.3,1);
    }

    /* ─── RESET ─── */
    *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg);
      color: var(--ink);
      overflow-x: hidden;
      padding-bottom: 40px;
      -webkit-font-smoothing: antialiased;
    }
    button { font-family: inherit; }
    img { display: block; }

    /* ─── ANIMATIONS ─── */
    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(18px) scale(0.98); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes fadeIn {
      from { opacity: 0; } to { opacity: 1; }
    }
    @keyframes float {
      0%,100% { transform: translateY(0px) rotate(0deg); }
      50%      { transform: translateY(-10px) rotate(1deg); }
    }
    @keyframes floatReverse {
      0%,100% { transform: translateY(0px) rotate(0deg); }
      50%      { transform: translateY(8px) rotate(-1deg); }
    }
    @keyframes orbPulse {
      0%,100% { transform: scale(1); opacity: 0.5; }
      50%      { transform: scale(1.12); opacity: 0.8; }
    }
    @keyframes shimmer {
      0%   { background-position: -200% center; }
      100% { background-position: 200% center; }
    }
    @keyframes slideNavPill {
      from { opacity: 0; transform: scaleX(0); }
      to   { opacity: 1; transform: scaleX(1); }
    }
    @keyframes ripple {
      from { transform: scale(0); opacity: 0.35; }
      to   { transform: scale(3); opacity: 0; }
    }
    @keyframes stagger1 { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
    @keyframes countUp {
      from { opacity: 0; transform: translateY(8px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes progressFill {
      from { width: 0; }
    }
    @keyframes glow {
      0%,100% { box-shadow: 0 0 0 0 var(--primary-glow); }
      50%      { box-shadow: 0 0 0 10px rgba(37,99,235,0); }
    }

    /* ─── PAGES ─── */
    .page { display: none; }
    .active {
      display: block;
      animation: fadeSlideUp 0.42s var(--ease-smooth) both;
    }

    /* ─── LAYOUT ─── */
    .wrap { max-width: 1200px; margin: auto; padding: 20px 20px 0; }

    /* ─── NAVBAR ─── */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 28px;
      padding: 0 20px;
      height: 68px;
      background: rgba(255,255,255,0.82);
      backdrop-filter: blur(20px) saturate(1.8);
      -webkit-backdrop-filter: blur(20px) saturate(1.8);
      border-radius: 18px;
      border: 1px solid rgba(255,255,255,0.9);
      box-shadow: 0 4px 20px rgba(15,23,42,0.07), 0 1px 0 rgba(255,255,255,0.8) inset;
      position: sticky;
      top: 16px;
      z-index: 100;
    }
    .logo {
      display: flex;
      align-items: center;
      gap: 9px;
      cursor: pointer;
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      font-size: 20px;
      background: linear-gradient(135deg, #1d4ed8 0%, #6366f1 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      transition: opacity 0.2s;
      user-select: none;
    }
    .logo:hover { opacity: 0.85; }
    .logo-icon {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background: linear-gradient(135deg, #2563eb, #6366f1);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      box-shadow: 0 4px 12px rgba(37,99,235,0.35);
    }
    .logo-icon i { color: #fff; font-size: 18px; }
    .nav-links { display: flex; align-items: center; gap: 6px; }
    .nav-link {
      padding: 7px 14px;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 500;
      color: var(--muted);
      cursor: pointer;
      transition: all 0.2s;
      border: none;
      background: none;
    }
    .nav-link:hover { color: var(--primary); background: rgba(37,99,235,0.07); }
    .nav-link.active { color: var(--primary); background: rgba(37,99,235,0.1); font-weight: 600; }
    .btn-login {
      display: flex;
      align-items: center;
      gap: 8px;
      background: linear-gradient(135deg, #2563eb 0%, #6366f1 100%);
      color: #fff;
      border: none;
      padding: 9px 20px;
      border-radius: 12px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.25s var(--ease-spring);
      box-shadow: 0 4px 14px rgba(37,99,235,0.35);
      position: relative;
      overflow: hidden;
    }
    .btn-login::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
      opacity: 0;
      transition: opacity 0.2s;
    }
    .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(37,99,235,0.45); }
    .btn-login:hover::after { opacity: 1; }
    .btn-login:active { transform: translateY(0); }

    /* ─── HERO ─── */
    .hero {
      position: relative;
      overflow: hidden;
      background: linear-gradient(135deg, #f0f7ff 0%, #eef2ff 50%, #fafbff 100%);
      border-radius: var(--radius-2xl);
      padding: 40px 40px 44px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 32px;
      margin-bottom: 36px;
      min-height: 280px;
      border: 1px solid rgba(99,102,241,0.12);
      box-shadow: var(--shadow-lg);
    }
    .hero-orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(60px);
      pointer-events: none;
    }
    .hero-orb-1 {
      width: 320px; height: 320px;
      background: radial-gradient(circle, rgba(99,102,241,0.22), transparent 70%);
      top: -80px; left: -80px;
      animation: orbPulse 6s ease-in-out infinite;
    }
    .hero-orb-2 {
      width: 280px; height: 280px;
      background: radial-gradient(circle, rgba(37,99,235,0.18), transparent 70%);
      bottom: -60px; right: 200px;
      animation: orbPulse 8s ease-in-out infinite reverse;
    }
    .hero-orb-3 {
      width: 200px; height: 200px;
      background: radial-gradient(circle, rgba(16,185,129,0.12), transparent 70%);
      top: 40px; right: 80px;
      animation: orbPulse 10s ease-in-out infinite 2s;
    }
    .hero-text {
      position: relative;
      z-index: 2;
      max-width: 380px;
    }
    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(37,99,235,0.1);
      color: var(--primary);
      border: 1px solid rgba(37,99,235,0.2);
      border-radius: 999px;
      padding: 5px 12px;
      font-size: 12px;
      font-weight: 600;
      margin-bottom: 16px;
      animation: countUp 0.6s var(--ease-smooth) 0.1s both;
    }
    .hero-title {
      font-family: 'Poppins', sans-serif;
      font-size: 36px;
      font-weight: 700;
      line-height: 1.15;
      color: var(--ink);
      margin-bottom: 14px;
      animation: countUp 0.6s var(--ease-smooth) 0.2s both;
    }
    .hero-title-accent {
      background: linear-gradient(135deg, #2563eb, #6366f1);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .hero-sub {
      color: var(--muted);
      font-size: 15px;
      line-height: 1.7;
      margin-bottom: 24px;
      animation: countUp 0.6s var(--ease-smooth) 0.3s both;
    }
    .hero-cta {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: linear-gradient(135deg, #2563eb, #6366f1);
      color: #fff;
      border: none;
      padding: 13px 24px;
      border-radius: 14px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s var(--ease-spring);
      box-shadow: 0 8px 24px rgba(37,99,235,0.35);
      animation: countUp 0.6s var(--ease-smooth) 0.4s both;
      position: relative;
      overflow: hidden;
    }
    .hero-cta:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 14px 32px rgba(37,99,235,0.45); }
    .hero-cta:active { transform: translateY(0) scale(0.98); }
    .hero-cta i { transition: transform 0.3s var(--ease-spring); }
    .hero-cta:hover i { transform: translateX(3px); }

    .hero-visual {
      position: relative;
      z-index: 2;
      flex: 1;
      min-height: 240px;
      display: flex;
      align-items: center;
      justify-content: flex-end;
      gap: 24px;
    }
    .hero-books {
      display: flex;
      flex-direction: column;
      gap: 12px;
      padding-bottom: 8px;
    }
    .hero-book {
      width: 148px;
      height: 40px;
      border-radius: 16px;
      position: relative;
      box-shadow: 0 16px 32px rgba(15,23,42,0.2);
      transform-origin: left bottom;
      overflow: hidden;
      transition: transform 0.3s var(--ease-spring);
    }
    .hero-book:hover { transform: scale(1.04) !important; }
    .hero-book::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(255,255,255,0.22), transparent 50%);
    }
    .hero-book::after {
      content: '';
      position: absolute;
      right: 0; top: 5px;
      width: 12px;
      height: calc(100% - 10px);
      border-radius: 0 8px 8px 0;
      background: linear-gradient(90deg, #f5efe0, #e8d9b8);
    }
    .hero-book:nth-child(1) { background: linear-gradient(135deg, #3d76b6, #162a4e); transform: rotate(-5deg) translateX(-4px); z-index:3; animation: float 6s ease-in-out infinite; }
    .hero-book:nth-child(2) { background: linear-gradient(135deg, #31967b, #174d3f); transform: rotate(-1deg) translateX(12px); z-index:2; animation: floatReverse 7s ease-in-out infinite; }
    .hero-book:nth-child(3) { background: linear-gradient(135deg, #d79546, #9a5e1e); transform: rotate(3deg) translateX(24px); z-index:1; animation: float 8s ease-in-out infinite 1s; }
    .hero-device {
      width: 160px;
      height: 210px;
      border-radius: 28px;
      background: #1a1f2e;
      padding: 10px;
      box-shadow:
        0 24px 48px rgba(15,23,42,0.35),
        0 0 0 2px rgba(255,255,255,0.07),
        inset 0 1px 0 rgba(255,255,255,0.08);
      transform: rotate(2deg);
      animation: float 7s ease-in-out infinite 0.5s;
    }
    .hero-screen {
      width: 100%;
      height: 100%;
      border-radius: 20px;
      background: #f4f7fb;
      padding: 14px 12px 12px;
      display: flex;
      flex-direction: column;
      gap: 0;
      position: relative;
      overflow: hidden;
    }
    /* Top accent bar */
    .hero-screen::before {
      content: '';
      display: block;
      width: 36px;
      height: 4px;
      border-radius: 999px;
      background: #bfcfe8;
      margin: 0 auto 12px;
    }
    .hero-screen-title {
      width: 55%;
      height: 10px;
      border-radius: 999px;
      background: #2563eb;
      opacity: 0.22;
      margin-bottom: 12px;
      flex-shrink: 0;
    }
    .hero-screen-text {
      display: flex;
      flex-direction: column;
      gap: 8px;
      flex: 1;
    }
    .hero-screen-line {
      height: 7px;
      border-radius: 999px;
      background: #cdd8e8;
      flex-shrink: 0;
    }
    .hero-screen-line.l  { width: 100%; opacity: 0.85; }
    .hero-screen-line.m  { width: 78%; opacity: 0.70; }
    .hero-screen-line.s  { width: 52%; opacity: 0.55; }
    .hero-screen-line.xs { width: 35%; opacity: 0.40; }

    /* ─── SECTION TITLE ─── */
    .section-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 20px;
    }
    .section-title {
      font-family: 'Poppins', sans-serif;
      font-size: 20px;
      font-weight: 700;
      color: var(--ink);
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .section-title i { color: var(--primary); font-size: 22px; }
    .section-see-all {
      font-size: 13px;
      font-weight: 600;
      color: var(--primary);
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 4px;
      transition: gap 0.2s;
    }
    .section-see-all:hover { gap: 8px; }

    /* ─── BOOK CARDS ─── */
    .books-grid {
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      gap: 18px;
    }
    .book-card {
      background: var(--surface);
      border-radius: 18px;
      padding: 12px;
      box-shadow: var(--shadow-sm);
      transition: all 0.3s var(--ease-smooth);
      border: 1px solid var(--border);
      position: relative;
      overflow: hidden;
      cursor: default;
    }
    .book-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: linear-gradient(90deg, #2563eb, #6366f1);
      transform: scaleX(0);
      transform-origin: left;
      transition: transform 0.3s var(--ease-smooth);
      border-radius: 999px 999px 0 0;
    }
    .book-card:hover {
      transform: translateY(-8px);
      box-shadow: var(--shadow-lg);
      border-color: rgba(37,99,235,0.2);
    }
    .book-card:hover::before { transform: scaleX(1); }
    .book-cover-wrap { position: relative; margin-bottom: 12px; }
    .book-card img {
      width: 100%;
      border-radius: 12px;
      height: 200px;
      object-fit: cover;
      transition: transform 0.3s var(--ease-smooth);
    }
    .book-card:hover img { transform: scale(1.03); }
    .book-badge-free {
      position: absolute;
      top: 8px; left: 8px;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      background: #10b981;
      color: #fff;
      font-size: 10px;
      font-weight: 700;
      padding: 3px 8px;
      border-radius: 999px;
      box-shadow: 0 3px 8px rgba(16,185,129,0.35);
      letter-spacing: 0.3px;
    }
    .book-title {
      font-size: 13px;
      font-weight: 600;
      color: var(--ink);
      height: 40px;
      overflow: hidden;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      line-height: 1.45;
    }
    .book-author { font-size: 12px; color: var(--muted); margin-top: 3px; }
    .book-meta-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 8px;
      gap: 6px;
    }
    .rating {
      display: flex;
      align-items: center;
      gap: 4px;
      font-size: 11px;
      color: var(--muted);
      font-weight: 500;
    }
    .rating i { color: #f59e0b; font-size: 12px; }
    .btn-detail {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 5px;
      margin-top: 10px;
      padding: 8px;
      border: 1.5px solid rgba(37,99,235,0.3);
      border-radius: 10px;
      color: var(--primary);
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s;
      background: transparent;
      width: 100%;
      position: relative;
      overflow: hidden;
    }
    .btn-detail::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, #2563eb, #6366f1);
      opacity: 0;
      transition: opacity 0.2s;
    }
    .btn-detail:hover { color: #fff; border-color: transparent; }
    .btn-detail:hover::before { opacity: 1; }
    .btn-detail span, .btn-detail i { position: relative; z-index: 1; }

    /* ─── NAVBAR SEARCH ─── */
    .nav-search-wrap {
      position: relative;
      flex: 1;
      max-width: 380px;
      margin: 0 16px;
    }
    .nav-search-icon {
      position: absolute;
      left: 14px; top: 50%;
      transform: translateY(-50%);
      color: var(--muted);
      font-size: 17px;
      pointer-events: none;
    }
    .nav-search-input {
      width: 100%;
      padding: 9px 14px 9px 40px;
      border-radius: 12px;
      border: 1.5px solid var(--border);
      font-size: 13.5px;
      background: var(--bg);
      outline: none;
      transition: all 0.25s;
      font-family: inherit;
      color: var(--ink);
    }
    .nav-search-input::placeholder { color: var(--muted-2); }
    .nav-search-input:focus { border-color: var(--primary); background: var(--surface); box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }

    /* ─── HOME CATEGORY PILLS ─── */
    .home-cat-pills {
      display: flex;
      gap: 8px;
      overflow-x: auto;
      padding-bottom: 4px;
      scrollbar-width: none;
      margin-bottom: 8px;
    }
    .home-cat-pills::-webkit-scrollbar { display: none; }
    .home-cat-pill {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 16px;
      border-radius: 999px;
      border: 1.5px solid var(--border);
      background: var(--surface);
      color: var(--muted);
      font-size: 13px;
      font-weight: 500;
      white-space: nowrap;
      cursor: pointer;
      transition: all 0.22s var(--ease-spring);
      font-family: inherit;
      flex-shrink: 0;
    }
    .home-cat-pill i { font-size: 14px; }
    .home-cat-pill:hover { border-color: var(--primary); color: var(--primary); background: rgba(37,99,235,0.05); }
    .home-cat-pill.active {
      background: var(--primary);
      color: #fff;
      border-color: var(--primary);
      box-shadow: 0 4px 12px rgba(37,99,235,0.3);
    }

    /* ─── CATEGORY PAGE ─── */
    .search-wrap {
      position: relative;
      margin-bottom: 28px;
    }
    .search-icon {
      position: absolute;
      left: 18px; top: 50%;
      transform: translateY(-50%);
      color: var(--muted);
      font-size: 20px;
    }
    .search-full {
      width: 100%;
      padding: 16px 18px 16px 50px;
      border-radius: 16px;
      border: 1.5px solid var(--border);
      font-size: 15px;
      background: var(--surface);
      outline: none;
      transition: all 0.25s;
      box-shadow: var(--shadow-sm);
      font-family: inherit;
    }
    .search-full:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(37,99,235,0.1); }
    .category-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 40px; }
    .cat-card {
      padding: 32px 16px;
      border-radius: 20px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s var(--ease-spring);
      border: 1.5px solid transparent;
      position: relative;
      overflow: hidden;
    }
    .cat-card::after {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: inherit;
      background: rgba(255,255,255,0.6);
      opacity: 0;
      transition: opacity 0.2s;
    }
    .cat-card:hover { transform: translateY(-8px) scale(1.02); box-shadow: var(--shadow-md); }
    .cat-card:hover::after { opacity: 1; }
    .cat-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 64px;
      height: 64px;
      border-radius: 18px;
      margin: 0 auto 16px;
      font-size: 28px;
      transition: transform 0.3s var(--ease-spring);
    }
    .cat-card:hover .cat-icon { transform: scale(1.12) rotate(-4deg); }
    .cat-card p { font-weight: 600; font-size: 14px; color: var(--ink-2); position: relative; z-index: 1; }
    .bg-1 { background: #ebf3ff; }
    .bg-1 .cat-icon { background: rgba(37,99,235,0.12); color: #2563eb; }
    .bg-2 { background: #fff9eb; }
    .bg-2 .cat-icon { background: rgba(245,158,11,0.12); color: #d97706; }
    .bg-3 { background: #f0f9ff; }
    .bg-3 .cat-icon { background: rgba(14,165,233,0.12); color: #0ea5e9; }
    .bg-4 { background: #f0fdf4; }
    .bg-4 .cat-icon { background: rgba(16,185,129,0.12); color: #059669; }
    .bg-5 { background: #fff7ed; }
    .bg-5 .cat-icon { background: rgba(249,115,22,0.12); color: #ea580c; }
    .bg-6 { background: #f0fdfa; }
    .bg-6 .cat-icon { background: rgba(20,184,166,0.12); color: #0d9488; }
    .bg-7 { background: #f5f3ff; }
    .bg-7 .cat-icon { background: rgba(139,92,246,0.12); color: #7c3aed; }
    .bg-8 { background: #ecfeff; }
    .bg-8 .cat-icon { background: rgba(6,182,212,0.12); color: #0891b2; }

    /* ─── FAVORITE PAGE ─── */
    .fav-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 8px;
    }
    .fav-heading {
      font-family: 'Poppins', sans-serif;
      font-size: 22px;
      font-weight: 700;
      color: var(--ink);
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .fav-heading i { color: #ef4444; }
    .btn-manage {
      font-size: 13px;
      font-weight: 600;
      color: var(--primary);
      background: rgba(37,99,235,0.08);
      border: none;
      padding: 7px 14px;
      border-radius: 10px;
      cursor: pointer;
      transition: background 0.2s;
    }
    .btn-manage:hover { background: rgba(37,99,235,0.15); }
    .fav-count { font-size: 13px; color: var(--muted); margin-bottom: 22px; display: flex; align-items: center; gap: 5px; }
    .fav-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; }
    .fav-card {
      cursor: pointer;
      border-radius: 18px;
      padding: 12px;
      transition: all 0.3s var(--ease-smooth);
      background: var(--surface);
      border: 1.5px solid var(--border);
    }
    .fav-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-md); border-color: rgba(37,99,235,0.2); }
    .fav-card img { width: 100%; border-radius: 12px; height: 180px; object-fit: cover; margin-bottom: 10px; transition: transform 0.3s; }
    .fav-card:hover img { transform: scale(1.03); }
    .fav-cover-wrap { position: relative; overflow: hidden; border-radius: 12px; }
    .fav-title { font-weight: 600; font-size: 14px; color: var(--ink); }
    .fav-author { font-size: 12px; color: var(--muted); margin-top: 3px; }

    /* ─── RAK BUKU ─── */
    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
    }
    .page-heading {
      font-family: 'Poppins', sans-serif;
      font-size: 22px;
      font-weight: 700;
      color: var(--ink);
    }
    .page-actions { display: flex; gap: 10px; align-items: center; }
    .icon-btn {
      width: 38px; height: 38px;
      border-radius: 12px;
      border: 1.5px solid var(--border);
      background: var(--surface);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--muted);
      cursor: pointer;
      transition: all 0.2s;
      font-size: 18px;
    }
    .icon-btn:hover { color: var(--primary); border-color: rgba(37,99,235,0.3); background: rgba(37,99,235,0.05); }
    .avatar-sm {
      width: 36px; height: 36px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--border);
    }
    .rak-tabs {
      display: flex;
      gap: 6px;
      background: rgba(37,99,235,0.06);
      padding: 5px;
      border-radius: 14px;
      width: fit-content;
      margin-bottom: 20px;
    }
    .rak-tab {
      padding: 9px 18px;
      border-radius: 10px;
      cursor: pointer;
      font-size: 13px;
      font-weight: 500;
      color: var(--muted);
      transition: all 0.25s var(--ease-spring);
      border: none;
      background: none;
    }
    .rak-tab.active-tab {
      background: var(--surface);
      color: var(--primary);
      font-weight: 600;
      box-shadow: 0 2px 8px rgba(15,23,42,0.08);
    }
    .rak-tab .tab-count {
      background: rgba(37,99,235,0.12);
      color: var(--primary);
      font-size: 10px;
      padding: 2px 6px;
      border-radius: 999px;
      margin-left: 5px;
      font-weight: 700;
    }
    .sort-row { font-size: 13px; color: var(--muted); margin-bottom: 18px; display: flex; align-items: center; gap: 5px; }
    .sort-row b { color: var(--ink); cursor: pointer; }
    .rak-list { display: flex; flex-direction: column; gap: 14px; }
    .rak-item {
      background: var(--surface);
      border-radius: 18px;
      padding: 16px;
      display: flex;
      gap: 18px;
      align-items: center;
      position: relative;
      cursor: pointer;
      transition: all 0.3s var(--ease-smooth);
      border: 1.5px solid var(--border);
      box-shadow: var(--shadow-sm);
    }
    .rak-item:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); border-color: rgba(37,99,235,0.2); }
    .rak-img {
      width: 76px;
      height: 108px;
      border-radius: 12px;
      object-fit: cover;
      flex-shrink: 0;
      box-shadow: 0 8px 16px rgba(15,23,42,0.14);
    }
    .rak-info { flex: 1; min-width: 0; }
    .rak-info h4 { font-size: 15px; font-weight: 600; margin-bottom: 3px; color: var(--ink); }
    .rak-info .rak-author { font-size: 13px; color: var(--muted); margin-bottom: 12px; }
    .progress-text {
      font-size: 12px;
      color: var(--muted);
      margin-bottom: 7px;
      display: flex;
      gap: 12px;
    }
    .progress-text b { color: var(--ink); font-weight: 600; }
    .progress-track {
      width: 100%;
      max-width: 380px;
      height: 6px;
      background: #e2e8f0;
      border-radius: 999px;
      overflow: hidden;
    }
    .progress-fill {
      height: 100%;
      background: linear-gradient(90deg, #3b82f6, #6366f1);
      border-radius: 999px;
      animation: progressFill 1s var(--ease-smooth) both;
    }
    .bookmark-btn {
      position: absolute;
      top: 14px; right: 14px;
      width: 32px; height: 32px;
      border-radius: 10px;
      background: rgba(245,158,11,0.1);
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #f59e0b;
      font-size: 16px;
      cursor: pointer;
      transition: all 0.2s;
    }
    .bookmark-btn:hover { background: rgba(245,158,11,0.2); transform: scale(1.1); }

    /* ─── DETAIL PAGE ─── */
    /* ─── DETAIL PAGE ─── */
    .detail-breadcrumb {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 13px;
      color: var(--muted);
      margin-bottom: 20px;
    }
    .detail-breadcrumb a { color: var(--muted); cursor: pointer; }
    .detail-breadcrumb a:hover { color: var(--primary); }
    .detail-breadcrumb i { font-size: 12px; }
    .detail-breadcrumb span { color: var(--ink); font-weight: 500; }
    .detail-shell {
      background: var(--surface);
      border-radius: var(--radius-2xl);
      padding: 32px;
      display: flex;
      gap: 36px;
      flex-wrap: wrap;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--border);
      margin-bottom: 24px;
    }
    .detail-left { width: 220px; flex-shrink: 0; }
    .detail-right { flex: 1; min-width: 300px; }
    .detail-cover {
      width: 100%;
      border-radius: 16px;
      box-shadow: 0 16px 40px rgba(15,23,42,0.2);
      transition: transform 0.4s var(--ease-spring);
      display: block;
    }
    .detail-cover:hover { transform: scale(1.02); }
    .btn-fav {
      width: 100%;
      margin-top: 14px;
      padding: 11px 14px;
      border-radius: 12px;
      border: 1.5px solid var(--border);
      background: var(--surface);
      color: var(--muted);
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 7px;
      transition: all 0.2s;
      font-family: inherit;
      flex-direction: column;
    }
    .btn-fav-top { display: flex; align-items: center; gap: 7px; }
    .btn-fav-sub { font-size: 11px; font-weight: 400; color: var(--muted-2); margin-top: 2px; }
    .btn-fav:hover { border-color: #ef4444; color: #ef4444; }
    .btn-fav i { font-size: 16px; color: #ef4444; }
    .detail-title {
      font-family: 'Poppins', sans-serif;
      font-size: 28px;
      font-weight: 700;
      color: var(--ink);
      margin-bottom: 6px;
      line-height: 1.2;
    }
    .detail-author-row {
      display: flex;
      align-items: center;
      gap: 6px;
      margin-bottom: 10px;
    }
    .detail-author-row i { color: var(--muted-2); font-size: 15px; }
    .detail-author-row a { color: var(--primary); font-weight: 600; font-size: 14px; cursor: pointer; }
    .detail-author-row a:hover { text-decoration: underline; }
    .detail-rating-row {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      color: var(--muted);
      margin-bottom: 12px;
    }
    .detail-rating-row .stars { color: #f59e0b; display: flex; gap: 1px; }
    .detail-rating-row .rating-score { color: var(--ink); font-weight: 700; }
    .detail-tags { display: flex; gap: 6px; margin-bottom: 14px; flex-wrap: wrap; }
    .detail-tag {
      padding: 4px 12px;
      border-radius: 999px;
      border: 1.5px solid var(--border);
      font-size: 12px;
      font-weight: 600;
      color: var(--ink-2);
      background: var(--surface);
    }
    .detail-desc-text {
      color: var(--muted);
      line-height: 1.8;
      font-size: 14px;
      margin-bottom: 20px;
    }
    .info-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 0;
      padding: 16px 0;
      border-top: 1px solid var(--border);
      border-bottom: 1px solid var(--border);
      margin-bottom: 20px;
    }
    .info-item {
      font-size: 12px;
      color: var(--muted);
      display: flex;
      flex-direction: column;
      gap: 4px;
      padding: 0 12px;
      border-right: 1px solid var(--border);
    }
    .info-item:first-child { padding-left: 0; }
    .info-item:last-child { border-right: none; }
    .info-item-icon { display: flex; align-items: center; gap: 5px; color: var(--muted); font-size: 12px; }
    .info-item-icon i { font-size: 15px; }
    .info-item b { color: var(--ink); font-weight: 600; font-size: 13px; }

    /* Owned / buy action bar */
    .detail-owned-bar {
      background: #f0fdf4;
      border: 1.5px solid #86efac;
      border-radius: 14px;
      padding: 16px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 16px;
      flex-wrap: wrap;
      margin-bottom: 20px;
    }
    .detail-owned-bar .owned-info { flex: 1; }
    .detail-owned-title {
      display: flex;
      align-items: center;
      gap: 8px;
      color: #166534;
      font-weight: 700;
      font-size: 14px;
      margin-bottom: 3px;
    }
    .detail-owned-title i { color: #22c55e; font-size: 18px; }
    .detail-owned-sub { font-size: 12px; color: #4ade80; color: #15803d; }
    .detail-owned-sub a { color: var(--primary); font-weight: 600; cursor: pointer; }
    .detail-owned-actions { display: flex; gap: 10px; align-items: center; flex-shrink: 0; }
    .btn-read {
      display: flex; align-items: center; gap: 7px;
      background: var(--primary); color: #fff;
      border: none; padding: 10px 20px; border-radius: 10px;
      font-size: 13px; font-weight: 700; cursor: pointer;
      font-family: inherit; transition: all 0.2s;
    }
    .btn-read:hover { background: var(--primary-dark); transform: translateY(-1px); }
    .btn-download-split {
      display: flex; align-items: center;
      border: 1.5px solid var(--border); border-radius: 10px;
      background: var(--surface); overflow: hidden;
    }
    .btn-download-main {
      display: flex; align-items: center; gap: 6px;
      padding: 10px 14px; font-size: 13px; font-weight: 600;
      color: var(--ink); cursor: pointer; border: none;
      background: none; font-family: inherit; transition: background 0.2s;
    }
    .btn-download-main:hover { background: #f1f5f9; }
    .btn-download-caret {
      padding: 10px 10px; border-left: 1px solid var(--border);
      cursor: pointer; color: var(--muted); border: none;
      background: none; transition: background 0.2s; font-size: 12px;
    }
    .btn-download-caret:hover { background: #f1f5f9; }
    .detail-format-note {
      font-size: 11px; color: var(--muted-2);
      display: flex; align-items: center; gap: 4px; margin-top: 8px;
    }
    .detail-format-badge {
      background: #f1f5f9; color: var(--muted);
      font-size: 10px; font-weight: 700;
      padding: 2px 6px; border-radius: 4px;
      letter-spacing: 0.5px;
    }

    /* buy bar (not owned) */
    .price-bar {
      background: #f8fafc;
      padding: 16px 20px;
      border-radius: 14px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border: 1.5px solid var(--border);
      gap: 16px;
      flex-wrap: wrap;
      margin-bottom: 20px;
    }
    .price-label { font-size: 12px; color: var(--muted); margin-bottom: 2px; }
    .price-val {
      font-family: 'Poppins', sans-serif;
      font-size: 24px;
      font-weight: 700;
      color: var(--ink);
    }
    .price-val.free { color: #10b981; }
    .btn-buy {
      display: flex;
      align-items: center;
      gap: 8px;
      background: var(--primary);
      color: #fff;
      border: none;
      padding: 12px 24px;
      border-radius: 12px;
      font-size: 14px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.25s var(--ease-spring);
      position: relative;
      overflow: hidden;
      font-family: inherit;
    }
    .btn-buy:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 8px 20px rgba(37,99,235,0.3); }
    .btn-buy:active { transform: scale(0.98); }

    /* Detail tabs */
    .detail-tabs {
      display: flex;
      gap: 0;
      border-bottom: 1.5px solid var(--border);
      margin-bottom: 20px;
    }
    .detail-tab {
      padding: 12px 20px;
      font-size: 14px;
      font-weight: 600;
      color: var(--muted);
      cursor: pointer;
      border: none;
      background: none;
      font-family: inherit;
      border-bottom: 2px solid transparent;
      margin-bottom: -1.5px;
      transition: all 0.2s;
      white-space: nowrap;
    }
    .detail-tab:hover { color: var(--ink); }
    .detail-tab.active { color: var(--primary); border-bottom-color: var(--primary); }
    .detail-tab-panel { display: none; }
    .detail-tab-panel.active { display: block; animation: fadeSlideUp 0.3s var(--ease-smooth); }
    .detail-tab-content { color: var(--muted); line-height: 1.85; font-size: 14px; }

    /* Reviews section */
    .detail-bottom { display: grid; grid-template-columns: 280px 1fr; gap: 24px; margin-top: 0; }
    .detail-reviews-card, .detail-recommend-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-xl);
      padding: 24px;
    }
    .detail-reviews-card h3, .detail-recommend-card h3 {
      font-family: 'Poppins', sans-serif;
      font-size: 17px;
      font-weight: 700;
      color: var(--ink);
      margin-bottom: 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .detail-reviews-card h3 a, .detail-recommend-card h3 a {
      font-size: 12px; font-weight: 600; color: var(--primary);
      font-family: 'Inter', sans-serif; cursor: pointer;
    }
    .review-big-score { font-family: 'Poppins', sans-serif; font-size: 52px; font-weight: 700; color: var(--ink); line-height: 1; }
    .review-stars-row { display: flex; gap: 3px; color: #f59e0b; font-size: 18px; margin: 6px 0 4px; }
    .review-count-text { font-size: 12px; color: var(--muted); }
    .review-bars { margin-top: 14px; display: flex; flex-direction: column; gap: 6px; }
    .review-bar-row { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--muted); }
    .review-bar-row span:first-child { width: 6px; text-align: right; color: var(--ink); font-weight: 500; }
    .review-bar-track { flex: 1; height: 6px; border-radius: 999px; background: #f1f5f9; overflow: hidden; }
    .review-bar-fill { height: 100%; border-radius: 999px; background: #f59e0b; }
    .review-bar-row span:last-child { width: 28px; text-align: right; }
    .review-sample { display: flex; gap: 10px; margin-top: 18px; padding-top: 16px; border-top: 1px solid var(--border); }
    .review-sample-avatar { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
    .review-sample-name { font-weight: 600; font-size: 13px; color: var(--ink); }
    .review-sample-stars { color: #f59e0b; font-size: 12px; margin: 2px 0; }
    .review-sample-time { font-size: 11px; color: var(--muted-2); }
    .review-sample-text { font-size: 13px; color: var(--muted); line-height: 1.6; margin-top: 4px; }

    /* Recommend grid */
    .rec-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 14px; }
    .rec-item { cursor: pointer; border-radius: 12px; transition: all 0.25s var(--ease-smooth); }
    .rec-item:hover { transform: translateY(-4px); }
    .rec-cover { width: 100%; height: 130px; border-radius: 10px; margin-bottom: 8px; object-fit: cover; box-shadow: var(--shadow-sm); }
    .rec-title { font-size: 12px; font-weight: 600; color: var(--ink); margin-bottom: 2px; line-height: 1.3; }
    .rec-author { font-size: 11px; color: var(--muted); margin-bottom: 4px; }
    .rec-rating { display: flex; align-items: center; gap: 3px; font-size: 11px; color: var(--muted); }
    .rec-rating i { color: #f59e0b; }

    /* ─── READER ─── */
    .reader-shell {
      background: linear-gradient(180deg, #eef4ff, #f8fafc);
      border-radius: var(--radius-2xl);
      padding: 28px;
      box-shadow: var(--shadow-md);
    }
    .reader-topbar {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 16px;
      margin-bottom: 22px;
      flex-wrap: wrap;
    }
    .reader-meta h2 { font-family: 'Poppins', sans-serif; font-size: 24px; color: var(--ink); margin-bottom: 4px; }
    .reader-meta p { color: var(--muted); font-size: 13px; }
    .reader-paper {
      background: #fffdf8;
      border-radius: 22px;
      padding: 40px;
      min-height: 460px;
      border: 1px solid #efe7da;
      box-shadow: inset 0 0 0 1px rgba(255,255,255,0.7), 0 8px 24px rgba(139,107,68,0.08);
      text-align: center;
    }
    .reader-chapter-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      margin-bottom: 12px;
      padding: 7px 14px;
      border-radius: 999px;
      background: rgba(37,99,235,0.08);
      color: var(--primary);
      font-size: 12px;
      font-weight: 700;
    }
    .reader-chapter-title {
      display: block;
      margin: 0 auto 20px;
      color: var(--ink);
      font-family: 'Poppins', sans-serif;
      font-size: 18px;
      font-weight: 700;
    }
    .reader-content {
      text-align: left;
      color: #334155;
      font-size: 17px;
      line-height: 2.05;
      white-space: pre-line;
    }
    .reader-progress { margin-top: 24px; padding-top: 18px; border-top: 1px solid rgba(14,9,60,0.08); }
    .reader-progress-row { display: flex; align-items: center; gap: 12px; margin-bottom: 10px; }
    .reader-progress-track { flex: 1; height: 6px; background: #e2e8f0; border-radius: 999px; overflow: hidden; }
    .reader-progress-fill {
      height: 100%;
      width: 0;
      background: linear-gradient(90deg, #60a5fa, #6366f1);
      border-radius: 999px;
      transition: width 0.5s var(--ease-smooth);
    }
    .reader-percent { min-width: 42px; font-size: 15px; font-weight: 700; color: var(--primary); }
    .reader-pages { color: var(--muted); font-size: 13px; }
    .reader-controls { display: flex; justify-content: space-between; gap: 12px; margin-top: 22px; flex-wrap: wrap; }
    .reader-btn {
      display: flex;
      align-items: center;
      gap: 8px;
      border: none;
      border-radius: 14px;
      padding: 13px 22px;
      font-weight: 700;
      cursor: pointer;
      font-size: 14px;
      transition: all 0.25s var(--ease-spring);
      font-family: inherit;
    }
    .reader-btn.primary { background: linear-gradient(135deg, #2563eb, #6366f1); color: #fff; box-shadow: 0 8px 20px rgba(37,99,235,0.28); }
    .reader-btn.primary:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(37,99,235,0.4); }
    .reader-btn.secondary { background: var(--surface); color: var(--ink); border: 1.5px solid var(--border); }
    .reader-btn.secondary:hover { border-color: rgba(37,99,235,0.3); color: var(--primary); }
    .reader-btn:disabled { opacity: 0.4; cursor: not-allowed; transform: none !important; box-shadow: none !important; }

    /* ─── ACCOUNT PAGE ─── */
    .profile-card {
      background: linear-gradient(135deg, #f8fbff, #eef4ff);
      border-radius: 20px;
      padding: 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 20px;
      border: 1px solid rgba(37,99,235,0.12);
      gap: 16px;
    }
    .profile-info { display: flex; align-items: center; gap: 16px; }
    .profile-avatar-wrap { position: relative; }
    .profile-img { width: 72px; height: 72px; border-radius: 50%; object-fit: cover; border: 3px solid rgba(37,99,235,0.2); }
    .profile-online {
      position: absolute;
      bottom: 2px; right: 2px;
      width: 14px; height: 14px;
      background: #10b981;
      border-radius: 50%;
      border: 2px solid #fff;
    }
    .profile-name { font-size: 18px; font-weight: 700; color: var(--ink); }
    .profile-email { color: var(--muted); font-size: 13px; margin-top: 2px; }
    .profile-badge {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      background: rgba(37,99,235,0.1);
      color: var(--primary);
      font-size: 11px;
      font-weight: 600;
      padding: 3px 8px;
      border-radius: 999px;
      margin-top: 5px;
    }
    .btn-edit-profile {
      padding: 9px 18px;
      border: 1.5px solid var(--border);
      border-radius: 12px;
      background: var(--surface);
      color: var(--primary);
      font-weight: 600;
      cursor: pointer;
      font-size: 13px;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      gap: 6px;
      white-space: nowrap;
    }
    .btn-edit-profile:hover { background: rgba(37,99,235,0.05); border-color: rgba(37,99,235,0.3); }
    .menu-list { background: var(--surface); border-radius: 20px; overflow: hidden; border: 1.5px solid var(--border); }
    .menu-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 16px 22px;
      border-bottom: 1px solid #f1f5f9;
      cursor: pointer;
      transition: background 0.2s;
      gap: 12px;
    }
    .menu-item:last-child { border-bottom: none; }
    .menu-item:hover { background: #f8fafc; }
    .menu-left { display: flex; align-items: center; gap: 14px; font-weight: 500; font-size: 14px; color: var(--ink-2); }
    .menu-icon-wrap {
      width: 36px; height: 36px;
      border-radius: 10px;
      background: #f1f5f9;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      flex-shrink: 0;
      transition: all 0.2s;
    }
    .menu-item:hover .menu-icon-wrap { background: rgba(37,99,235,0.1); color: var(--primary); }
    .menu-arrow { color: var(--muted-2); font-size: 16px; }
    .badge-count {
      background: rgba(37,99,235,0.1);
      color: var(--primary);
      font-size: 11px;
      font-weight: 700;
      padding: 2px 8px;
      border-radius: 999px;
      margin-left: auto;
      margin-right: 8px;
    }
    .text-danger { color: #ef4444 !important; }
    .menu-icon-wrap.danger { background: rgba(239,68,68,0.08); color: #ef4444; }

    /* ─── LOGIN PAGE ─── */
    .login-shell {
      display: flex;
      background: var(--surface);
      border-radius: var(--radius-2xl);
      overflow: hidden;
      min-height: 600px;
      box-shadow: var(--shadow-lg);
      border: 1px solid var(--border);
    }
    .login-left {
      flex: 1;
      position: relative;
      overflow: hidden;
      min-height: 520px;
      background: #e8eef8;
    }
    .login-left-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center top;
      display: block;
    }
    .login-left-overlay {
      position: absolute;
      bottom: 24px;
      left: 20px;
      right: 20px;
      background: rgba(255,255,255,0.88);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-radius: 20px;
      padding: 20px 22px;
      border: 1px solid rgba(255,255,255,0.9);
      box-shadow: 0 8px 32px rgba(15,23,42,0.12);
      animation: fadeSlideUp 0.6s var(--ease-smooth) 0.3s both;
    }
    .login-left-overlay h3 {
      font-family: 'Poppins', sans-serif;
      font-size: 16px;
      font-weight: 700;
      color: var(--ink);
      margin-bottom: 4px;
    }
    .login-left-overlay p {
      font-size: 12px;
      color: var(--muted);
      margin-bottom: 16px;
      line-height: 1.6;
    }
    .login-features {
      display: flex;
      gap: 20px;
      justify-content: space-between;
    }
    .login-feature {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 6px;
      font-size: 11px;
      color: var(--muted);
      font-weight: 500;
      text-align: center;
      flex: 1;
    }
    .login-feature-icon {
      width: 38px;
      height: 38px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }
    .login-feature:nth-child(1) .login-feature-icon { background: #eff6ff; color: #2563eb; }
    .login-feature:nth-child(2) .login-feature-icon { background: #fdf2f8; color: #db2777; }
    .login-feature:nth-child(3) .login-feature-icon { background: #ecfdf5; color: #059669; }
    .login-right { flex: 1.1; padding: 48px 44px; display: flex; flex-direction: column; justify-content: center; }
    .login-right h2 { font-family: 'Poppins', sans-serif; font-size: 26px; font-weight: 700; color: var(--ink); margin-bottom: 6px; }
    .login-right > p { color: var(--muted); font-size: 14px; margin-bottom: 28px; line-height: 1.6; }
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 7px; color: var(--ink-2); }
    .form-input-wrap { position: relative; }
    .form-input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--muted-2); font-size: 17px; pointer-events: none; }
    .form-input-eye {
      position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
      color: var(--muted-2); font-size: 17px; cursor: pointer; background: none; border: none; padding: 0;
      transition: color 0.2s;
    }
    .form-input-eye:hover { color: var(--primary); }
    .form-input {
      width: 100%;
      padding: 12px 42px 12px 42px;
      border: 1.5px solid var(--border);
      border-radius: 12px;
      font-size: 14px;
      outline: none;
      transition: all 0.25s;
      font-family: inherit;
      color: var(--ink);
      background: var(--surface);
    }
    .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(37,99,235,0.1); }
    .form-extras { display: flex; justify-content: space-between; align-items: center; font-size: 13px; margin-bottom: 22px; }
    .form-check { display: flex; align-items: center; gap: 7px; cursor: pointer; color: var(--muted); }
    .form-check input { accent-color: var(--primary); width: 15px; height: 15px; }
    .form-forgot { color: var(--primary); font-weight: 600; text-decoration: none; font-size: 13px; }
    .form-forgot:hover { text-decoration: underline; }
    .btn-submit {
      width: 100%;
      padding: 14px;
      background: var(--primary);
      color: #fff;
      border: none;
      border-radius: 12px;
      font-size: 15px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.25s var(--ease-spring);
      font-family: inherit;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      position: relative;
      overflow: hidden;
    }
    .btn-submit:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(37,99,235,0.35); }
    .btn-submit:active { transform: scale(0.98); }
    .divider { display: flex; align-items: center; gap: 14px; margin: 20px 0; }
    .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
    .divider span { font-size: 12px; color: var(--muted-2); white-space: nowrap; }
    .btn-google {
      width: 100%;
      padding: 12px 16px;
      border: 1.5px solid var(--border);
      border-radius: 12px;
      background: var(--surface);
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      transition: all 0.25s;
      font-family: inherit;
      color: var(--ink);
      text-decoration: none;
      box-shadow: var(--shadow-sm);
    }
    .btn-google:hover { border-color: #dadce0; background: #f8f9fa; transform: translateY(-1px); box-shadow: var(--shadow-md); }
    .login-footer { text-align: center; margin-top: 24px; font-size: 13px; color: var(--muted); }
    .login-footer a { color: var(--primary); font-weight: 700; text-decoration: none; cursor: pointer; }
    .login-footer a:hover { text-decoration: underline; }

    /* ─── PAYMENT PAGE ─── */
    .payment-shell { background: #f8fafc; border-radius: var(--radius-2xl); padding: 28px; }
    .breadcrumb { display: flex; gap: 8px; align-items: center; font-size: 13px; color: var(--muted-2); margin-bottom: 20px; }
    .breadcrumb i { font-size: 14px; }
    .breadcrumb b { color: var(--primary); font-weight: 600; }
    .payment-topbar { display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 28px; }
    .payment-topbar h1 { font-family: 'Poppins', sans-serif; font-size: 22px; color: var(--ink); margin-bottom: 4px; }
    .payment-topbar p { color: var(--muted); font-size: 14px; }
    .secure-badge {
      display: flex;
      align-items: center;
      gap: 8px;
      background: var(--surface);
      padding: 12px 18px;
      border-radius: 14px;
      border: 1px solid var(--border);
      color: var(--muted);
      font-size: 13px;
      font-weight: 500;
      white-space: nowrap;
    }
    .secure-badge i { color: #10b981; font-size: 18px; }
    .payment-layout { display: grid; grid-template-columns: 340px 1fr; gap: 22px; align-items: start; }
    .payment-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: 22px; padding: 24px; }
    .payment-card h3 { font-family: 'Poppins', sans-serif; font-size: 18px; color: var(--ink); margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }
    .payment-card h3 i { color: var(--primary); }
    .summary-book {
      display: flex;
      gap: 14px;
      padding: 16px 0 20px;
      border-bottom: 1px solid #eef2f7;
      margin-bottom: 18px;
    }
    .summary-book img { width: 68px; height: 98px; border-radius: 12px; object-fit: cover; box-shadow: var(--shadow-md); }
    .summary-book-info { flex: 1; min-width: 0; }
    .summary-book-info h4 { color: var(--ink); font-size: 16px; font-weight: 700; margin-bottom: 4px; }
    .summary-book-info p { color: var(--muted); font-size: 13px; margin-bottom: 3px; }
    .summary-book-info .s-tag {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      background: rgba(37,99,235,0.08);
      color: var(--primary);
      font-size: 11px;
      font-weight: 600;
      padding: 2px 8px;
      border-radius: 999px;
      margin-top: 5px;
    }
    .summary-price { font-weight: 700; font-size: 18px; color: var(--ink); white-space: nowrap; align-self: center; }
    .payment-row { display: flex; justify-content: space-between; font-size: 14px; color: var(--muted); margin-bottom: 12px; }
    .payment-total { margin-top: 18px; padding-top: 16px; border-top: 1px dashed #e2e8f0; display: flex; justify-content: space-between; align-items: center; font-weight: 700; font-size: 16px; }
    .payment-total strong { color: var(--primary); font-size: 26px; font-family: 'Poppins', sans-serif; }
    .safe-box {
      margin-top: 18px;
      padding: 16px;
      border-radius: 14px;
      background: linear-gradient(135deg, #f0fdf4, #dcfce7);
      color: #166534;
      font-size: 13px;
      line-height: 1.7;
      border: 1px solid #bbf7d0;
      display: flex;
      gap: 10px;
      align-items: flex-start;
    }
    .safe-box i { font-size: 20px; flex-shrink: 0; margin-top: 1px; }
    .method-tabs { display: grid; grid-template-columns: 1fr 1fr; margin: 18px 0 22px; border: 1.5px solid #dbeafe; border-radius: 16px; overflow: hidden; }
    .method-tab { padding: 14px; text-align: center; font-weight: 600; font-size: 14px; color: var(--muted); background: var(--surface); cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 7px; }
    .method-tab.active { color: var(--primary); background: #f0f7ff; box-shadow: inset 0 0 0 2px #93c5fd; }
    .method-panel { display: none; }
    .method-panel.active { display: block; animation: fadeSlideUp 0.3s var(--ease-smooth); }
    .payment-note { text-align: center; color: var(--muted); font-size: 14px; line-height: 1.7; margin-bottom: 18px; }
    .wallet-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 22px; }
    .wallet-item {
      border: 1.5px solid var(--border);
      border-radius: 12px;
      padding: 10px;
      text-align: center;
      font-weight: 700;
      font-size: 13px;
      background: var(--surface);
      cursor: pointer;
      transition: all 0.2s var(--ease-spring);
      min-height: 52px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .wallet-item:hover { transform: translateY(-2px); border-color: rgba(37,99,235,0.3); box-shadow: var(--shadow-sm); }
    .wallet-item.active { color: var(--primary); background: #eff6ff; border-color: #60a5fa; box-shadow: 0 0 0 3px rgba(147,197,253,0.4); }
    .wallet-label { display: inline-flex; align-items: center; justify-content: center; width: 100%; font-size: 13px; }
    .wallet-item[data-wallet="GoPay"] .wallet-label { color: #00aed6; }
    .wallet-item[data-wallet="OVO"] .wallet-label { color: #4c3494; }
    .wallet-item[data-wallet="DANA"] .wallet-label { color: #108ee9; }
    .wallet-item[data-wallet="LinkAja!"] .wallet-label { color: #e11d48; }
    .wallet-item[data-wallet="ShopeePay"] .wallet-label { color: #f97316; }
    .wallet-item[data-wallet="BCA mobile"] .wallet-label { color: #2563eb; }
    .wallet-item[data-wallet="Livin' by Mandiri"] .wallet-label { color: #0ea5e9; }
    .wallet-item[data-wallet="Permata Mobile X"] .wallet-label { color: #16a34a; }
    .qr-section { display: grid; grid-template-columns: 210px 1fr; gap: 22px; align-items: center; margin-bottom: 22px; }
    .qr-box { width: 210px; min-height: 210px; border-radius: 20px; padding: 14px; background: var(--surface); border: 1.5px solid var(--border); box-shadow: var(--shadow-md); display: flex; align-items: center; justify-content: center; }
    .qris-shell { width: 100%; border-radius: 16px; background: #f8fafc; padding: 12px; box-shadow: inset 0 0 0 1px #e2e8f0; }
    .qris-topmark { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; color: var(--muted); font-size: 11px; font-weight: 700; letter-spacing: 1px; }
    .qris-topmark strong { color: var(--ink); font-size: 12px; }
    #qris-code { width: 156px; height: 156px; margin: 0 auto; background: #fff; padding: 6px; border-radius: 8px; box-shadow: inset 0 0 0 1px #e5e7eb; }
    #qris-code img, #qris-code canvas { width: 100% !important; height: 100% !important; display: block; }
    .qr-info h4 { font-family: 'Poppins', sans-serif; font-size: 28px; color: var(--ink); margin-bottom: 8px; }
    .qr-info > p { color: var(--muted); font-size: 14px; line-height: 1.7; }
    .qr-chip { display: inline-flex; align-items: center; gap: 7px; margin-top: 12px; padding: 8px 14px; border-radius: 999px; background: rgba(37,99,235,0.08); color: var(--primary); font-size: 13px; font-weight: 600; }
    .qris-brand { margin-top: 16px; display: flex; align-items: center; gap: 10px; }
    .qris-brand-badge { width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, #111827, #334155); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 11px; flex-shrink: 0; }
    .qris-brand p { margin: 0; color: var(--muted); font-size: 13px; line-height: 1.6; }
    .payment-footer-stats { display: grid; grid-template-columns: 1fr 200px; gap: 18px; align-items: end; margin-bottom: 16px; }
    .pf-total p { font-size: 13px; color: var(--muted); margin-bottom: 4px; }
    .pf-total strong { display: block; color: var(--primary); font-family: 'Poppins', sans-serif; font-size: 26px; font-weight: 700; }
    .deadline-box { background: #f8fafc; border-radius: 14px; padding: 14px 16px; border: 1.5px solid var(--border); }
    .deadline-box b { display: block; font-size: 12px; color: var(--muted); margin-bottom: 6px; display: flex; align-items: center; gap: 5px; }
    .deadline-box span { color: var(--primary); font-family: 'Poppins', sans-serif; font-size: 26px; font-weight: 700; }
    .payment-alert { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; border-radius: 14px; padding: 14px 16px; margin-bottom: 14px; line-height: 1.6; font-size: 13px; display: flex; gap: 10px; align-items: flex-start; }
    .payment-alert i { font-size: 18px; flex-shrink: 0; margin-top: 1px; color: #f59e0b; }
    .btn-pay {
      width: 100%;
      border: none;
      border-radius: 14px;
      padding: 16px;
      background: linear-gradient(135deg, #3b82f6, #6366f1);
      color: #fff;
      font-size: 16px;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 10px 28px rgba(37,99,235,0.3);
      font-family: inherit;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 9px;
      transition: all 0.3s var(--ease-spring);
    }
    .btn-pay:hover { transform: translateY(-2px); box-shadow: 0 16px 36px rgba(37,99,235,0.4); }
    .payment-helper { margin-top: 12px; color: var(--muted-2); font-size: 12px; text-align: center; display: flex; align-items: center; justify-content: center; gap: 5px; }
    .va-list { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
    .va-item { border: 1.5px solid var(--border); border-radius: 14px; padding: 14px; background: var(--surface); cursor: pointer; transition: all 0.2s; }
    .va-item.active { border-color: #60a5fa; box-shadow: 0 0 0 3px rgba(147,197,253,0.35); background: #f8fbff; }
    .va-item b { display: block; color: var(--ink); margin-bottom: 5px; font-size: 14px; }
    .va-item span { color: var(--muted); font-size: 12px; line-height: 1.5; }
    .va-detail { border: 1.5px solid var(--border); border-radius: 16px; padding: 18px; background: #f8fafc; margin-bottom: 16px; }
    .va-code-box { display: flex; justify-content: space-between; align-items: center; gap: 14px; flex-wrap: wrap; margin-top: 12px; padding: 14px 16px; border-radius: 12px; background: var(--surface); border: 1.5px dashed #cbd5e1; }
    .va-code-box strong { font-family: 'Poppins', sans-serif; font-size: 24px; letter-spacing: 2px; color: var(--primary); }
    .btn-copy { border: none; background: var(--primary); color: #fff; padding: 9px 16px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13px; display: flex; align-items: center; gap: 6px; transition: all 0.2s; font-family: inherit; }
    .btn-copy:hover { background: var(--primary-dark); transform: translateY(-1px); }

    /* ─── OWNED BOOK PAGE ─── */
    .owned-shell { background: var(--surface); border-radius: var(--radius-2xl); padding: 28px; box-shadow: var(--shadow-sm); border: 1px solid var(--border); }
    .owned-layout { display: grid; grid-template-columns: 280px 1fr; gap: 32px; align-items: start; }
    .owned-cover-wrap { border-radius: 18px; overflow: hidden; box-shadow: var(--shadow-lg); margin-bottom: 16px; }
    .owned-cover-wrap img { width: 100%; display: block; transition: transform 0.4s var(--ease-smooth); }
    .owned-cover-wrap:hover img { transform: scale(1.03); }
    .owned-fav-btn {
      width: 100%;
      background: rgba(37,99,235,0.06);
      border: 1.5px solid rgba(37,99,235,0.15);
      border-radius: 14px;
      padding: 14px 16px;
      cursor: pointer;
      transition: all 0.2s;
      text-align: left;
      font-family: inherit;
    }
    .owned-fav-btn:hover { background: rgba(239,68,68,0.06); border-color: rgba(239,68,68,0.25); }
    .owned-fav-btn b { display: flex; align-items: center; gap: 7px; color: var(--ink); font-size: 14px; font-weight: 600; margin-bottom: 4px; }
    .owned-fav-btn b i { color: #ef4444; }
    .owned-fav-btn p { color: var(--muted); font-size: 12px; }
    .owned-title { font-family: 'Poppins', sans-serif; font-size: 36px; font-weight: 700; color: var(--ink); margin-bottom: 8px; line-height: 1.15; }
    .owned-author { color: var(--primary); font-weight: 600; margin-bottom: 12px; font-size: 15px; display: flex; align-items: center; gap: 6px; }
    .owned-meta { display: flex; gap: 14px; flex-wrap: wrap; color: var(--muted); font-size: 13px; margin-bottom: 14px; }
    .owned-meta span { display: flex; align-items: center; gap: 5px; }
    .owned-meta .star { color: #f59e0b; }
    .owned-tags { display: flex; gap: 8px; margin-bottom: 18px; flex-wrap: wrap; }
    .owned-tag { background: rgba(37,99,235,0.08); color: var(--primary); padding: 5px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; }
    .owned-desc { color: var(--muted); line-height: 1.85; margin-bottom: 22px; font-size: 14px; }
    .owned-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
    .owned-stat {
      color: var(--muted);
      font-size: 12px;
      background: #f8fafc;
      border: 1.5px solid var(--border);
      border-radius: 14px;
      padding: 14px;
      transition: border-color 0.2s;
    }
    .owned-stat:hover { border-color: rgba(37,99,235,0.25); }
    .owned-stat i { font-size: 18px; color: var(--primary); margin-bottom: 6px; display: block; }
    .owned-stat b { display: block; color: var(--ink); margin-top: 5px; font-size: 13px; font-weight: 600; }
    .owned-status {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 18px;
      flex-wrap: wrap;
      background: linear-gradient(135deg, #f0fdf4, #dcfce7);
      border: 1.5px solid #86efac;
      border-radius: 18px;
      padding: 18px 22px;
      margin-bottom: 22px;
    }
    .owned-status h3 { color: #166534; font-family: 'Poppins', sans-serif; font-size: 18px; margin-bottom: 5px; display: flex; align-items: center; gap: 8px; }
    .owned-status p { color: #4ade80; color: #166534; opacity: 0.8; font-size: 13px; line-height: 1.7; }
    .owned-actions { display: flex; gap: 10px; flex-wrap: wrap; }
    .owned-btn-primary {
      border-radius: 14px;
      padding: 12px 22px;
      font-weight: 700;
      cursor: pointer;
      border: none;
      font-size: 14px;
      background: linear-gradient(135deg, #3b82f6, #6366f1);
      color: #fff;
      box-shadow: 0 8px 20px rgba(37,99,235,0.28);
      transition: all 0.25s var(--ease-spring);
      font-family: inherit;
      display: flex;
      align-items: center;
      gap: 7px;
    }
    .owned-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(37,99,235,0.38); }
    .owned-btn-secondary {
      border-radius: 14px;
      padding: 12px 22px;
      font-weight: 700;
      cursor: pointer;
      background: var(--surface);
      color: var(--ink);
      border: 1.5px solid var(--border);
      font-size: 14px;
      transition: all 0.2s;
      font-family: inherit;
      display: flex;
      align-items: center;
      gap: 7px;
    }
    .owned-btn-secondary:hover { border-color: rgba(37,99,235,0.3); color: var(--primary); }
    .owned-tabs { display: flex; gap: 24px; border-bottom: 1.5px solid var(--border); margin-bottom: 0; overflow-x: auto; }
    .owned-tab { padding: 14px 0; color: var(--muted); font-weight: 600; white-space: nowrap; cursor: pointer; background: none; border: none; font-size: 14px; font-family: inherit; transition: color 0.2s; border-bottom: 2px solid transparent; margin-bottom: -1.5px; }
    .owned-tab.active { color: var(--primary); border-bottom-color: var(--primary); }
    .owned-panel { border: 1.5px solid var(--border); border-top: none; border-radius: 0 0 16px 16px; padding: 20px; color: var(--muted); line-height: 1.85; margin-bottom: 22px; font-size: 14px; }
    .owned-tab-panel { display: none; }
    .owned-tab-panel.active { display: block; animation: fadeSlideUp 0.3s var(--ease-smooth); }
    .owned-bottom { display: grid; grid-template-columns: 280px 1fr; gap: 20px; }
    .owned-review-card, .owned-recommend-card { border: 1.5px solid var(--border); border-radius: 20px; padding: 22px; background: var(--surface); }
    .owned-review-card h3, .owned-recommend-card h3 { color: var(--ink); font-family: 'Poppins', sans-serif; margin-bottom: 16px; font-size: 18px; }
    .review-score { font-family: 'Poppins', sans-serif; font-size: 52px; font-weight: 700; color: var(--ink); line-height: 1; margin-bottom: 8px; }
    .review-stars { color: #f59e0b; margin-bottom: 8px; font-size: 18px; }
    .review-count { color: var(--muted); font-size: 13px; }
    .review-sample { display: flex; gap: 12px; margin-top: 18px; align-items: flex-start; }
    .review-sample img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
    .review-sample-text { color: var(--muted); font-size: 13px; line-height: 1.7; }
    .review-sample-text b { display: block; color: var(--ink); font-weight: 600; margin-bottom: 3px; }
    .recommend-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 14px; }
    .recommend-item { cursor: pointer; border-radius: 14px; padding: 6px; transition: all 0.25s var(--ease-smooth); }
    .recommend-item:hover { background: #f8fafc; transform: translateY(-4px); box-shadow: var(--shadow-sm); }
    .recommend-cover { width: 100%; height: 140px; border-radius: 12px; margin-bottom: 9px; box-shadow: var(--shadow-sm); position: relative; overflow: hidden; padding: 10px; display: flex; align-items: flex-end; justify-content: flex-start; isolation: isolate; }
    .recommend-cover::after { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, transparent, rgba(0,0,0,0.1)); pointer-events: none; z-index: 0; }
    .recommend-cover span { display: block; color: #fff; font-weight: 700; line-height: 1; text-shadow: 0 2px 8px rgba(0,0,0,0.25); position: relative; z-index: 1; }
    .cover-title { font-weight: 700; line-height: 1.08; letter-spacing: -0.3px; }
    .cover-subtitle { position: relative; z-index: 1; font-size: 9px; line-height: 1.3; opacity: 0.85; text-transform: uppercase; letter-spacing: 1px; }
    .cover-dune { background: linear-gradient(180deg, #f0c27b 0%, #c97b35 54%, #5b2d12 100%); align-items: stretch; justify-content: space-between; flex-direction: column; }
    .cover-dune .cover-title { font-size: 30px; align-self: flex-start; letter-spacing: 1px; }
    .cover-alchemist { background: linear-gradient(180deg, #143a5c 0%, #255f85 52%, #e4b55c 100%); justify-content: center; align-items: center; flex-direction: column; gap: 6px; }
    .cover-alchemist .cover-title { color: #f8fafc; font-size: 22px; font-family: Georgia, serif; font-weight: 500; }
    .cover-alchemist .cover-subtitle { color: #fef3c7; opacity: 0.9; text-align: center; text-transform: none; letter-spacing: 0; }
    .cover-midnight { background: linear-gradient(180deg, #0f172a 0%, #243b53 52%, #1d4ed8 100%); justify-content: center; align-items: center; flex-direction: column; gap: 5px; }
    .cover-midnight .cover-title { color: #e0e7ff; font-size: 21px; line-height: 1.2; text-align: center; }
    .cover-midnight .cover-subtitle { color: #bfdbfe; text-align: center; opacity: 0.9; }
    .cover-ikigai { background: linear-gradient(180deg, #fff8e7 0%, #f6d365 100%); justify-content: center; align-items: center; flex-direction: column; }
    .cover-ikigai .cover-title { font-size: 28px; color: #1f2937; text-shadow: none; }
    .cover-ikigai .cover-subtitle { color: #92400e; opacity: 0.9; margin-top: 6px; text-transform: none; letter-spacing: 0; }
    .cover-psychology { background: linear-gradient(180deg, #f7e7c6 0%, #d6b47d 42%, #705437 100%); flex-direction: column; justify-content: flex-end; align-items: flex-start; }
    .cover-psychology .cover-title { font-size: 16px; line-height: 1.12; color: #111827; text-shadow: none; }
    .cover-psychology .cover-subtitle { color: #3f3f46; opacity: 0.85; margin-top: 4px; text-transform: none; letter-spacing: 0; }
    .recommend-item b { display: block; color: var(--ink); font-size: 13px; font-weight: 600; margin-bottom: 2px; }
    .recommend-item span { display: block; color: var(--muted); font-size: 11px; line-height: 1.5; }

    /* ─── BOTTOM NAV ─── */
    .bottom-nav {
      position: fixed;
      bottom: 0; left: 0; right: 0;
      background: rgba(255,255,255,0.88);
      backdrop-filter: blur(20px) saturate(1.8);
      -webkit-backdrop-filter: blur(20px) saturate(1.8);
      display: flex;
      justify-content: space-around;
      align-items: center;
      padding: 10px 0 max(10px, env(safe-area-inset-bottom));
      border-top: 1px solid rgba(226,232,240,0.8);
      box-shadow: 0 -8px 24px rgba(15,23,42,0.06);
      z-index: 200;
    }
    .nav-item {
      text-align: center;
      color: var(--muted-2);
      cursor: pointer;
      font-size: 11px;
      font-weight: 500;
      flex: 1;
      padding: 5px 0;
      transition: color 0.2s;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 4px;
    }
    .nav-item i {
      font-size: 22px;
      transition: transform 0.3s var(--ease-spring);
    }
    .nav-item.active-nav { color: var(--primary); font-weight: 600; }
    .nav-item.active-nav i { transform: scale(1.15); }

    /* ─── MODAL ─── */
    .modal { display: none; position: fixed; z-index: 300; inset: 0; background: rgba(15,23,42,0.5); backdrop-filter: blur(6px); }
    .modal-box {
      background: var(--surface);
      margin: 12% auto;
      padding: 28px;
      border-radius: 24px;
      width: 90%;
      max-width: 420px;
      text-align: center;
      box-shadow: var(--shadow-lg);
      animation: fadeSlideUp 0.35s var(--ease-spring);
    }
    .modal-close {
      float: right;
      width: 32px; height: 32px;
      border-radius: 10px;
      border: none;
      background: #f1f5f9;
      color: var(--muted);
      font-size: 18px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s;
      font-family: inherit;
      line-height: 1;
    }
    .modal-close:hover { background: #e2e8f0; color: var(--ink); }
    .modal-title { font-family: 'Poppins', sans-serif; font-size: 20px; color: var(--ink); margin: 10px 0 22px; clear: both; }
    .modal-btns { display: flex; flex-direction: column; gap: 12px; }
    .modal-account {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 14px 16px;
      border-radius: 16px;
      border: 1.5px solid var(--border);
      background: #f8fafc;
      cursor: pointer;
      text-align: left;
      transition: all 0.2s;
    }
    .modal-account:hover { background: #eff6ff; border-color: rgba(37,99,235,0.3); transform: translateY(-1px); box-shadow: var(--shadow-sm); }
    .modal-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(37,99,235,0.15); }
    .modal-account-info strong { display: block; color: var(--ink); font-size: 15px; font-weight: 600; }
    .modal-account-info span { display: block; color: var(--muted); font-size: 13px; }
    .modal-other {
      padding: 12px;
      border: 1.5px solid var(--border);
      background: var(--surface);
      color: var(--primary);
      border-radius: 12px;
      cursor: pointer;
      font-size: 14px;
      font-weight: 600;
      font-family: inherit;
      transition: all 0.2s;
    }
    .modal-other:hover { background: rgba(37,99,235,0.05); }

    /* ─── NOTIFICATION TOAST ─── */
    .toast {
      position: fixed;
      bottom: 100px; left: 50%; transform: translateX(-50%) translateY(20px);
      background: var(--ink);
      color: #fff;
      padding: 12px 22px;
      border-radius: 999px;
      font-size: 14px;
      font-weight: 500;
      box-shadow: var(--shadow-lg);
      opacity: 0;
      transition: all 0.3s var(--ease-spring);
      z-index: 500;
      white-space: nowrap;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

    /* ─── UTILITY ─── */
    .btn-back {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 20px;
      border: 1.5px solid var(--border);
      border-radius: 12px;
      background: var(--surface);
      color: var(--muted);
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s;
      font-family: inherit;
    }
    .btn-back:hover { color: var(--ink); border-color: rgba(37,99,235,0.3); }
    .btn-see-all {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 9px 20px;
      border: 1.5px solid var(--border);
      border-radius: 12px;
      background: var(--surface);
      color: var(--primary);
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s;
      font-family: inherit;
      margin-top: 24px;
    }
    .btn-see-all:hover { background: rgba(37,99,235,0.05); border-color: rgba(37,99,235,0.3); }

    /* ─── GOOGLE OAUTH NOTE ─── */
    .oauth-note {
      background: #fffbeb;
      border: 1px solid #fde68a;
      border-radius: 12px;
      padding: 12px 16px;
      font-size: 13px;
      color: #92400e;
      margin-top: 14px;
      display: flex;
      gap: 8px;
      align-items: flex-start;
      line-height: 1.6;
    }
    .oauth-note i { flex-shrink: 0; margin-top: 1px; }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 960px) {
      .hero { flex-direction: column; padding: 28px 22px; min-height: auto; }
      .hero-text { max-width: 100%; }
      .hero-title { font-size: 28px; }
      .books-grid, .category-grid { grid-template-columns: repeat(3, 1fr); }
      .owned-layout, .owned-bottom, .payment-layout, .payment-footer-stats, .qr-section { grid-template-columns: 1fr; }
      .reader-controls { display: grid; }
      .payment-topbar { flex-direction: column; align-items: flex-start; }
      .wallet-grid { grid-template-columns: repeat(2, 1fr); }
      .owned-stats, .recommend-grid { grid-template-columns: repeat(2, 1fr); }
      .va-list { grid-template-columns: 1fr; }
      .qr-box { margin: 0 auto; }
      .owned-title { font-size: 28px; }
      .detail-bottom { grid-template-columns: 1fr; }
      .rec-grid { grid-template-columns: repeat(3, 1fr); }
      .detail-shell { flex-direction: column; }
      .detail-left { width: 100%; max-width: 220px; }
    }
    @media (max-width: 640px) {
      .books-grid, .category-grid, .fav-grid { grid-template-columns: repeat(2, 1fr); }
      .hero-visual { display: none; }
      .hero-title { font-size: 24px; }
      .login-shell { flex-direction: column; }
      .login-left { min-height: 260px; }
      .login-left-overlay { display: none; }
    }
  </style>
</head>
<body>

<div class="wrap">
  <!-- NAVBAR -->
  <nav class="navbar">
    <div class="logo" onclick="showPage('home-page')">
      <div class="logo-icon"><i class="ph ph-books"></i></div>
      EBook
    </div>
    <div class="nav-search-wrap">
      <i class="ph ph-magnifying-glass nav-search-icon"></i>
      <input type="text" class="nav-search-input" placeholder="Cari buku, penulis, atau kategori..." id="navSearchInput" oninput="filterHomeBooks(this.value)">
    </div>
    <div class="nav-links">
      <button class="nav-link active" onclick="showPage('home-page')">Beranda</button>
      <button class="nav-link" onclick="showPage('cat-page')">Kategori</button>
      <button class="nav-link" onclick="showPage('fav-page')">
        <i class="ph ph-heart" style="font-size:15px;"></i> Favorit
      </button>
    </div>
    @guest
      <button class="btn-login" onclick="showPage('login-page')">
        <i class="ph ph-user-circle" style="font-size:18px;"></i>
        Login
      </button>
    @endguest
    @auth
      <div style="display:flex; align-items:center; gap:12px;">
        <span style="font-weight:700; color:#0f172a; white-space:nowrap;">Halo, {{ Auth::user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
          @csrf
          <button type="submit" class="btn-login" style="background:#ef4444; color:#fff;">Logout</button>
        </form>
      </div>
    @endauth
  </nav>

  @if(session('success'))
    <div style="margin:20px 0; padding:16px 20px; border-radius:18px; background:#dcfce7; color:#166534; border:1px solid #bbf7d0; box-shadow:0 12px 24px rgba(16,185,129,0.08);">
      {{ session('success') }}
    </div>
  @endif

  <!-- ══════════════ HOME PAGE ══════════════ -->
  <div id="home-page" class="page active">
    <section class="hero">
      <div class="hero-orb hero-orb-1"></div>
      <div class="hero-orb hero-orb-2"></div>
      <div class="hero-orb hero-orb-3"></div>

      <div class="hero-text">
        <div class="hero-badge">
          <i class="ph ph-lightning-fill"></i>
          Ribuan buku menantimu
        </div>
        <h1 class="hero-title">
          Temukan E-Book<br>
          <span class="hero-title-accent">Favoritmu</span>
        </h1>
        <p class="hero-sub">Baca kapan saja, di mana saja.<br>Koleksi premium dari penulis terbaik dunia.</p>
        <button class="hero-cta" onclick="showPage('cat-page')">
          <i class="ph ph-compass"></i>
          Jelajahi Buku
          <i class="ph ph-arrow-right"></i>
        </button>
      </div>

      <div class="hero-visual" aria-hidden="true">
        <div class="hero-books">
          <div class="hero-book"></div>
          <div class="hero-book"></div>
          <div class="hero-book"></div>
        </div>
        <div class="hero-device">
          <div class="hero-screen">
            <div class="hero-screen-title"></div>
            <div class="hero-screen-text">
              <div class="hero-screen-line l"></div>
              <div class="hero-screen-line l"></div>
              <div class="hero-screen-line m"></div>
              <div class="hero-screen-line l"></div>
              <div class="hero-screen-line m"></div>
              <div class="hero-screen-line l"></div>
              <div class="hero-screen-line s"></div>
              <div class="hero-screen-line xs"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- KATEGORI POPULER -->
    <div class="section-head" style="margin-bottom:14px;">
      <div class="section-title" style="font-size:18px;">Kategori Populer</div>
      <div class="section-see-all" onclick="showPage('cat-page')">Lihat semua <i class="ph ph-arrow-right"></i></div>
    </div>
    <div class="home-cat-pills">
      <button class="home-cat-pill active" onclick="filterByCategory('', this)">Semua</button>
      <button class="home-cat-pill" onclick="filterByCategory('Novel', this)">
        <i class="ph ph-book"></i> Novel
      </button>
      <button class="home-cat-pill" onclick="filterByCategory('Teknologi', this)">
        <i class="ph ph-cpu"></i> Teknologi
      </button>
      <button class="home-cat-pill" onclick="filterByCategory('Bisnis', this)">
        <i class="ph ph-briefcase"></i> Bisnis
      </button>
      <button class="home-cat-pill" onclick="filterByCategory('Pendidikan', this)">
        <i class="ph ph-graduation-cap"></i> Pendidikan
      </button>
      <button class="home-cat-pill" onclick="filterByCategory('Pengembangan Diri', this)">
        <i class="ph ph-trend-up"></i> Pengembangan Diri
      </button>
      <button class="home-cat-pill" onclick="filterByCategory('Sejarah', this)">
        <i class="ph ph-clock-counter-clockwise"></i> Sejarah
      </button>
    </div>

    <div class="section-head" style="margin-top:28px;">
      <div class="section-title">
        <i class="ph ph-sparkle"></i>
        Rekomendasi Buku
      </div>
      <div class="section-see-all">Lihat Semua <i class="ph ph-arrow-right"></i></div>
    </div>

    <div class="books-grid" id="home-books-grid">
      <div class="book-card" data-category="Novel" data-title="laut bercerita" data-author="leila s chudori">
        <div class="book-cover-wrap">
          <img src="{{ asset('laut-bercerita.jpeg') }}" alt="Laut Bercerita">
        </div>
        <div class="book-title">Laut Bercerita</div>
        <div class="book-author">Leila S. Chudori</div>
        <div class="book-meta-row">
          <div class="rating"><i class="ph-fill ph-star"></i> 4.8 · Novel</div>
        </div>
        <button onclick="openBookDetail('laut-bercerita')" class="btn-detail"><span>Lihat Detail</span><i class="ph ph-arrow-right"></i></button>
      </div>
      <div class="book-card" data-category="Pengembangan Diri" data-title="atomic habits" data-author="james clear">
        <div class="book-cover-wrap">
          <span class="book-badge-free"><i class="ph ph-check-circle"></i> Gratis</span>
          <img src="https://images-na.ssl-images-amazon.com/images/I/91bYsX41DVL.jpg" alt="Atomic Habits">
        </div>
        <div class="book-title">Atomic Habits</div>
        <div class="book-author">James Clear</div>
        <div class="book-meta-row">
          <div class="rating"><i class="ph-fill ph-star"></i> 4.9 · Pengembangan Diri</div>
        </div>
        <button onclick="openBookDetail('atomic-habits')" class="btn-detail"><span>Lihat Detail</span><i class="ph ph-arrow-right"></i></button>
      </div>
      <div class="book-card" data-category="Sejarah" data-title="sapiens" data-author="yuval noah harari">
        <div class="book-cover-wrap">
          <img src="https://images-na.ssl-images-amazon.com/images/I/713jIoMO3UL.jpg" alt="Sapiens">
        </div>
        <div class="book-title">Sapiens</div>
        <div class="book-author">Yuval Noah Harari</div>
        <div class="book-meta-row">
          <div class="rating"><i class="ph-fill ph-star"></i> 4.7 · Sejarah</div>
        </div>
        <button onclick="openBookDetail('sapiens')" class="btn-detail"><span>Lihat Detail</span><i class="ph ph-arrow-right"></i></button>
      </div>
      <div class="book-card" data-category="Bisnis" data-title="psychology of money" data-author="morgan housel">
        <div class="book-cover-wrap">
          <span class="book-badge-free"><i class="ph ph-check-circle"></i> Gratis</span>
          <img src="https://images-na.ssl-images-amazon.com/images/I/71g2ednj0JL.jpg" alt="Psychology of Money">
        </div>
        <div class="book-title">Psychology of Money</div>
        <div class="book-author">Morgan Housel</div>
        <div class="book-meta-row">
          <div class="rating"><i class="ph-fill ph-star"></i> 4.8 · Bisnis</div>
        </div>
        <button onclick="openBookDetail('psychology-of-money')" class="btn-detail"><span>Lihat Detail</span><i class="ph ph-arrow-right"></i></button>
      </div>
      <div class="book-card" data-category="Teknologi" data-title="clean code" data-author="robert c martin">
        <div class="book-cover-wrap">
          <img src="https://images-na.ssl-images-amazon.com/images/I/41SH-SvWPxL.jpg" alt="Clean Code">
        </div>
        <div class="book-title">Clean Code</div>
        <div class="book-author">Robert C. Martin</div>
        <div class="book-meta-row">
          <div class="rating"><i class="ph-fill ph-star"></i> 4.6 · Teknologi</div>
        </div>
        <button onclick="openBookDetail('clean-code')" class="btn-detail"><span>Lihat Detail</span><i class="ph ph-arrow-right"></i></button>
      </div>
      <div class="book-card" data-category="Pengembangan Diri" data-title="mindset" data-author="carol s dweck">
        <div class="book-cover-wrap">
          <span class="book-badge-free"><i class="ph ph-check-circle"></i> Gratis</span>
          <img src="{{ asset('mindset.jpeg') }}" alt="Mindset">
        </div>
        <div class="book-title">Mindset</div>
        <div class="book-author">Carol S. Dweck</div>
        <div class="book-meta-row">
          <div class="rating"><i class="ph-fill ph-star"></i> 4.7 · Pengembangan Diri</div>
        </div>
        <button onclick="openBookDetail('mindset')" class="btn-detail"><span>Lihat Detail</span><i class="ph ph-arrow-right"></i></button>
      </div>
    </div>
  </div>

  <!-- ══════════════ KATEGORI PAGE ══════════════ -->
  <div id="cat-page" class="page">
    <div class="section-head" style="margin-bottom:20px;">
      <div class="section-title"><i class="ph ph-squares-four"></i> Kategori</div>
    </div>
    <div class="search-wrap">
      <i class="ph ph-magnifying-glass search-icon"></i>
      <input type="text" class="search-full" placeholder="Cari buku, penulis, atau kategori...">
    </div>
    <div class="category-grid">
      <div class="cat-card bg-1"><span class="cat-icon"><i class="ph ph-books"></i></span><p>Fiksi</p></div>
      <div class="cat-card bg-2"><span class="cat-icon"><i class="ph ph-book-open"></i></span><p>Seri Novel</p></div>
      <div class="cat-card bg-3"><span class="cat-icon"><i class="ph ph-lightbulb"></i></span><p>Motivasi</p></div>
      <div class="cat-card bg-4"><span class="cat-icon"><i class="ph ph-chart-bar"></i></span><p>Bisnis</p></div>
      <div class="cat-card bg-5"><span class="cat-icon"><i class="ph ph-currency-dollar"></i></span><p>Ekonomi</p></div>
      <div class="cat-card bg-6"><span class="cat-icon"><i class="ph ph-brain"></i></span><p>Self Dev</p></div>
      <div class="cat-card bg-7"><span class="cat-icon"><i class="ph ph-cpu"></i></span><p>Teknologi</p></div>
      <div class="cat-card bg-8"><span class="cat-icon"><i class="ph ph-heart-pulse"></i></span><p>Kesehatan</p></div>
    </div>
  </div>

  <!-- ══════════════ FAVORIT PAGE ══════════════ -->
  <div id="fav-page" class="page">
    <!-- Guest state -->
    <div id="fav-guest">
      <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:60px 20px;text-align:center;">
        <div style="width:80px;height:80px;border-radius:50%;background:rgba(239,68,68,0.08);display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
          <i class="ph ph-heart" style="font-size:48px;color:#ef4444;"></i>
        </div>
        <h2 style="font-family:'Poppins',sans-serif;font-size:22px;font-weight:700;color:var(--ink);margin-bottom:8px;">Favorit Kosong</h2>
        <p style="color:var(--muted);font-size:14px;line-height:1.7;max-width:280px;margin-bottom:28px;">Login untuk menyimpan dan melihat daftar buku favorit Anda di sini.</p>
        <button class="hero-cta" onclick="showPage('login-page')" style="animation:none;">
          Masuk Sekarang
          <i class="ph ph-arrow-right"></i>
        </button>
      </div>
    </div>

    <!-- Logged-in state -->
    <div id="fav-logged" style="display:none;">
      <div class="fav-header">
        <div class="fav-heading"><i class="ph-fill ph-heart"></i> Favorit Saya</div>
        <button class="btn-manage">Kelola</button>
      </div>
      <div class="fav-count"><i class="ph ph-books"></i> 6 buku tersimpan</div>
      <div class="fav-grid">
        <div class="fav-card" onclick="openFavoriteBook('laut-bercerita')">
          <div class="fav-cover-wrap"><img src="{{ asset('laut-bercerita.jpeg') }}" alt="Laut Bercerita"></div>
          <div class="fav-title">Laut Bercerita</div><div class="fav-author">Leila S. Chudori</div>
        </div>
        <div class="fav-card" onclick="openFavoriteBook('atomic-habits')">
          <div class="fav-cover-wrap"><span class="book-badge-free" style="position:absolute;top:8px;left:8px;"><i class="ph ph-check-circle"></i> Gratis</span><img src="https://images-na.ssl-images-amazon.com/images/I/91bYsX41DVL.jpg" alt="Atomic Habits"></div>
          <div class="fav-title">Atomic Habits</div><div class="fav-author">James Clear</div>
        </div>
        <div class="fav-card" onclick="openFavoriteBook('sapiens')">
          <div class="fav-cover-wrap"><img src="https://images-na.ssl-images-amazon.com/images/I/713jIoMO3UL.jpg" alt="Sapiens"></div>
          <div class="fav-title">Sapiens</div><div class="fav-author">Yuval Noah Harari</div>
        </div>
        <div class="fav-card" onclick="openFavoriteBook('mindset')">
          <div class="fav-cover-wrap"><span class="book-badge-free" style="position:absolute;top:8px;left:8px;"><i class="ph ph-check-circle"></i> Gratis</span><img src="{{ asset('mindset.jpeg') }}" alt="Mindset"></div>
          <div class="fav-title">Mindset</div><div class="fav-author">Carol S. Dweck</div>
        </div>
        <div class="fav-card" onclick="openFavoriteBook('psychology-of-money')">
          <div class="fav-cover-wrap"><span class="book-badge-free" style="position:absolute;top:8px;left:8px;"><i class="ph ph-check-circle"></i> Gratis</span><img src="https://images-na.ssl-images-amazon.com/images/I/71g2ednj0JL.jpg" alt="Psychology of Money"></div>
          <div class="fav-title">Psychology of Money</div><div class="fav-author">Morgan Housel</div>
        </div>
        <div class="fav-card" onclick="openFavoriteBook('clean-code')">
          <div class="fav-cover-wrap"><img src="https://images-na.ssl-images-amazon.com/images/I/41SH-SvWPxL.jpg" alt="Clean Code"></div>
          <div class="fav-title">Clean Code</div><div class="fav-author">Robert C. Martin</div>
        </div>
      </div>
    </div>
  </div>

  <!-- ══════════════ RAK BUKU PAGE ══════════════ -->
  <div id="rak-page" class="page">
    <div class="page-header">
      <div class="page-heading">Rak Buku</div>
      <div class="page-actions">
        <div class="icon-btn"><i class="ph ph-bell"></i></div>
        <div class="icon-btn"><i class="ph ph-magnifying-glass"></i></div>
        <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=120&q=80" class="avatar-sm">
      </div>
    </div>
    <div class="rak-tabs">
      <button class="rak-tab">Disimpan</button>
      <button class="rak-tab active-tab">Sedang Dibaca <span class="tab-count">2</span></button>
    </div>
    <div class="sort-row"><i class="ph ph-funnel"></i> Urutkan: <b>Terbaru ▾</b></div>
    <div class="rak-list">
      <div class="rak-item" onclick="openRackBook('laut-bercerita', 1)">
        <img src="{{ asset('laut-bercerita.jpeg') }}" class="rak-img">
        <div class="rak-info">
          <h4>Laut Bercerita</h4>
          <div class="rak-author">Leila S. Chudori</div>
          <div class="progress-text"><b>40%</b> · 128 / 320 halaman</div>
          <div class="progress-track"><div class="progress-fill" style="width:40%"></div></div>
        </div>
        <button class="bookmark-btn"><i class="ph-fill ph-bookmark-simple"></i></button>
      </div>
      <div class="rak-item" onclick="openRackBook('mindset', 0)">
        <img src="{{ asset('mindset.jpeg') }}" class="rak-img">
        <div class="rak-info">
          <h4>Mindset: The New Psychology of Success</h4>
          <div class="rak-author">Carol S. Dweck, Ph.D.</div>
          <div class="progress-text"><b>20%</b> · 74 / 368 halaman</div>
          <div class="progress-track"><div class="progress-fill" style="width:20%"></div></div>
        </div>
        <button class="bookmark-btn"><i class="ph-fill ph-bookmark-simple"></i></button>
      </div>
    </div>
    <center style="margin-top:24px;">
      <button class="btn-see-all"><i class="ph ph-list"></i> Lihat semua</button>
    </center>
  </div>

  <!-- ══════════════ DETAIL PAGE ══════════════ -->
  <div id="detail-page" class="page">

    <!-- Breadcrumb -->
    <div class="detail-breadcrumb">
      <a onclick="showPage('home-page')">Beranda</a>
      <i class="ph ph-caret-right"></i>
      <a id="d-breadcrumb-cat" onclick="showPage('cat-page')">Novel</a>
      <i class="ph ph-caret-right"></i>
      <span id="d-breadcrumb-title">Laut Bercerita</span>
    </div>

    <!-- Main card -->
    <div class="detail-shell">
      <!-- Left: cover + fav -->
      <div class="detail-left">
        <img id="detail-book-cover" src="{{ asset('laut-bercerita.jpeg') }}" alt="Laut Bercerita" class="detail-cover">
        <button class="btn-fav" id="detail-fav-btn" onclick="toggleDetailFav(this)">
          <div class="btn-fav-top"><i class="ph ph-heart"></i> Tambah ke Favorit</div>
          <div class="btn-fav-sub" id="detail-fav-count">25,4 rb orang menyukai buku ini</div>
        </button>
      </div>

      <!-- Right: info -->
      <div class="detail-right">
        <div class="detail-title" id="detail-book-title">Laut Bercerita</div>

        <div class="detail-author-row">
          <i class="ph ph-user-circle"></i>
          <a id="detail-book-author">Leila S. Chudori</a>
        </div>

        <div class="detail-rating-row">
          <span class="stars">
            <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i>
            <i class="ph-fill ph-star"></i><i class="ph-fill ph-star-half"></i>
          </span>
          <span class="rating-score" id="d-rating">4.8</span>
          <span>(<span id="d-review-count">1.250</span> ulasan)</span>
          <span>·</span>
          <span><span id="d-readers">12,5 rb</span> pembaca</span>
        </div>

        <div class="detail-tags" id="detail-tags">
          <span class="detail-tag">Novel</span>
          <span class="detail-tag">Drama</span>
        </div>

        <p class="detail-desc-text" id="detail-book-description">Laut Bercerita adalah novel yang mengisahkan perjuangan, kehilangan, dan harapan di masa penuh gejolak. Sebuah cerita yang menyentuh hati tentang keberanian, cinta, dan arti pulang.</p>
        <p class="detail-desc-text" id="detail-book-description2" style="margin-top:-10px;">Di tengah arus sejarah yang deras, tokoh-tokohnya belajar untuk tetap bertahan, mencintai, dan mempercayai bahwa kebenaran akan selalu menemukan jalannya.</p>

        <!-- Info grid -->
        <div class="info-grid">
          <div class="info-item">
            <div class="info-item-icon"><i class="ph ph-translate"></i> Bahasa</div>
            <b id="d-lang">Indonesia</b>
          </div>
          <div class="info-item">
            <div class="info-item-icon"><i class="ph ph-file-text"></i> Halaman</div>
            <b id="d-pages">320</b>
          </div>
          <div class="info-item">
            <div class="info-item-icon"><i class="ph ph-calendar-blank"></i> Terbit</div>
            <b id="d-year">2017</b>
          </div>
          <div class="info-item">
            <div class="info-item-icon"><i class="ph ph-building-office"></i> Penerbit</div>
            <b id="d-pub">KPG</b>
          </div>
        </div>

        <!-- Owned bar (shown if purchased) -->
        <div class="detail-owned-bar" id="detail-owned-bar" style="display:none;">
          <div class="owned-info">
            <div class="detail-owned-title">
              <i class="ph-fill ph-check-circle"></i>
              Anda sudah memiliki buku ini
            </div>
            <div class="detail-owned-sub">
              Terakhir dibaca: Bab 4 – Halaman 45 &nbsp;·&nbsp;
              <a onclick="handleReadBook()">Lanjutkan membaca</a>
            </div>
          </div>
          <div class="detail-owned-actions">
            <button class="btn-read" onclick="handleReadBook()">
              <i class="ph ph-book-open"></i> Baca
            </button>
            <div class="btn-download-split">
              <button class="btn-download-main" onclick="showToast('Mengunduh e-book...','ph-download-simple')">
                <i class="ph ph-download-simple"></i> Download
              </button>
              <button class="btn-download-caret" onclick="showToast('Pilih format: EPUB atau PDF','ph-caret-down')">
                <i class="ph ph-caret-down"></i>
              </button>
            </div>
          </div>
          <div style="width:100%;margin-top:4px;">
            <div class="detail-format-note">
              <i class="ph ph-lock-open" style="font-size:13px;"></i>
              File tersedia dalam format
              <span class="detail-format-badge">EPUB</span>
              <span class="detail-format-badge">PDF</span>
            </div>
          </div>
        </div>

        <!-- Buy bar (shown if not purchased) -->
        <div class="price-bar" id="detail-buy-bar">
          <div>
            <div class="price-label">Harga</div>
            <div class="price-val" id="detail-book-price">Rp 59.000</div>
          </div>
          <button id="detail-action-button" class="btn-buy" onclick="handleBuyNow()">
            <i class="ph ph-shopping-bag-open"></i>
            Beli Sekarang
          </button>
        </div>

        <!-- Tabs -->
        <div class="detail-tabs">
          <button class="detail-tab active" onclick="switchDetailTab('about',this)">Tentang Buku</button>
          <button class="detail-tab" onclick="switchDetailTab('author',this)">Tentang Penulis</button>
          <button class="detail-tab" onclick="switchDetailTab('reviews',this)">Ulasan (<span id="d-tab-review-count">1.250</span>)</button>
        </div>

        <div id="detail-tab-about" class="detail-tab-panel active">
          <p class="detail-tab-content" id="detail-about-book">Novel ini berlatar masa politik Indonesia yang penuh gejolak. Melalui tokoh Biru Laut, pembaca diajak menyelami kisah cinta, persahabatan, dan pencarian makna hidup di tengah kehilangan. Ditulis dengan bahasa puitis dan penuh perasaan, Laut Bercerita menjadi salah satu karya sastra Indonesia paling berkesan.</p>
        </div>
        <div id="detail-tab-author" class="detail-tab-panel">
          <p class="detail-tab-content" id="detail-about-author">Leila S. Chudori adalah novelis dan jurnalis Indonesia yang dikenal dengan karya-karya berbobot dan berlatar sejarah. Gaya penulisannya yang puitis dan emosional menjadikan setiap karyanya terasa dekat dan membekas di hati pembaca.</p>
        </div>
        <div id="detail-tab-reviews" class="detail-tab-panel">
          <p class="detail-tab-content" id="detail-review-summary">Pembaca sangat menyukai buku ini karena tema sejarah yang kuat, gaya bahasa yang indah, dan karakter yang terasa nyata. Banyak yang menganggap ini sebagai salah satu novel Indonesia terbaik.</p>
        </div>
      </div>
    </div>

    <!-- Bottom: Reviews + Recommendations -->
    <div class="detail-bottom">
      <!-- Reviews -->
      <div class="detail-reviews-card">
        <h3>Ulasan Pembaca <a>Lihat semua</a></h3>
        <div class="review-big-score">4.8</div>
        <div class="review-stars-row">
          <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i>
          <i class="ph-fill ph-star"></i><i class="ph-fill ph-star-half"></i>
        </div>
        <div class="review-count-text">(1.250 ulasan)</div>
        <div class="review-bars">
          <div class="review-bar-row"><span>5</span><div class="review-bar-track"><div class="review-bar-fill" style="width:85%"></div></div><span>85%</span></div>
          <div class="review-bar-row"><span>4</span><div class="review-bar-track"><div class="review-bar-fill" style="width:10%"></div></div><span>10%</span></div>
          <div class="review-bar-row"><span>3</span><div class="review-bar-track"><div class="review-bar-fill" style="width:4%"></div></div><span>4%</span></div>
          <div class="review-bar-row"><span>2</span><div class="review-bar-track"><div class="review-bar-fill" style="width:1%"></div></div><span>1%</span></div>
          <div class="review-bar-row"><span>1</span><div class="review-bar-track"><div class="review-bar-fill" style="width:0%"></div></div><span>0%</span></div>
        </div>
        <div class="review-sample">
          <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=80&q=80" class="review-sample-avatar" alt="Reviewer">
          <div>
            <div class="review-sample-name">Anisa Putri</div>
            <div class="review-sample-stars"><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i></div>
            <div class="review-sample-time">2 minggu lalu</div>
            <div class="review-sample-text">Cerita yang indah dan menyentuh hati. Gaya bahasa Leila S. Chudori benar-benar puitis.</div>
          </div>
        </div>
      </div>

      <!-- Recommendations -->
      <div class="detail-recommend-card">
        <h3>Buku Lainnya yang Mungkin Anda Suka <a>Lihat semua</a></h3>
        <div class="rec-grid">
          <div class="rec-item" onclick="openBookDetail('dune')">
            <img src="https://images-na.ssl-images-amazon.com/images/I/91uwocAMtSL.jpg" class="rec-cover" alt="Pulang">
            <div class="rec-title">Pulang</div>
            <div class="rec-author">Tere Liye</div>
            <div class="rec-rating"><i class="ph-fill ph-star"></i> 4.7</div>
          </div>
          <div class="rec-item" onclick="openBookDetail('sapiens')">
            <img src="https://images-na.ssl-images-amazon.com/images/I/713jIoMO3UL.jpg" class="rec-cover" alt="Sapiens">
            <div class="rec-title">Sapiens</div>
            <div class="rec-author">Yuval Noah Harari</div>
            <div class="rec-rating"><i class="ph-fill ph-star"></i> 4.6</div>
          </div>
          <div class="rec-item" onclick="openBookDetail('atomic-habits')">
            <img src="https://images-na.ssl-images-amazon.com/images/I/91bYsX41DVL.jpg" class="rec-cover" alt="Atomic Habits">
            <div class="rec-title">Atomic Habits</div>
            <div class="rec-author">James Clear</div>
            <div class="rec-rating"><i class="ph-fill ph-star"></i> 4.8</div>
          </div>
          <div class="rec-item" onclick="openBookDetail('psychology-of-money')">
            <img src="https://images-na.ssl-images-amazon.com/images/I/71g2ednj0JL.jpg" class="rec-cover" alt="1984">
            <div class="rec-title">1984</div>
            <div class="rec-author">George Orwell</div>
            <div class="rec-rating"><i class="ph-fill ph-star"></i> 4.7</div>
          </div>
          <div class="rec-item" onclick="openBookDetail('mindset')">
            <img src="{{ asset('mindset.jpeg') }}" class="rec-cover" alt="Laskar Pelangi">
            <div class="rec-title">Laskar Pelangi</div>
            <div class="rec-author">Andrea Hirata</div>
            <div class="rec-rating"><i class="ph-fill ph-star"></i> 4.6</div>
          </div>
        </div>
      </div>
    </div>

    <div style="margin-top:20px;">
      <button class="btn-back" onclick="showPage('home-page')"><i class="ph ph-arrow-left"></i> Kembali</button>
    </div>
  </div>

  <!-- ══════════════ READER PAGE ══════════════ -->
  <div id="reader-page" class="page">
    <div class="reader-shell">
      <div class="reader-topbar">
        <div class="reader-meta">
          <h2 id="reader-book-title">Laut Bercerita</h2>
          <p id="reader-book-author">Leila S. Chudori</p>
        </div>
      </div>
      <div class="reader-paper">
        <span class="reader-chapter-badge"><i class="ph ph-bookmark-simple"></i> <span id="reader-chapter-label">Bab 1</span></span>
        <span class="reader-chapter-title" id="reader-chapter-title">Awal Cerita</span>
        <div class="reader-content" id="reader-book-content"></div>
        <div class="reader-progress">
          <div class="reader-progress-row">
            <span class="reader-percent" id="reader-percentage-progress">40%</span>
            <div class="reader-progress-track"><div class="reader-progress-fill" id="reader-progress-fill"></div></div>
            <span class="reader-pages" id="reader-page-progress">41 / 320 halaman</span>
          </div>
        </div>
      </div>
      <div class="reader-controls">
        <button class="reader-btn secondary" id="reader-prev-btn" onclick="changeReaderPage(-1)"><i class="ph ph-arrow-left"></i> Sebelumnya</button>
        <button class="reader-btn secondary" onclick="leaveReader()"><i class="ph ph-house"></i> Kembali</button>
        <button class="reader-btn primary" id="reader-next-btn" onclick="changeReaderPage(1)">Berikutnya <i class="ph ph-arrow-right"></i></button>
      </div>
    </div>
  </div>

  <!-- ══════════════ AKUN PAGE ══════════════ -->
  <div id="account-page" class="page">
    <!-- STATE: Not logged in -->
    <div id="account-guest">
      <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:60px 20px;text-align:center;">
        <div style="width:80px;height:80px;border-radius:50%;background:rgba(37,99,235,0.08);display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
          <i class="ph ph-user-circle" style="font-size:48px;color:var(--primary);"></i>
        </div>
        <h2 style="font-family:'Poppins',sans-serif;font-size:22px;font-weight:700;color:var(--ink);margin-bottom:8px;">Belum Masuk</h2>
        <p style="color:var(--muted);font-size:14px;line-height:1.7;max-width:280px;margin-bottom:28px;">Silakan login atau daftar untuk mengakses akun, rak buku, dan fitur lengkap lainnya.</p>
        <button class="hero-cta" onclick="showPage('login-page')" style="animation:none;">
          Masuk Sekarang
          <i class="ph ph-arrow-right"></i>
        </button>
        <button onclick="showPage('login-page')" style="margin-top:14px;background:none;border:none;color:var(--primary);font-size:13px;font-weight:600;cursor:pointer;font-family:inherit;">
          Belum punya akun? <u>Daftar gratis</u>
        </button>
      </div>
    </div>

    <!-- STATE: Logged in -->
    <div id="account-logged" style="display:none;">
      <div class="page-header">
        <div class="page-heading">Akun Saya</div>
        <div class="page-actions">
          <div class="icon-btn"><i class="ph ph-bell"></i></div>
          <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=120&q=80" class="avatar-sm profile-img">
        </div>
      </div>
      <div class="profile-card">
        <div class="profile-info">
          <div class="profile-avatar-wrap">
            <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=200&q=80" class="profile-img">
            <div class="profile-online"></div>
          </div>
          <div>
            <div class="profile-name">Amanda</div>
            <div class="profile-email">amanda@gmail.com</div>
            <div class="profile-badge"><i class="ph ph-crown-simple"></i> Member Aktif</div>
          </div>
        </div>
        <button class="btn-edit-profile"><i class="ph ph-pencil-simple"></i> Edit Profil</button>
      </div>
      <div class="menu-list">
        <div class="menu-item" onclick="showPage('account-page')">
          <div class="menu-left"><div class="menu-icon-wrap"><i class="ph ph-user"></i></div> Data Akun</div>
          <i class="ph ph-caret-right menu-arrow"></i>
        </div>
        <div class="menu-item" onclick="showPage('rak-page')">
          <div class="menu-left"><div class="menu-icon-wrap"><i class="ph ph-books"></i></div> Rak Buku</div>
          <i class="ph ph-caret-right menu-arrow"></i>
        </div>
        <div class="menu-item" onclick="showPage('fav-page')">
          <div class="menu-left"><div class="menu-icon-wrap"><i class="ph ph-heart"></i></div> Favorit</div>
          <span class="badge-count">4</span>
          <i class="ph ph-caret-right menu-arrow"></i>
        </div>
        <div class="menu-item">
          <div class="menu-left"><div class="menu-icon-wrap"><i class="ph ph-gear"></i></div> Pengaturan</div>
          <i class="ph ph-caret-right menu-arrow"></i>
        </div>
        <div class="menu-item">
          <div class="menu-left"><div class="menu-icon-wrap"><i class="ph ph-question"></i></div> Bantuan</div>
          <i class="ph ph-caret-right menu-arrow"></i>
        </div>
        <div class="menu-item">
          <div class="menu-left"><div class="menu-icon-wrap"><i class="ph ph-info"></i></div> Tentang Kami</div>
          <i class="ph ph-caret-right menu-arrow"></i>
        </div>
        <div class="menu-item" onclick="logout()">
          <div class="menu-left"><div class="menu-icon-wrap danger"><i class="ph ph-sign-out"></i></div> <span class="text-danger">Keluar</span></div>
        </div>
      </div>
      <center style="margin-top:20px;">
        <button class="btn-see-all"><i class="ph ph-list"></i> Lihat semua aktivitas</button>
      </center>
    </div>
  </div>

  <!-- ══════════════ PAYMENT PAGE ══════════════ -->
  <div id="payment-page" class="page">
    <div class="payment-shell">
      <div class="breadcrumb">
        <span>Beranda</span>
        <i class="ph ph-caret-right"></i>
        <span>Keranjang</span>
        <i class="ph ph-caret-right"></i>
        <b>Pembayaran</b>
      </div>
      <div class="payment-topbar">
        <div>
          <h1>Pilih Metode Pembayaran</h1>
          <p>Selesaikan pembayaran dalam waktu 24 jam</p>
        </div>
        <div class="secure-badge"><i class="ph ph-shield-check"></i> Transaksi aman &amp; terenkripsi</div>
      </div>
      <div class="payment-layout">
        <div class="payment-card">
          <h3><i class="ph ph-receipt"></i> Ringkasan Pesanan</h3>
          <div class="summary-book">
            <img id="payment-book-cover" src="{{ asset('laut-bercerita.jpeg') }}" alt="Laut Bercerita">
            <div class="summary-book-info">
              <h4 id="payment-book-title">Laut Bercerita</h4>
              <p id="payment-book-author">Leila S. Chudori</p>
              <span class="s-tag"><i class="ph ph-device-mobile"></i> E-Book Digital</span>
            </div>
            <div class="summary-price" id="payment-book-price">Rp 59.000</div>
          </div>
          <div class="payment-row"><span>Subtotal</span><strong id="payment-subtotal">Rp 59.000</strong></div>
          <div class="payment-row"><span>Biaya Layanan</span><strong id="payment-fee">Rp 1.000</strong></div>
          <div class="payment-total"><span>Total</span><strong id="payment-total">Rp 60.000</strong></div>
          <div class="safe-box">
            <i class="ph ph-shield-check"></i>
            <div><b style="font-weight:700;">Garansi 100% Aman</b>Pembayaran Anda dilindungi sistem keamanan berlapis. Data Anda aman bersama kami.</div>
          </div>
        </div>

        <div class="payment-card">
          <h3><i class="ph ph-credit-card"></i> Metode Pembayaran</h3>
          <div class="method-tabs">
            <div class="method-tab active" onclick="switchPaymentMethod('qris', this)"><i class="ph ph-qr-code"></i> QRIS</div>
            <div class="method-tab" onclick="switchPaymentMethod('va', this)"><i class="ph ph-bank"></i> Virtual Account</div>
          </div>

          <div id="payment-panel-qris" class="method-panel active">
            <p class="payment-note">Scan kode QR di bawah ini dengan aplikasi e-wallet atau m-banking Anda.</p>
            <div class="wallet-grid">
              <div class="wallet-item active" data-wallet="GoPay" onclick="selectWallet('GoPay', this)"><span class="wallet-label">gopay</span></div>
              <div class="wallet-item" data-wallet="OVO" onclick="selectWallet('OVO', this)"><span class="wallet-label">OVO</span></div>
              <div class="wallet-item" data-wallet="DANA" onclick="selectWallet('DANA', this)"><span class="wallet-label">DANA</span></div>
              <div class="wallet-item" data-wallet="LinkAja!" onclick="selectWallet('LinkAja!', this)"><span class="wallet-label">LinkAja!</span></div>
              <div class="wallet-item" data-wallet="ShopeePay" onclick="selectWallet('ShopeePay', this)"><span class="wallet-label">ShopeePay</span></div>
              <div class="wallet-item" data-wallet="BCA mobile" onclick="selectWallet('BCA mobile', this)"><span class="wallet-label">BCA mobile</span></div>
              <div class="wallet-item" data-wallet="Livin' by Mandiri" onclick="selectWallet(`Livin' by Mandiri`, this)"><span class="wallet-label">livin'</span></div>
              <div class="wallet-item" data-wallet="Permata Mobile X" onclick="selectWallet('Permata Mobile X', this)"><span class="wallet-label">Permata X</span></div>
            </div>
            <div class="qr-section">
              <div class="qr-box">
                <div class="qris-shell">
                  <div class="qris-topmark"><span>SCAN</span><strong>QRIS</strong><span>PAY</span></div>
                  <div id="qris-code"></div>
                </div>
              </div>
              <div class="qr-info">
                <h4>QRIS</h4>
                <p>QR Code Standar Pembayaran Nasional untuk e-wallet dan mobile banking.</p>
                <div class="qr-chip"><i class="ph ph-check-circle"></i> <span id="selected-wallet-chip">Metode aktif: GoPay</span></div>
                <div class="qris-brand">
                  <div class="qris-brand-badge">QR</div>
                  <p>Gunakan aplikasi yang mendukung QRIS untuk memindai dan menyelesaikan pembayaran secara instan.</p>
                </div>
              </div>
            </div>
          </div>

          <div id="payment-panel-va" class="method-panel">
            <p class="payment-note">Pilih bank, lalu gunakan nomor VA untuk menyelesaikan pembayaran.</p>
            <div class="va-list">
              <div class="va-item active" onclick="selectVirtualAccount('BCA', this)"><b>BCA Virtual Account</b><span>Verifikasi otomatis dalam beberapa menit.</span></div>
              <div class="va-item" onclick="selectVirtualAccount('Mandiri', this)"><b>Mandiri Virtual Account</b><span>Via Livin' by Mandiri dan ATM.</span></div>
              <div class="va-item" onclick="selectVirtualAccount('BNI', this)"><b>BNI Virtual Account</b><span>Mobile banking, ATM, dan internet banking.</span></div>
              <div class="va-item" onclick="selectVirtualAccount('BRI', this)"><b>BRI Virtual Account</b><span>BRImo, ATM BRI, dan kanal lainnya.</span></div>
            </div>
            <div class="va-detail">
              <p style="color:var(--muted);font-size:13px;">Bank terpilih</p>
              <h4 id="va-bank-name" style="font-size:20px;color:var(--ink);margin:6px 0 10px;font-family:'Poppins',sans-serif;">BCA Virtual Account</h4>
              <p style="color:var(--muted);font-size:13px;">Nomor Virtual Account</p>
              <div class="va-code-box">
                <strong id="va-number">8808123456789012</strong>
                <button class="btn-copy" onclick="copyVirtualAccount()"><i class="ph ph-copy"></i> Salin</button>
              </div>
            </div>
          </div>

          <div class="payment-footer-stats">
            <div class="pf-total">
              <p>Total Pembayaran</p>
              <strong id="payment-total-footer">Rp 60.000</strong>
            </div>
            <div class="deadline-box">
              <b><i class="ph ph-clock"></i> Batas pembayaran</b>
              <span>23:59:59</span>
            </div>
          </div>
          <div class="payment-alert"><i class="ph ph-warning"></i> Setelah membayar, klik tombol di bawah agar pembayaran dapat diverifikasi otomatis.</div>
          <button class="btn-pay" onclick="confirmPayment()"><i class="ph ph-check-circle"></i> Saya sudah bayar</button>
          <div class="payment-helper"><i class="ph ph-clock"></i> Verifikasi maks. 2 menit</div>
        </div>
      </div>
    </div>
  </div>

  <!-- ══════════════ OWNED BOOK PAGE ══════════════ -->
  <div id="owned-book-page" class="page">
    <div class="owned-shell">
      <div class="breadcrumb">
        <span>Beranda</span><i class="ph ph-caret-right"></i>
        <span>Novel</span><i class="ph ph-caret-right"></i>
        <b id="owned-breadcrumb-title">Laut Bercerita</b>
      </div>
      <div class="owned-layout">
        <div>
          <div class="owned-cover-wrap"><img id="owned-book-cover" src="{{ asset('laut-bercerita.jpeg') }}" alt="Laut Bercerita"></div>
          <button class="owned-fav-btn">
            <b><i class="ph-fill ph-heart"></i> Tambah ke Favorit</b>
            <p>25,4 rb orang menyukai buku ini</p>
          </button>
        </div>
        <div>
          <div class="owned-header">
            <div class="owned-title" id="owned-book-title">Laut Bercerita</div>
            <div class="owned-author"><i class="ph ph-user"></i> <span id="owned-book-author">Leila S. Chudori</span></div>
            <div class="owned-meta">
              <span><i class="ph-fill ph-star star"></i> <span id="owned-rating">4.8</span> (<span id="owned-review-count">1.250</span> ulasan)</span>
              <span><i class="ph ph-users"></i> <span id="owned-readers">12,5 rb pembaca</span></span>
            </div>
            <div class="owned-tags" id="owned-tags-container">
              <span class="owned-tag">Novel</span><span class="owned-tag">Drama</span>
            </div>
            <div class="owned-desc" id="owned-book-description">
              Laut Bercerita adalah novel yang mengisahkan perjuangan, kehilangan, dan harapan di masa penuh gejolak.
            </div>
          </div>
          <div class="owned-stats">
            <div class="owned-stat"><i class="ph ph-globe"></i> Bahasa<b id="os-lang">Indonesia</b></div>
            <div class="owned-stat"><i class="ph ph-file-text"></i> Halaman<b id="os-pages">320</b></div>
            <div class="owned-stat"><i class="ph ph-calendar"></i> Terbit<b id="os-year">2017</b></div>
            <div class="owned-stat"><i class="ph ph-buildings"></i> Penerbit<b id="os-pub">KPG</b></div>
          </div>
          <div class="owned-status">
            <div>
              <h3><i class="ph ph-check-circle"></i> Buku Anda</h3>
              <p>Terakhir dibaca: Bab 4 · Halaman 45<br>Lanjutkan kapan saja dari perangkat Anda.</p>
            </div>
            <div class="owned-actions">
              <button class="owned-btn-primary" onclick="openReaderCurrentBook()"><i class="ph ph-book-open"></i> Baca</button>
              <button class="owned-btn-secondary" onclick="downloadBook()"><i class="ph ph-download-simple"></i> Download</button>
            </div>
          </div>
          <div class="owned-tabs">
            <button class="owned-tab active" onclick="switchOwnedTab('book', this)">Tentang Buku</button>
            <button class="owned-tab" onclick="switchOwnedTab('author', this)">Tentang Penulis</button>
            <button class="owned-tab" onclick="switchOwnedTab('review', this)">Ulasan (<span id="owned-tab-review-count">1.250</span>)</button>
          </div>
          <div class="owned-panel">
            <div id="owned-tab-book" class="owned-tab-panel active">Novel ini berlatar masa politik Indonesia yang penuh gejolak. Melalui tokoh Biru Laut, pembaca diajak menyelami kisah cinta dan pencarian makna hidup.</div>
            <div id="owned-tab-author" class="owned-tab-panel">Leila S. Chudori adalah penulis dan jurnalis Indonesia yang dikenal melalui karya-karyanya yang kuat secara historis, emosional, dan sosial.</div>
            <div id="owned-tab-review" class="owned-tab-panel">Pembaca banyak memuji novel ini karena emosinya terasa dalam dan narasinya meninggalkan kesan lama setelah selesai dibaca.</div>
          </div>
        </div>
      </div>
      <div class="owned-bottom">
        <div class="owned-review-card">
          <h3>Ulasan Pembaca</h3>
          <div class="review-score" id="review-score-val">4.8</div>
          <div class="review-stars">★★★★★</div>
          <div class="review-count">(<span id="review-count-val">1.250</span> ulasan)</div>
          <div class="review-sample">
            <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=120&q=80" alt="Reviewer">
            <div class="review-sample-text">
              <b id="reviewer-name">Anisa Putri</b>
              <span id="reviewer-text">Cerita yang indah dan menyentuh hati. Gaya bahasa Leila S. Chudori benar-benar puitis.</span>
            </div>
          </div>
        </div>
        <div class="owned-recommend-card">
          <h3>Buku Lainnya yang Mungkin Anda Suka</h3>
          <div class="recommend-grid">
            <div class="recommend-item" onclick="openRecommendedBook('dune')">
              <div class="recommend-cover cover-dune"><span class="cover-subtitle">Frank Herbert</span><span class="cover-title">DUNE</span></div>
              <b>Dune</b><span>Frank Herbert</span><span>⭐ 4.7</span>
            </div>
            <div class="recommend-item" onclick="openRecommendedBook('the-alchemist')">
              <div class="recommend-cover cover-alchemist"><span class="cover-title">The Alchemist</span><span class="cover-subtitle">A Fable About Following Your Dream</span></div>
              <b>The Alchemist</b><span>Paulo Coelho</span><span>⭐ 4.6</span>
            </div>
            <div class="recommend-item" onclick="openRecommendedBook('midnight-library')">
              <div class="recommend-cover cover-midnight"><span class="cover-subtitle">A Novel</span><span class="cover-title">The Midnight<br>Library</span></div>
              <b>The Midnight Library</b><span>Matt Haig</span><span>⭐ 4.8</span>
            </div>
            <div class="recommend-item" onclick="openRecommendedBook('ikigai')">
              <div class="recommend-cover cover-ikigai"><span class="cover-title">IKIGAI</span><span class="cover-subtitle">The Japanese Secret to a Long Life</span></div>
              <b>Ikigai</b><span>Hector Garcia</span><span>⭐ 4.7</span>
            </div>
            <div class="recommend-item" onclick="openRecommendedBook('psychology-of-money')">
              <div class="recommend-cover cover-psychology"><span class="cover-title">The Psychology<br>of Money</span><span class="cover-subtitle">Timeless Lessons on Wealth</span></div>
              <b>The Psychology of Money</b><span>Morgan Housel</span><span>⭐ 4.6</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ══════════════ LOGIN PAGE ══════════════ -->
  <div id="login-page" class="page">
    <div class="login-shell">
      <!-- LEFT: Illustration -->
      <div class="login-left">
        <img
          src="{{ asset('login-illustration.png') }}"
          alt="Baca E-Book"
          class="login-left-img"
        >
        <div class="login-left-overlay">
          <h3>Masuk untuk melanjutkan</h3>
          <p>Login untuk membeli, membaca, dan menyimpan buku favoritmu.</p>
          <div class="login-features">
            <div class="login-feature">
              <div class="login-feature-icon"><i class="ph ph-book-open"></i></div>
              Baca di mana saja
            </div>
            <div class="login-feature">
              <div class="login-feature-icon"><i class="ph ph-heart"></i></div>
              Simpan favorit
            </div>
            <div class="login-feature">
              <div class="login-feature-icon"><i class="ph ph-download-simple"></i></div>
              Download buku
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT: Form -->
      <div class="login-right">
        <h2>Selamat Datang Kembali!</h2>
        <p>Login untuk melanjutkan perjalanan membaca Anda.</p>

        <div class="form-group">
          <label>Email</label>
          <div class="form-input-wrap">
            <i class="ph ph-envelope form-input-icon"></i>
            <input type="email" id="login-email" class="form-input" placeholder="nama@email.com">
          </div>
        </div>

        <div class="form-group">
          <label>Kata Sandi</label>
          <div class="form-input-wrap">
            <i class="ph ph-lock-simple form-input-icon"></i>
            <input type="password" id="login-password" class="form-input" placeholder="••••••••">
            <button type="button" class="form-input-eye" onclick="togglePassword()" id="eye-btn">
              <i class="ph ph-eye" id="eye-icon"></i>
            </button>
          </div>
        </div>

        <div class="form-extras">
          <label class="form-check"><input type="checkbox"> Ingat saya</label>
          <a href="#" class="form-forgot">Lupa kata sandi?</a>
        </div>

        <button class="btn-submit" onclick="performLogin()">Login</button>

        <div class="divider"><span>atau masuk dengan</span></div>

        <a href="{{ route('auth.google') }}" class="btn-google">
          <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.64 9.2045C17.64 8.5664 17.5827 7.9527 17.4764 7.3636H9V10.845H13.8436C13.635 11.9700 13.0009 12.9232 12.0477 13.5614V15.8196H14.9564C16.6582 14.2527 17.64 11.9450 17.64 9.2045Z" fill="#4285F4"/>
            <path d="M9 18C11.43 18 13.4673 17.1941 14.9564 15.8195L12.0477 13.5613C11.2418 14.1013 10.2109 14.4204 9 14.4204C6.65591 14.4204 4.67182 12.8372 3.96409 10.71H0.957275V13.0418C2.43818 15.9831 5.48182 18 9 18Z" fill="#34A853"/>
            <path d="M3.96409 10.71C3.78409 10.17 3.68182 9.5931 3.68182 9.0000C3.68182 8.4068 3.78409 7.8300 3.96409 7.2900V4.9582H0.957273C0.347727 6.1732 0 7.5477 0 9.0000C0 10.4522 0.347727 11.8268 0.957273 13.0418L3.96409 10.71Z" fill="#FBBC05"/>
            <path d="M9 3.5795C10.3214 3.5795 11.5077 4.0336 12.4405 4.9254L15.0218 2.3440C13.4632 0.8918 11.4259 0 9 0C5.48182 0 2.43818 2.0168 0.957275 4.9582L3.96409 7.29C4.67182 5.1627 6.65591 3.5795 9 3.5795Z" fill="#EA4335"/>
          </svg>
          Google
        </a>

        <div class="login-footer">
          Belum punya akun? <a onclick="showToast('Fitur daftar segera hadir!', 'ph-sparkle')">Daftar</a>
        </div>
      </div>
    </div>
    <center style="margin-top:16px;">
      <button class="btn-back" onclick="showPage('home-page')"><i class="ph ph-arrow-left"></i> Kembali ke Beranda</button>
    </center>
  </div>

</div><!-- /.wrap -->

<!-- BOTTOM NAV -->

<!-- TOAST -->
<div class="toast" id="toast"></div>

<script>
  let isLoggedIn = false;
  let pendingRedirectPage = 'payment-page';
  let selectedVABank = 'BCA';
  let selectedWallet = 'GoPay';

  const vaNumbers = { BCA:'8808123456789012', Mandiri:'7000812345678901', BNI:'9881123456789012', BRI:'2621512345678901' };

  const qrisPayloads = {
    'GoPay':'00020101021226670016COM.NOBUBANK.WWW01189360050300000879140214012345678901230303UMI51440014ID.CO.QRIS.WWW0215ID10243281990030303UMI5204541153033605802ID5911EBOOK STORE6007JAKARTA61051234062070703A016304B1A2',
    'OVO':'00020101021226670016COM.NOBUBANK.WWW01189360050300000879140214012345678901230303UMI51440014ID.CO.QRIS.WWW0215ID10243281990030303UMI5204541153033605802ID5908OVO PAY6010JAKARTA61051234062070703A026304A1B2',
    'DANA':'00020101021226670016COM.NOBUBANK.WWW01189360050300000879140214012345678901230303UMI51440014ID.CO.QRIS.WWW0215ID10243281990030303UMI5204541153033605802ID5909DANA PAY6010JAKARTA61051234062070703A036304C1D2',
    'LinkAja!':'00020101021226670016COM.NOBUBANK.WWW01189360050300000879140214012345678901230303UMI51440014ID.CO.QRIS.WWW0215ID10243281990030303UMI5204541153033605802ID5911LINKAJA PAY6007JAKARTA61051234062070703A046304D1E2',
    'ShopeePay':'00020101021226670016COM.NOBUBANK.WWW01189360050300000879140214012345678901230303UMI51440014ID.CO.QRIS.WWW0215ID10243281990030303UMI5204541153033605802ID5910SHOPEEPAY6007JAKARTA61051234062070703A056304E1F2',
    'BCA mobile':'00020101021226670016COM.NOBUBANK.WWW01189360050300000879140214012345678901230303UMI51440014ID.CO.QRIS.WWW0215ID10243281990030303UMI5204541153033605802ID5910BCA MOBILE6007JAKARTA61051234062070703A066304F1G2',
    "Livin' by Mandiri":'00020101021226670016COM.NOBUBANK.WWW01189360050300000879140214012345678901230303UMI51440014ID.CO.QRIS.WWW0215ID10243281990030303UMI5204541153033605802ID5915LIVIN MANDIRI6007JAKARTA61051234062070703A076304G1H2',
    'Permata Mobile X':'00020101021226670016COM.NOBUBANK.WWW01189360050300000879140214012345678901230303UMI51440014ID.CO.QRIS.WWW0215ID10243281990030303UMI5204541153033605802ID5910PERMATA MX6007JAKARTA61051234062070703A086304H1I2'
  };

  const bookDetails = {
    'laut-bercerita':{description:'Laut Bercerita adalah novel historis yang memadukan kehilangan, keberanian, dan kasih keluarga di tengah masa politik yang mencekam.',aboutBook:'Novel ini membawa pembaca ke masa akhir Orde Baru lewat kisah Biru Laut dan orang-orang di sekelilingnya.',aboutAuthor:'Leila S. Chudori dikenal sebagai penulis dan jurnalis Indonesia dengan gaya bercerita yang puitis, detail, dan kuat secara emosional.',reviewSummary:'Banyak pembaca menyukai kedalaman emosinya dan cara novel ini menghidupkan sejarah tanpa terasa kaku.',rating:'4.8',reviewCount:'1.250',readers:'12,5 rb pembaca',tags:['Novel','Drama','Sejarah'],language:'Indonesia',pages:'320',progressPage:128,progressTotalPages:320,year:'2017',publisher:'KPG',sampleReviewer:'Anisa Putri',sampleReview:'Ceritanya menyentuh, tenang, lalu menghantam pelan-pelan.'},
    'atomic-habits':{description:'Atomic Habits membahas cara membangun perubahan besar lewat kebiasaan kecil yang dilakukan konsisten.',aboutBook:'James Clear menjelaskan bahwa hasil besar sering lahir dari perbaikan kecil yang diulang terus-menerus.',aboutAuthor:'James Clear adalah penulis dan pembicara yang fokus pada pembentukan kebiasaan dan peningkatan berkelanjutan.',reviewSummary:'Ulasan pembaca paling sering memuji buku ini karena sangat aplikatif.',rating:'4.9',reviewCount:'2.430',readers:'18,2 rb pembaca',tags:['Self Improvement','Produktivitas'],language:'Inggris',pages:'320',progressPage:96,progressTotalPages:320,year:'2018',publisher:'Avery',sampleReviewer:'Raka Pratama',sampleReview:'Penjelasannya sederhana, tapi langsung membuat saya ingin memperbaiki rutinitas harian.'},
    'sapiens':{description:'Sapiens mengulas perjalanan Homo sapiens dari zaman purba hingga modern.',aboutBook:'Buku ini menelusuri revolusi kognitif, pertanian, hingga ilmiah dengan sudut pandang yang tajam.',aboutAuthor:'Yuval Noah Harari adalah sejarawan yang dikenal melalui karya nonfiksi populer bertema sejarah besar umat manusia.',reviewSummary:'Pembaca banyak menyukai cara Sapiens membuat topik sejarah terasa hidup dan relevan.',rating:'4.7',reviewCount:'1.980',readers:'14,1 rb pembaca',tags:['Sejarah','Nonfiksi','Pemikiran'],language:'Inggris',pages:'498',progressPage:214,progressTotalPages:498,year:'2011',publisher:'Harvill Secker',sampleReviewer:'Dina Maheswari',sampleReview:'Jarang ada buku sejarah yang terasa seluas ini tetapi tetap enak diikuti.'},
    'psychology-of-money':{description:'The Psychology of Money menyoroti bagaimana perilaku dan emosi menentukan keputusan finansial.',aboutBook:'Morgan Housel menyusun buku ini dalam esai-esai pendek yang membahas uang dari sisi manusia.',aboutAuthor:'Morgan Housel adalah penulis yang dikenal melalui pembahasan keuangan yang sederhana dan jernih.',reviewSummary:'Pembaca menyukai buku ini karena terasa relevan dan mengubah cara memandang uang.',rating:'4.8',reviewCount:'1.640',readers:'16,7 rb pembaca',tags:['Keuangan','Psikologi','Nonfiksi'],language:'Inggris',pages:'256',progressPage:118,progressTotalPages:256,year:'2020',publisher:'Harriman House',sampleReviewer:'Salsa Rahmadini',sampleReview:'Buku ini mengajarkan cara berpikir yang lebih sehat tentang uang.',isFree:true},
    'clean-code':{description:'Clean Code adalah panduan menulis kode yang rapi, mudah dibaca, dan mudah dirawat.',aboutBook:'Buku ini membedah prinsip-prinsip penamaan, fungsi, dan pengelolaan kompleksitas dalam kode.',aboutAuthor:'Robert C. Martin adalah tokoh berpengaruh dalam dunia pengembangan perangkat lunak.',reviewSummary:'Banyak developer menganggap buku ini sebagai bacaan penting untuk meningkatkan kualitas kode.',rating:'4.8',reviewCount:'1.120',readers:'9,4 rb pembaca',tags:['Programming','Software Engineering'],language:'Inggris',pages:'464',progressPage:173,progressTotalPages:464,year:'2008',publisher:'Prentice Hall',sampleReviewer:'Fajar Nugroho',sampleReview:'Isinya tajam dan sangat berguna untuk developer mana pun.'},
    'mindset':{description:'Mindset menjelaskan bagaimana fixed mindset dan growth mindset memengaruhi cara seseorang berkembang.',aboutBook:'Carol Dweck menunjukkan bahwa keyakinan kita tentang kemampuan sangat memengaruhi respons terhadap tantangan.',aboutAuthor:'Carol S. Dweck adalah psikolog dan peneliti yang dikenal lewat karya tentang motivasi dan perkembangan diri.',reviewSummary:'Pembaca sering merasa buku ini membantu mereka mengenali pola pikir yang selama ini membatasi diri.',rating:'4.7',reviewCount:'1.410',readers:'11,3 rb pembaca',tags:['Psikologi','Pengembangan Diri'],language:'Inggris',pages:'368',progressPage:74,progressTotalPages:368,year:'2006',publisher:'Random House',sampleReviewer:'Nadia Kusuma',sampleReview:'Buku ini membuat saya lebih sadar bahwa cara menilai kegagalan sangat menentukan arah berkembang.',isFree:true},
    'dune':{description:'Dune adalah novel fiksi ilmiah epik tentang kekuasaan dan takdir di planet gurun Arrakis.',aboutBook:'Frank Herbert membangun dunia yang kompleks dengan politik antar keluarga besar dan perebutan rempah.',aboutAuthor:'Frank Herbert adalah penulis Amerika yang dikenal sebagai pencipta semesta Dune.',reviewSummary:'Pembaca menyukai skala dunianya yang luas dan tema-temanya yang kaya.',rating:'4.7',reviewCount:'980',readers:'8,9 rb pembaca',tags:['Sci-Fi','Epik','Petualangan'],language:'Inggris',pages:'688',progressPage:256,progressTotalPages:688,year:'1965',publisher:'Chilton Books',sampleReviewer:'Bima Adhitya',sampleReview:'Dune terasa besar sejak halaman pertama. Politiknya rumit, dunianya kuat.'},
    'the-alchemist':{description:'The Alchemist adalah novel reflektif tentang mimpi dan perjalanan menemukan tujuan pribadi.',aboutBook:'Melalui perjalanan Santiago, buku ini merangkai kisah sederhana yang sarat simbol dan renungan.',aboutAuthor:'Paulo Coelho adalah novelis Brasil yang dikenal melalui karya spiritual dan reflektif.',reviewSummary:'Pembaca umumnya menyukai buku ini karena terasa hangat dan inspiratif.',rating:'4.6',reviewCount:'1.870',readers:'17,4 rb pembaca',tags:['Fiksi','Inspiratif','Filosofis'],language:'Inggris',pages:'208',progressPage:89,progressTotalPages:208,year:'1988',publisher:'HarperOne',sampleReviewer:'Livia Paramita',sampleReview:'Bacanya ringan, tapi beberapa kalimatnya tinggal lama di kepala.'},
    'midnight-library':{description:'The Midnight Library mengangkat tema penyesalan dan harapan lewat kisah yang emosional.',aboutBook:'Nora Seed memasuki perpustakaan misterius yang memperlihatkan kehidupan-kehidupan alternatif.',aboutAuthor:'Matt Haig dikenal melalui tulisan yang peka terhadap tema kesehatan mental dan harapan.',reviewSummary:'Banyak pembaca merasa buku ini menenangkan karena membahas penyesalan tanpa menggurui.',rating:'4.6',reviewCount:'1.130',readers:'10,2 rb pembaca',tags:['Fiksi','Emosional','Filosofis'],language:'Inggris',pages:'304',progressPage:112,progressTotalPages:304,year:'2020',publisher:'Canongate Books',sampleReviewer:'Tasya Amelia',sampleReview:'Buku ini sedih, lembut, dan menenangkan sekaligus.'},
    'ikigai':{description:'Ikigai membahas hidup yang lebih panjang dan bermakna lewat kebiasaan kecil dan rasa tujuan.',aboutBook:'Buku ini menggabungkan observasi budaya Jepang dan refleksi tentang tujuan hidup.',aboutAuthor:'Hector Garcia dan Francesc Miralles dikenal lewat karya populer bertema filosofi hidup.',reviewSummary:'Pembaca menikmati suasananya yang tenang dan tidak menggurui.',rating:'4.5',reviewCount:'920',readers:'7,8 rb pembaca',tags:['Lifestyle','Filosofi','Self Growth'],language:'Inggris',pages:'208',progressPage:63,progressTotalPages:208,year:'2016',publisher:'Penguin Life',sampleReviewer:'Rani Setiawan',sampleReview:'Buku ini mengajak menikmati ritme hidup yang sederhana dan terasa lebih sehat.'}
  };

  const homeBooks = {
    'laut-bercerita':{title:'Laut Bercerita',author:'Leila S. Chudori',cover:'{{ asset("laut-bercerita.jpeg") }}',price:'Rp 59.000',description:'Laut Bercerita adalah novel yang mengisahkan perjuangan, kehilangan dan harapan dimasa penuh gejolak.'},
    'atomic-habits':{title:'Atomic Habits',author:'James Clear',cover:'https://images-na.ssl-images-amazon.com/images/I/91bYsX41DVL.jpg',price:'Gratis',isFree:true,description:'Atomic Habits menjelaskan bagaimana perubahan kecil yang konsisten dapat membentuk hasil besar.'},
    'sapiens':{title:'Sapiens',author:'Yuval Noah Harari',cover:'https://images-na.ssl-images-amazon.com/images/I/713jIoMO3UL.jpg',price:'Rp 135.000',description:'Sapiens membahas evolusi manusia dari masa purba hingga modern.'},
    'psychology-of-money':{title:'Psychology of Money',author:'Morgan Housel',cover:'https://images-na.ssl-images-amazon.com/images/I/71g2ednj0JL.jpg',price:'Gratis',isFree:true,description:'Psychology of Money mengeksplorasi bagaimana orang berpikir tentang uang.'},
    'clean-code':{title:'Clean Code',author:'Robert C. Martin',cover:'https://images-na.ssl-images-amazon.com/images/I/41SH-SvWPxL.jpg',price:'Rp 120.000',description:'Clean Code adalah panduan praktis untuk menulis kode yang bersih dan mudah dipelihara.'},
    'mindset':{title:'Mindset',author:'Carol S. Dweck',cover:'{{ asset("mindset.jpeg") }}',price:'Gratis',isFree:true,description:'Mindset menjelaskan perbedaan antara fixed mindset dan growth mindset.'}
  };

  const recommendedBooks = {
    'dune':{title:'Dune',author:'Frank Herbert',cover:'https://images-na.ssl-images-amazon.com/images/I/91uwocAMtSL.jpg',price:'Rp 118.000',description:'Kisah epik di gurun Arrakis.'},
    'the-alchemist':{title:'The Alchemist',author:'Paulo Coelho',cover:'https://images-na.ssl-images-amazon.com/images/I/71aFt4+OTOL.jpg',price:'Rp 84.000',description:'Novel reflektif tentang keberanian mengikuti mimpi.'},
    'midnight-library':{title:'The Midnight Library',author:'Matt Haig',cover:'https://images-na.ssl-images-amazon.com/images/I/81J6APjwxlL.jpg',price:'Rp 92.000',description:'Kemungkinan hidup yang berbeda lewat kisah yang hangat.'},
    'ikigai':{title:'Ikigai',author:'Hector Garcia',cover:'https://images-na.ssl-images-amazon.com/images/I/81l3rZK4lnL.jpg',price:'Rp 88.000',description:'Rahasia hidup panjang dan bahagia dari Jepang.'},
    'psychology-of-money':{title:'The Psychology of Money',author:'Morgan Housel',cover:'https://images-na.ssl-images-amazon.com/images/I/71g2ednj0JL.jpg',price:'Rp 95.000',isFree:true,description:'Emosi dan kebiasaan dalam keputusan finansial.'}
  };

  const bookReaderPages = {
    'laut-bercerita':['Laut membuka cerita dengan suasana yang tenang tetapi menyimpan kegelisahan. Kota, keluarga, dan pertemanan hadir sebagai latar yang terasa dekat.\n\nDi halaman awal ini, nada cerita dibangun dengan lembut namun penuh firasat.','Percakapan-percakapan kecil mulai terasa penting. Di antara tawa dan diskusi, para tokohnya memperlihatkan keberanian yang tumbuh pelan-pelan.\n\nPembaca diajak melihat bahwa perlawanan tidak selalu hadir dalam bentuk yang besar.','Ketegangan meningkat saat pilihan hidup menjadi semakin sempit. Rasa kehilangan, ketakutan, dan cinta muncul bersamaan.\n\nBagian ini membuat pembaca semakin memahami mengapa Laut Bercerita terasa begitu membekas.','Cerita bergerak lebih dalam ke ruang keluarga dan kenangan. Harapan tetap hidup, walau dibayangi perpisahan.\n\nDi sinilah kekuatan novel terasa: menyatukan sejarah, kasih sayang, dan luka dalam satu alur yang puitis.','Menjelang penutup cuplikan ini, pembaca diajak merenungkan arti pulang, kehilangan, dan keberanian untuk mengingat.\n\nHalaman ini menutup pengalaman baca dengan suasana yang tenang namun meninggalkan gema yang panjang.'],
    'atomic-habits':['Atomic Habits dibuka dengan gagasan sederhana: perubahan kecil yang dilakukan konsisten bisa menghasilkan dampak besar.\n\nHalaman ini terasa seperti ajakan untuk berhenti mencari lompatan besar.','James Clear mulai memperkenalkan bagaimana identitas berhubungan dengan kebiasaan. Bukan hanya apa yang ingin dicapai, tetapi siapa kita ingin menjadi.\n\nGagasan ini membuat pembaca melihat bahwa kebiasaan adalah cara membentuk diri.','Pembahasan berlanjut ke sistem dan lingkungan. Banyak kegagalan bukan karena kurang niat, melainkan karena sistem yang tidak mendukung.\n\nBagian ini memberi sudut pandang praktis yang sangat relevan.','Contoh-contoh sederhana membuat isi buku semakin mudah dibayangkan. Kebiasaan baik dibangun dengan isyarat kecil dan pengulangan.\n\nPembaca mulai merasa bahwa perubahan bisa dibuat jauh lebih realistis.','Di bagian akhir cuplikan, benang merah buku menjadi jelas: konsistensi lebih penting dari motivasi sesaat.\n\nHalaman ini menutup bacaan dengan dorongan untuk memulai dari langkah yang paling kecil.'],
    'sapiens':['Sapiens membuka pembahasan dengan pertanyaan besar tentang bagaimana manusia bisa mendominasi dunia.\n\nPembaca diajak menatap perjalanan manusia dari sudut pandang yang tidak biasa.','Yuval Noah Harari mulai mengurai lompatan kognitif yang membedakan Homo sapiens. Imajinasi dan kemampuan bekerja dalam kelompok besar menjadi sorotan.\n\nBagian ini membuat sejarah terasa hidup dan relevan.','Penjelasan berlanjut ke revolusi pertanian, sebuah perubahan yang tampak maju tetapi membawa banyak konsekuensi baru.\n\nSapiens tidak hanya memberi fakta, tetapi mengajak mempertanyakan makna kemajuan.','Dengan gaya yang tajam, buku ini memperlihatkan bagaimana agama, uang, dan negara dibentuk oleh kepercayaan kolektif.\n\nDi sini pembaca mulai melihat dunia modern dengan kacamata baru.','Menjelang akhir cuplikan, pertanyaan tentang masa depan manusia mulai muncul.\n\nHalaman ini menutup bacaan dengan rasa takjub yang bercampur gelisah.','Bagian terakhir menegaskan kekuatan utama Sapiens: menghubungkan masa lampau dengan masa depan manusia.\n\nPembaca ditinggalkan dengan banyak pertanyaan besar.'],
    'psychology-of-money':['The Psychology of Money dibuka dengan ide bahwa keputusan finansial tidak selalu dibuat secara logis.\n\nDari awal, buku ini terasa akrab karena berbicara tentang manusia, bukan sekadar angka.','Morgan Housel menjelaskan bahwa orang yang cerdas pun bisa membuat keputusan keuangan yang buruk.\n\nBagian ini membuat pembaca lebih berhati-hati dalam menilai diri sendiri.','Kisah-kisah pendek memberi contoh bahwa keberhasilan finansial sering ditentukan oleh perilaku sederhana yang konsisten.\n\nIsi buku terasa ringan, tetapi maknanya cukup dalam.','Pembahasan tentang cukup, sabar, dan mengelola ekspektasi menjadi inti yang kuat.\n\nHalaman ini membantu pembaca melihat uang sebagai alat, bukan tujuan mutlak.','Cuplikan ditutup dengan gagasan bahwa ketenangan finansial lahir dari pilihan hidup yang wajar.\n\nBuku ini terasa menenangkan karena menggeser fokus dari mengejar lebih banyak.'],
    'clean-code':['Clean Code langsung menekankan bahwa kode bukan hanya untuk mesin, tetapi juga untuk manusia yang membacanya.\n\nPembaca dibawa melihat bagaimana keputusan kecil dalam menulis kode punya dampak besar.','Robert C. Martin mulai menunjukkan contoh nama variabel dan fungsi yang baik maupun buruk.\n\nBagian ini membuat pembaca ingin langsung mengevaluasi cara menulis kodenya sendiri.','Pembahasan berkembang ke fungsi yang ringkas dan punya tanggung jawab tunggal.\n\nGagasan ini sederhana, tetapi sangat menentukan kualitas proyek jangka panjang.','Buku ini menyentuh pentingnya konsistensi dan penghapusan duplikasi. Kode bersih bukan hasil sulap, melainkan disiplin yang diulang.\n\nBacaan ini terasa praktis sekaligus menantang.','Pesan utamanya makin terasa: kode yang rapi adalah bentuk rasa hormat pada tim dan diri sendiri.\n\nHalaman ini menutup dengan dorongan untuk menulis kode yang lebih jujur.'],
    'mindset':['Mindset membuka pembahasan dengan dua cara pandang utama: fixed mindset dan growth mindset.\n\nPembaca langsung diajak melihat bagaimana keyakinan tentang kemampuan bisa membentuk hidup.','Carol Dweck menjelaskan bahwa orang dengan fixed mindset cenderung takut gagal. Growth mindset melihat tantangan sebagai kesempatan belajar.\n\nPerbedaannya tampak halus, tetapi efeknya sangat besar.','Contoh-contoh dari sekolah, hubungan, dan pekerjaan membuat teori terasa dekat.\n\nBagian ini sering menjadi titik refleksi yang kuat.','Buku ini menunjukkan bahwa mindset bukan label permanen. Seseorang bisa belajar berpindah dan mengubah respons terhadap kesalahan.\n\nIsi bacaan terasa suportif tanpa kehilangan ketegasan.','Growth mindset hadir sebagai latihan yang perlu diulang, bukan sekadar slogan motivasi.\n\nHalaman ini meninggalkan dorongan yang hangat untuk terus berkembang.'],
    'dune':['Dune membuka kisah dengan dunia Arrakis yang keras, misterius, dan penuh ancaman.\n\nPembaca langsung masuk ke cerita yang dipenuhi politik, takdir, dan perebutan kekuasaan.','Paul Atreides diperkenalkan sebagai tokoh muda di tengah ekspektasi besar.\n\nDi sini, skala epik Dune mulai terasa jelas.','Intrik antar keluarga bangsawan membuat cerita semakin tegang. Setiap percakapan menyimpan bahaya tersembunyi.\n\nBagian ini menjaga pembaca tetap waspada.','Penggambaran gurun yang bukan sekadar latar, tetapi bagian hidup dari cerita itu sendiri.\n\nDune membangun dunia dengan sangat kuat.','Tema tentang takdir, kekuasaan, dan perubahan mulai menguat.\n\nPembaca ditinggalkan dengan rasa penasaran yang besar.'],
    'the-alchemist':['The Alchemist dibuka dengan suasana sederhana dan hangat. Santiago mulai mendengarkan mimpi yang terasa lebih besar dari hidupnya.\n\nBuku ini terasa seperti dongeng yang penuh makna.','Pertemuan-pertemuan kecil yang dialami Santiago perlahan mengubah arah perjalanannya.\n\nPembaca diajak percaya bahwa hidup punya bahasa rahasianya sendiri.','Perjalanan fisik Santiago juga menjadi perjalanan batin. Ia mulai belajar tentang keberanian dan keyakinan.\n\nBagian ini membuat buku terasa reflektif tanpa menjadi berat.','Paulo Coelho menanamkan banyak gagasan tentang takdir pribadi dan mengikuti panggilan hati.\n\nHalaman ini terasa tenang dan menguatkan.','Cuplikan ditutup dengan suasana yang penuh harapan.\n\nPenutup ini meninggalkan kesan lembut dan inspiratif.'],
    'midnight-library':['The Midnight Library dibuka dengan rasa hampa yang kuat. Nora mempertanyakan banyak hal sekaligus.\n\nNuansa awalnya sunyi, tetapi membuat pembaca ingin terus mengikuti.','Perpustakaan misterius mulai menjadi ruang kemungkinan. Setiap buku mewakili hidup yang bisa saja dijalani.\n\nPremis ini memberi daya tarik emosional dan filosofis.','Matt Haig menuntun pembaca dari penyesalan menuju rasa ingin memahami hidup lebih jernih.\n\nBagian ini terasa intim dan menyentuh.','Setiap kehidupan alternatif menghadirkan pertanyaan: apa yang membuat hidup bermakna?\n\nPembaca diajak bertanya pada dirinya sendiri.','Harapan mulai terasa lebih nyata. Bukan karena semua masalah hilang, tetapi karena cara memandang hidup mulai berubah.\n\nPenutup ini membuat buku terasa lembut dan menenangkan.'],
    'ikigai':['Ikigai dibuka dengan pengamatan tentang kehidupan yang tenang dan bermakna. Buku ini mengajak pembaca memperlambat langkah.\n\nNada awalnya menenangkan dan reflektif.','Konsep ikigai diperkenalkan sebagai titik temu antara apa yang disukai, dikuasai, dibutuhkan, dan memberi nilai.\n\nPembaca mulai menimbang hidupnya sendiri.','Buku ini membahas kebiasaan kecil, relasi sosial, dan ritme hidup yang seimbang.\n\nBagian ini memberi rasa damai yang khas.','Kisah-kisah dari Jepang memberi warna budaya yang kuat. Ada penghargaan pada hal-hal kecil dan komunitas.\n\nIsi buku terasa lembut namun bermakna.','Pesan utamanya semakin terasa: hidup yang panjang dibangun dari tujuan yang sederhana tetapi konsisten.\n\nHalaman ini meninggalkan perasaan tenang dan penuh arah.']
  };

  const bookChapterTitles = {
    'laut-bercerita':['Mata Laut yang Sunyi','Bisikan di Kota','Pijakan Perlawanan','Kenangan dan Harapan','Akhir yang Menggema'],
    'atomic-habits':['Langkah Kecil Awal','Identitas dan Kebiasaan','Sistem yang Mendukung','Desain Perubahan','Kekuatan Konsistensi'],
    'sapiens':['Lompatan Kognitif','Cerita Kolektif','Revolusi Pertanian','Kepercayaan Bersama','Masa Depan Manusia','Pertanyaan Besar'],
    'psychology-of-money':['Uang dan Emosi','Rasionalitas Luar Biasa','Kekuatan Kebiasaan','Sabar dan Cukup','Ketenangan Finansial'],
    'clean-code':['Kode untuk Manusia','Nama dan Struktur','Fungsi Terbaik','Aturan Kode Bersih','Rasa Hormat pada Kode'],
    'mindset':['Dua Cara Pandang','Takut Gagal','Belajar lewat Pengalaman','Mindset yang Dapat Berubah','Pertumbuhan Berkelanjutan'],
    'dune':['Arrakis yang Keras','Harapan Paul','Intrik Keluarga','Gurun sebagai Karakter','Takdir yang Memanggil'],
    'the-alchemist':['Mimpi Santiago','Petunjuk Perjalanan','Perjalanan Batin','Keyakinan Hati','Makna Pencarian'],
    'midnight-library':['Kehampaan Nora','Perpustakaan Kemungkinan','Hidup Alternatif','Makna Kehidupan','Harapan Baru'],
    'ikigai':['Kehidupan Bermakna','Empat Pilar Ikigai','Keseimbangan Sehari-hari','Kebiasaan Sehat','Tenang dengan Tujuan']
  };

  const defaultChapterTitles = ['Awal Cerita','Bagian Perjalanan','Fokus Konflik','Pencerahan','Penutup'];
  const paymentServiceFee = 1000;
  let currentBookId = 'laut-bercerita';
  let currentBook = null;
  let currentReaderPage = 0;
  let currentReaderAnchorPage = 0;
  let readerReturnPage = 'owned-book-page';
  const purchasedBooks = new Set();

  // ─── UTILITIES ───
  function parseRupiah(v){ return Number(String(v).replace(/[^\d]/g,''))||0; }
  function formatRupiah(v){ return 'Rp '+Number(v).toLocaleString('id-ID'); }
  function formatPage(v){ return Number(v||0).toLocaleString('id-ID'); }

  function showToast(msg, icon='ph-check-circle') {
    const t = document.getElementById('toast');
    t.innerHTML = `<i class="ph ${icon}"></i> ${msg}`;
    t.classList.add('show');
    setTimeout(()=>t.classList.remove('show'), 3000);
  }

  function getBookById(id) {
    const base = homeBooks[id] || recommendedBooks[id] || null;
    if(!base) return null;
    return {...base,...(bookDetails[id]||{})};
  }
  function isBookFree(book) { return Boolean(book && book.isFree); }

  function setCurrentBook(id, book) {
    if(!book) return;
    currentBookId = id;
    currentBook = book;
    updateDetailPage(book);
    updatePaymentSummary(book);
    updateOwnedBookPage(book);
  }

  function createReaderPages(book) {
    return bookReaderPages[currentBookId] || [book.description, 'Cerita berlanjut...', 'Akhir cuplikan.'];
  }

  function getChapterTitle(id, i) {
    const t = bookChapterTitles[id] || defaultChapterTitles;
    return t[i] || `Judul Bab ${i+1}`;
  }

  // ─── UPDATE FUNCTIONS ───
  function updateReaderPage() {
    const pages = createReaderPages(currentBook);
    const total = pages.length;
    const pn = currentReaderPage + 1;
    const totalPg = Number(currentBook.progressTotalPages || currentBook.pages || total);
    const base = Number(currentBook.progressPage || pn);
    const step = Math.max(1, Math.round(totalPg / Math.max(total, 1)));
    const disp = Math.min(totalPg, Math.max(1, base + ((currentReaderPage - currentReaderAnchorPage) * step)));
    const pct = Math.min(100, Math.round((disp/totalPg)*100));

    document.getElementById('reader-book-title').textContent = currentBook.title;
    document.getElementById('reader-book-author').textContent = currentBook.author;
    document.getElementById('reader-progress-fill').style.width = `${pct}%`;
    document.getElementById('reader-percentage-progress').textContent = `${pct}%`;
    document.getElementById('reader-page-progress').textContent = `${formatPage(disp)} / ${formatPage(totalPg)} halaman`;
    document.getElementById('reader-chapter-label').textContent = `Bab ${pn}`;
    document.getElementById('reader-chapter-title').textContent = getChapterTitle(currentBookId, currentReaderPage);
    document.getElementById('reader-book-content').textContent = pages[currentReaderPage];
    document.getElementById('reader-prev-btn').disabled = currentReaderPage === 0;
    document.getElementById('reader-next-btn').disabled = currentReaderPage === total - 1;
  }

  function updateDetailPage(book) {
    document.getElementById('detail-book-cover').src = book.cover;
    document.getElementById('detail-book-cover').alt = book.title;
    document.getElementById('detail-book-title').textContent = book.title;
    document.getElementById('detail-book-author').textContent = book.author;
    document.getElementById('detail-book-description').textContent = book.description || '';
    document.getElementById('detail-book-description2').textContent = book.description2 || '';
    document.getElementById('detail-about-book').textContent = book.aboutBook || book.description;
    document.getElementById('detail-about-author').textContent = book.aboutAuthor || 'Informasi penulis belum tersedia.';
    document.getElementById('detail-review-summary').textContent = book.reviewSummary || '';
    document.getElementById('detail-book-price').textContent = book.price;
    document.getElementById('d-lang').textContent = book.language || 'Indonesia';
    document.getElementById('d-pages').textContent = book.pages || '-';
    document.getElementById('d-year').textContent = book.year || '-';
    document.getElementById('d-pub').textContent = book.publisher || '-';
    document.getElementById('d-breadcrumb-title').textContent = book.title;
    document.getElementById('d-breadcrumb-cat').textContent = book.category || 'Novel';
    // Rating & readers
    const rating = book.rating || '4.8';
    const reviews = book.reviewCount || '1.250';
    const readers = book.readers || '12,5 rb';
    document.getElementById('d-rating').textContent = rating;
    document.getElementById('d-review-count').textContent = reviews;
    document.getElementById('d-tab-review-count').textContent = reviews;
    document.getElementById('d-readers').textContent = readers;
    // Tags
    const tags = (book.tags || ['Novel']).map(t=>`<span class="detail-tag">${t}</span>`).join('');
    document.getElementById('detail-tags').innerHTML = tags;
    // Owned vs buy bar
    const owned = purchasedBooks.has(currentBookId) || book.isFree;
    document.getElementById('detail-owned-bar').style.display = owned ? '' : 'none';
    document.getElementById('detail-buy-bar').style.display = owned ? 'none' : '';
    const btn = document.getElementById('detail-action-button');
    if(btn) btn.innerHTML = isBookFree(book) ? '<i class="ph ph-book-open"></i> Baca Gratis' : '<i class="ph ph-shopping-bag-open"></i> Beli Sekarang';
    // Reset tabs
    switchDetailTab('about', document.querySelector('.detail-tab'));
  }

  function updatePaymentSummary(book) {
    document.getElementById('payment-book-cover').src = book.cover;
    document.getElementById('payment-book-cover').alt = book.title;
    document.getElementById('payment-book-title').textContent = book.title;
    document.getElementById('payment-book-author').textContent = book.author;
    if(isBookFree(book)){
      ['payment-book-price','payment-subtotal','payment-total','payment-total-footer'].forEach(id=>document.getElementById(id).textContent='Gratis');
      document.getElementById('payment-fee').textContent = formatRupiah(0);
      return;
    }
    const sub = parseRupiah(book.price);
    const total = sub + paymentServiceFee;
    document.getElementById('payment-book-price').textContent = formatRupiah(sub);
    document.getElementById('payment-subtotal').textContent = formatRupiah(sub);
    document.getElementById('payment-fee').textContent = formatRupiah(paymentServiceFee);
    document.getElementById('payment-total').textContent = formatRupiah(total);
    document.getElementById('payment-total-footer').textContent = formatRupiah(total);
  }

  function updateOwnedBookPage(book) {
    document.getElementById('owned-book-cover').src = book.cover;
    document.getElementById('owned-book-cover').alt = book.title;
    document.getElementById('owned-book-title').textContent = book.title;
    document.getElementById('owned-book-author').textContent = book.author;
    document.getElementById('owned-book-description').textContent = book.description;
    document.getElementById('owned-breadcrumb-title').textContent = book.title;

    const m = document.querySelectorAll('.owned-meta span');
    if(m[0]) m[0].innerHTML = `<i class="ph-fill ph-star star"></i> ${book.rating||'-'} (${book.reviewCount||'0'} ulasan)`;
    if(m[1]) m[1].innerHTML = `<i class="ph ph-users"></i> ${book.readers||'-'}`;

    const tc = document.getElementById('owned-tags-container');
    if(tc && Array.isArray(book.tags)) tc.innerHTML = book.tags.map(t=>`<span class="owned-tag">${t}</span>`).join('');

    document.getElementById('os-lang').textContent = book.language||'-';
    document.getElementById('os-pages').textContent = book.pages||'-';
    document.getElementById('os-year').textContent = book.year||'-';
    document.getElementById('os-pub').textContent = book.publisher||'-';

    document.getElementById('owned-tab-book').textContent = book.aboutBook||book.description;
    document.getElementById('owned-tab-author').textContent = book.aboutAuthor||book.author;
    document.getElementById('owned-tab-review').textContent = book.reviewSummary||'';

    const rtb = document.querySelector('.owned-tabs .owned-tab:nth-child(3)');
    if(rtb) rtb.innerHTML = `Ulasan (${book.reviewCount||'0'})`;
    const rsv = document.getElementById('review-score-val');
    if(rsv) rsv.textContent = book.rating||'-';
    const rcv = document.getElementById('review-count-val');
    if(rcv) rcv.textContent = book.reviewCount||'0';
    const rn = document.getElementById('reviewer-name');
    if(rn) rn.textContent = book.sampleReviewer||'Pembaca';
    const rt = document.getElementById('reviewer-text');
    if(rt) rt.textContent = book.sampleReview||'';

    document.querySelectorAll('.owned-tab').forEach(t=>t.classList.remove('active'));
    const ft = document.querySelector('.owned-tab');
    if(ft) ft.classList.add('active');
    document.querySelectorAll('.owned-tab-panel').forEach(p=>p.classList.remove('active'));
    document.getElementById('owned-tab-book').classList.add('active');
  }

  // ─── NAVIGATION ───
  function showPage(pageId) {
    document.querySelectorAll('.page').forEach(p=>p.classList.remove('active'));
    const t = document.getElementById(pageId);
    if(t){ t.classList.add('active'); window.scrollTo({top:0,behavior:'smooth'}); }
    document.querySelectorAll('.nav-item').forEach(n=>{
      n.classList.remove('active-nav');
      if(n.getAttribute('onclick')&&n.getAttribute('onclick').includes(pageId)) n.classList.add('active-nav');
    });
    document.querySelectorAll('.nav-link').forEach(n=>{
      n.classList.remove('active');
      if(n.getAttribute('onclick')&&n.getAttribute('onclick').includes(pageId)) n.classList.add('active');
    });
    // Toggle account page state based on login
    if(pageId === 'account-page') {
      const guest = document.getElementById('account-guest');
      const logged = document.getElementById('account-logged');
      if(isLoggedIn) { guest.style.display='none'; logged.style.display=''; }
      else { guest.style.display=''; logged.style.display='none'; }
    }
    // Toggle fav page state based on login
    if(pageId === 'fav-page') {
      const guest = document.getElementById('fav-guest');
      const logged = document.getElementById('fav-logged');
      if(isLoggedIn) { guest.style.display='none'; logged.style.display=''; }
      else { guest.style.display=''; logged.style.display='none'; }
    }
  }

  function updateNav(el, pageId) {
    document.querySelectorAll('.nav-item').forEach(n=>n.classList.remove('active-nav'));
    el.classList.add('active-nav');
    showPage(pageId);
  }

  // ─── BOOK ACTIONS ───
  function openBookDetail(bookId) {
    const book = getBookById(bookId);
    if(!book) return;
    setCurrentBook(bookId, book);
    showPage('detail-page');
  }

  function openRecommendedBook(bookId) { openBookDetail(bookId); }

  function openFavoriteBook(bookId) {
    const book = getBookById(bookId);
    if(!book) return;
    purchasedBooks.add(bookId);
    setCurrentBook(bookId, book);
    readerReturnPage = 'fav-page';
    currentReaderPage = 0; currentReaderAnchorPage = 0;
    updateReaderPage();
    showPage('reader-page');
  }

  function openRackBook(bookId, savedPage=0) {
    const book = getBookById(bookId);
    if(!book) return;
    purchasedBooks.add(bookId);
    setCurrentBook(bookId, book);
    readerReturnPage = 'rak-page';
    const pages = createReaderPages(book);
    currentReaderPage = Math.max(0, Math.min(savedPage, pages.length-1));
    currentReaderAnchorPage = currentReaderPage;
    updateReaderPage();
    showPage('reader-page');
  }

  function openReaderCurrentBook() {
    if(!isBookFree(currentBook) && !purchasedBooks.has(currentBookId)){
      showToast('Buku ini perlu dibeli terlebih dahulu.', 'ph-warning');
      showPage('payment-page'); return;
    }
    readerReturnPage = 'owned-book-page';
    currentReaderPage = 0; currentReaderAnchorPage = 0;
    updateReaderPage();
    showPage('reader-page');
  }

  function leaveReader() { showPage(readerReturnPage); }

  function changeReaderPage(step) {
    const pages = createReaderPages(currentBook);
    const next = currentReaderPage + step;
    if(next < 0 || next >= pages.length) return;
    currentReaderPage = next;
    updateReaderPage();
  }

  // ─── PAYMENT ───
  function handleBuyNow() {
    updatePaymentSummary(currentBook);
    if(isBookFree(currentBook)){
      purchasedBooks.add(currentBookId);
      readerReturnPage = 'detail-page';
      currentReaderPage = 0; currentReaderAnchorPage = 0;
      updateReaderPage();
      showPage('reader-page'); return;
    }
    if(!isLoggedIn){
      showToast('Silakan login terlebih dahulu.', 'ph-warning');
      pendingRedirectPage = 'payment-page';
      showPage('login-page');
    } else {
      showPage('payment-page');
    }
  }

  function confirmPayment() {
    purchasedBooks.add(currentBookId);
    updateOwnedBookPage(currentBook);
    showToast('Pembayaran sedang diverifikasi!', 'ph-check-circle');
    setTimeout(()=>showPage('owned-book-page'), 800);
  }

  function downloadBook() {
    showToast('E-book sedang diproses untuk diunduh.', 'ph-download-simple');
  }

  // ─── PAYMENT METHODS ───
  function switchPaymentMethod(method, el) {
    document.querySelectorAll('.method-tab').forEach(t=>t.classList.remove('active'));
    el.classList.add('active');
    document.querySelectorAll('.method-panel').forEach(p=>p.classList.remove('active'));
    const panel = document.getElementById('payment-panel-'+method);
    if(panel) panel.classList.add('active');
    if(method==='qris') renderQrisCode(selectedWallet);
  }

  function selectWallet(wallet, el) {
    selectedWallet = wallet;
    document.querySelectorAll('#payment-panel-qris .wallet-item').forEach(i=>i.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('selected-wallet-chip').textContent = 'Metode aktif: '+wallet;
    renderQrisCode(wallet);
  }

  function selectVirtualAccount(bank, el) {
    selectedVABank = bank;
    document.querySelectorAll('.va-item').forEach(i=>i.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('va-bank-name').textContent = bank+' Virtual Account';
    document.getElementById('va-number').textContent = vaNumbers[bank];
  }

  function copyVirtualAccount() {
    const num = document.getElementById('va-number').textContent;
    if(navigator.clipboard) {
      navigator.clipboard.writeText(num).then(()=>showToast('Nomor VA berhasil disalin!', 'ph-copy'));
    } else {
      showToast('Salin manual: '+num, 'ph-copy');
    }
  }

  function renderQrisCode(wallet) {
    const t = document.getElementById('qris-code');
    if(!t) return;
    t.innerHTML = '';
    if(typeof QRCode==='undefined'){
      t.innerHTML='<div style="display:flex;align-items:center;justify-content:center;height:100%;font-size:12px;color:#64748b;text-align:center;padding:12px;">QR code gagal dimuat</div>';
      return;
    }
    new QRCode(t,{ text:qrisPayloads[wallet]||qrisPayloads['GoPay'], width:144, height:144, colorDark:'#111827', colorLight:'#ffffff', correctLevel:QRCode.CorrectLevel.M });
  }

  // ─── AUTH ───
  function performLogin() {
    isLoggedIn = true;
    const email = document.getElementById('login-email').value || 'user@gmail.com';
    const profile = getProfileByEmail(email);
    updateProfile(profile.name, profile.email, profile.photoUrl);
    showToast(`Selamat datang, ${profile.name}!`, 'ph-user-circle');
    setTimeout(()=>showPage(pendingRedirectPage), 600);
  }

  function getProfileByEmail(email) {
    const e = (email||'').trim().toLowerCase();
    if(e==='amanda@gmail.com') return {name:'Amanda',email:'amanda@gmail.com',photoUrl:'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=200&q=80'};
    return {name:'User',email:e||'user@gmail.com',photoUrl:'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200'};
  }

  function updateProfile(name, email, photoUrl) {
    const loginBtn = document.querySelector('.btn-login');
    loginBtn.innerHTML = `<img src="${photoUrl}" style="width:26px;height:26px;border-radius:50%;object-fit:cover;border:2px solid rgba(255,255,255,0.4);"> ${name}`;
    loginBtn.onclick = ()=>showPage('account-page');
    document.querySelectorAll('.profile-img').forEach(el=>el.src=photoUrl);
    document.querySelector('.profile-name').textContent = name;
    document.querySelector('.profile-email').textContent = email;
  }

  function logout() {
    isLoggedIn = false;
    const loginBtn = document.querySelector('.btn-login');
    loginBtn.innerHTML = '<i class="ph ph-user-circle" style="font-size:18px;"></i> Login';
    loginBtn.onclick = ()=>showPage('login-page');
    showToast('Anda telah keluar.', 'ph-sign-out');
    setTimeout(()=>showPage('login-page'), 600);
  }

  function switchOwnedTab(name, el) {
    document.querySelectorAll('.owned-tab').forEach(t=>t.classList.remove('active'));
    el.classList.add('active');
    document.querySelectorAll('.owned-tab-panel').forEach(p=>p.classList.remove('active'));
    const panel = document.getElementById('owned-tab-'+name);
    if(panel) panel.classList.add('active');
  }

  // ─── DETAIL TABS ───
  function switchDetailTab(name, el) {
    document.querySelectorAll('.detail-tab').forEach(t=>t.classList.remove('active'));
    if(el) el.classList.add('active');
    document.querySelectorAll('.detail-tab-panel').forEach(p=>p.classList.remove('active'));
    const panel = document.getElementById('detail-tab-'+name);
    if(panel) panel.classList.add('active');
  }

  function toggleDetailFav(btn) {
    const icon = btn.querySelector('i');
    const sub = btn.querySelector('.btn-fav-sub');
    if(icon.classList.contains('ph-fill')) {
      icon.classList.remove('ph-fill'); icon.classList.add('ph');
      sub.textContent = '25,4 rb orang menyukai buku ini';
      showToast('Dihapus dari favorit', 'ph-heart-break');
    } else {
      icon.classList.remove('ph'); icon.classList.add('ph-fill');
      sub.textContent = '25,4 rb orang menyukai buku ini';
      showToast('Ditambahkan ke favorit!', 'ph-heart');
    }
  }

  // ─── PASSWORD TOGGLE ───
  function togglePassword() {
    const input = document.getElementById('login-password');
    const icon = document.getElementById('eye-icon');
    if(input.type === 'password') {
      input.type = 'text';
      icon.className = 'ph ph-eye-slash';
    } else {
      input.type = 'password';
      icon.className = 'ph ph-eye';
    }
  }

  // ─── HOME FILTERING ───
  let activeCategoryFilter = '';
  let activeSearchFilter = '';

  function filterByCategory(cat, el) {
    activeCategoryFilter = cat;
    document.querySelectorAll('.home-cat-pill').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    applyHomeFilters();
  }

  function filterHomeBooks(query) {
    activeSearchFilter = query.toLowerCase().trim();
    applyHomeFilters();
  }

  function applyHomeFilters() {
    const cards = document.querySelectorAll('#home-books-grid .book-card');
    let visible = 0;
    cards.forEach(card => {
      const cat = card.dataset.category || '';
      const title = card.dataset.title || '';
      const author = card.dataset.author || '';
      const catMatch = !activeCategoryFilter || cat === activeCategoryFilter;
      const searchMatch = !activeSearchFilter || title.includes(activeSearchFilter) || author.includes(activeSearchFilter);
      const show = catMatch && searchMatch;
      card.style.display = show ? '' : 'none';
      if(show) visible++;
    });
  }

  // ─── INIT ───
  currentBook = getBookById(currentBookId);
  setCurrentBook(currentBookId, currentBook);
  updateReaderPage();
  renderQrisCode(selectedWallet);

  // Ripple effect on buttons
  document.addEventListener('click', e => {
    const btn = e.target.closest('.btn-buy, .btn-submit, .hero-cta, .btn-pay, .owned-btn-primary');
    if(!btn) return;
    const ripple = document.createElement('span');
    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    ripple.style.cssText = `position:absolute;width:${size}px;height:${size}px;left:${e.clientX-rect.left-size/2}px;top:${e.clientY-rect.top-size/2}px;border-radius:50%;background:rgba(255,255,255,0.35);animation:ripple 0.6s ease-out forwards;pointer-events:none;`;
    btn.style.position = 'relative';
    btn.style.overflow = 'hidden';
    btn.appendChild(ripple);
    setTimeout(()=>ripple.remove(), 700);
  });
</script>
</body>
</html>
