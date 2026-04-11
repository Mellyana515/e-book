<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Ebook Store Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --sidebar-bg: #1e1b4b;
            --sidebar-text: #c7d2fe;
            --sidebar-active: #4f46e5;
        }
        body { background-color: #f1f5f9; }
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh;
            width: var(--sidebar-width); background: var(--sidebar-bg);
            z-index: 1000; overflow-y: auto; transition: transform 0.3s;
        }
        .sidebar-brand {
            padding: 1.5rem 1.25rem; color: white; font-size: 1.2rem;
            font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; gap: 0.5rem;
        }
        .sidebar-nav { padding: 1rem 0; }
        .sidebar-section { padding: 0.5rem 1.25rem; font-size: 0.7rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.1em; color: #6366f1; margin-top: 0.5rem; }
        .sidebar-link {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.65rem 1.25rem; color: var(--sidebar-text);
            text-decoration: none; font-size: 0.9rem; transition: all 0.2s;
        }
        .sidebar-link:hover { background: rgba(255,255,255,0.08); color: white; }
        .sidebar-link.active { background: var(--sidebar-active); color: white; border-radius: 0 25px 25px 0; margin-right: 1rem; }
        .sidebar-link i { font-size: 1.1rem; width: 20px; text-align: center; }
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; }
        .top-bar {
            background: white; padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0;
            display: flex; justify-content: space-between; align-items: center;
            position: sticky; top: 0; z-index: 100; box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .content-area { padding: 1.5rem; }
        .stat-card { border: none; border-radius: 12px; overflow: hidden; }
        .stat-icon { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
        .badge-pending { background-color: #fef3c7; color: #92400e; }
        .badge-approved { background-color: #d1fae5; color: #065f46; }
        .badge-rejected { background-color: #fee2e2; color: #991b1b; }
        .badge-published { background-color: #d1fae5; color: #065f46; }
        .badge-draft { background-color: #f3f4f6; color: #374151; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-book-half"></i>
            <span>Ebook Store</span>
        </div>
        <nav class="sidebar-nav">
            <div class="sidebar-section">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <div class="sidebar-section mt-2">Catalog</div>
            <a href="{{ route('admin.ebooks.index') }}" class="sidebar-link {{ request()->routeIs('admin.ebooks.*') ? 'active' : '' }}">
                <i class="bi bi-journal-richtext"></i> Ebooks
            </a>

            <div class="sidebar-section mt-2">Commerce</div>
            <a href="{{ route('admin.payments.index') }}" class="sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <i class="bi bi-credit-card"></i> Payments
            </a>

            <div class="sidebar-section mt-2">Users</div>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Users
            </a>

            <div class="sidebar-section mt-2">Site</div>
            <a href="{{ route('home') }}" class="sidebar-link">
                <i class="bi bi-globe"></i> View Site
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link border-0 bg-transparent w-100 text-start" style="color: #f87171;">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-outline-secondary d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="bi bi-list"></i>
                </button>
                <h5 class="mb-0 fw-semibold text-dark">@yield('page-title', 'Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small"><i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}</span>
            </div>
        </div>

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
