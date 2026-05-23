<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PolLapor Admin')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --navy: #1A237E;
            --navy-light: #283593;
            --accent: #FF6F00;
            --bg: #F5F6FA;
            --card: #FFFFFF;
            --text: #111827;
            --text-muted: #6B7280;
            --border: #E5E7EB;
            --success: #2E7D32;
            --danger: #D32F2F;
            --warning: #F57C00;
            --info: #1565C0;
        }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

        /* ─── Sidebar ─────────────────── */
        .layout { display: flex; min-height: 100vh; }
        .sidebar {
            width: 260px; background: var(--navy); color: #fff;
            padding: 0; position: fixed; top: 0; left: 0; bottom: 0;
            display: flex; flex-direction: column; z-index: 50;
        }
        .sidebar-brand {
            padding: 24px 20px; font-size: 20px; font-weight: 800;
            border-bottom: 1px solid rgba(255,255,255,.1);
            display: flex; align-items: center; gap: 10px;
        }
        .sidebar-brand span { color: var(--accent); }
        .sidebar-nav { padding: 16px 0; flex: 1; overflow-y: auto; }
        .sidebar-nav a {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 20px; color: rgba(255,255,255,.7);
            text-decoration: none; font-size: 14px; font-weight: 500;
            transition: all .2s; border-left: 3px solid transparent;
        }
        .sidebar-nav a:hover, .sidebar-nav a.active {
            background: rgba(255,255,255,.08); color: #fff;
            border-left-color: var(--accent);
        }
        .sidebar-nav a .icon { width: 20px; text-align: center; font-size: 16px; }
        .sidebar-section {
            padding: 8px 20px; font-size: 11px; text-transform: uppercase;
            letter-spacing: 1px; color: rgba(255,255,255,.35); margin-top: 8px;
        }
        .sidebar-user {
            padding: 16px 20px; border-top: 1px solid rgba(255,255,255,.1);
            font-size: 13px;
        }
        .sidebar-user .name { font-weight: 600; }
        .sidebar-user .role { color: rgba(255,255,255,.5); font-size: 12px; }

        /* ─── Main ────────────────────── */
        .main { margin-left: 260px; flex: 1; }
        .topbar {
            background: var(--card); border-bottom: 1px solid var(--border);
            padding: 16px 32px; display: flex; justify-content: space-between; align-items: center;
            position: sticky; top: 0; z-index: 40;
        }
        .topbar h1 { font-size: 18px; font-weight: 700; }
        .content { padding: 24px 32px; }

        /* ─── Cards ───────────────────── */
        .card {
            background: var(--card); border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,.06); border: 1px solid var(--border);
            overflow: hidden;
        }
        .card-header {
            padding: 16px 20px; border-bottom: 1px solid var(--border);
            font-weight: 700; font-size: 15px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .card-body { padding: 20px; }

        /* ─── Stats Grid ──────────────── */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .stat-card {
            background: var(--card); border-radius: 12px; padding: 20px;
            border: 1px solid var(--border); text-align: center;
        }
        .stat-card .value { font-size: 32px; font-weight: 800; color: var(--navy); }
        .stat-card .label { font-size: 13px; color: var(--text-muted); margin-top: 4px; }

        /* ─── Table ───────────────────── */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        table th {
            padding: 12px 16px; text-align: left; background: #F9FAFB;
            font-weight: 600; font-size: 12px; text-transform: uppercase;
            letter-spacing: .5px; color: var(--text-muted); border-bottom: 2px solid var(--border);
        }
        table td { padding: 12px 16px; border-bottom: 1px solid var(--border); }
        table tr:hover { background: #F9FAFB; }

        /* ─── Badges ──────────────────── */
        .badge {
            display: inline-block; padding: 4px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .3px;
        }
        .badge-yellow { background: #FEF3C7; color: #92400E; }
        .badge-blue { background: #DBEAFE; color: #1E40AF; }
        .badge-green { background: #D1FAE5; color: #065F46; }
        .badge-orange { background: #FFEDD5; color: #9A3412; }
        .badge-red { background: #FEE2E2; color: #991B1B; }
        .badge-gray { background: #F3F4F6; color: #374151; }

        /* ─── Buttons ─────────────────── */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 10px 18px; border-radius: 8px; font-size: 14px;
            font-weight: 600; cursor: pointer; border: none; text-decoration: none;
            transition: all .2s;
        }
        .btn-primary { background: var(--navy); color: #fff; }
        .btn-primary:hover { background: var(--navy-light); }
        .btn-success { background: var(--success); color: #fff; }
        .btn-success:hover { opacity: .9; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-danger:hover { opacity: .9; }
        .btn-warning { background: var(--warning); color: #fff; }
        .btn-warning:hover { opacity: .9; }
        .btn-outline {
            background: transparent; color: var(--navy);
            border: 1.5px solid var(--border);
        }
        .btn-outline:hover { border-color: var(--navy); }
        .btn-sm { padding: 6px 12px; font-size: 12px; }

        /* ─── Forms ───────────────────── */
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; }
        .form-control {
            width: 100%; padding: 10px 14px; border: 1.5px solid var(--border);
            border-radius: 8px; font-size: 14px; font-family: inherit;
            transition: border-color .2s;
        }
        .form-control:focus { outline: none; border-color: var(--navy); }
        select.form-control { appearance: none; background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 12px center; padding-right: 36px; }

        /* ─── Alert ───────────────────── */
        .alert {
            padding: 14px 18px; border-radius: 8px; font-size: 14px;
            margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
        }
        .alert-success { background: #D1FAE5; color: #065F46; }
        .alert-error { background: #FEE2E2; color: #991B1B; }

        /* ─── Filter bar ──────────────── */
        .filter-bar {
            display: flex; gap: 12px; align-items: center; margin-bottom: 20px; flex-wrap: wrap;
        }
        .filter-bar .form-control { width: auto; min-width: 160px; }

        /* ─── Timeline ────────────────── */
        .timeline-item { display: flex; gap: 12px; margin-bottom: 16px; }
        .timeline-dot {
            width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; color: #fff; font-weight: 700;
        }
        .timeline-body {
            flex: 1; background: #F8FAFC; border-radius: 8px;
            padding: 12px; border: 1px solid var(--border);
        }
        .timeline-body .meta { font-size: 11px; color: var(--text-muted); margin-bottom: 4px; }
        .timeline-body .msg { font-size: 13px; line-height: 1.5; }

        /* ─── Pagination ──────────────── */
        .pagination { display: flex; gap: 4px; justify-content: center; margin-top: 20px; }
        .pagination a, .pagination span {
            padding: 8px 14px; border-radius: 6px; font-size: 13px;
            text-decoration: none; border: 1px solid var(--border);
            color: var(--text-muted);
        }
        .pagination a:hover { background: var(--navy); color: #fff; border-color: var(--navy); }
        .pagination .active { background: var(--navy); color: #fff; border-color: var(--navy); }

        /* ─── Utilities ───────────────── */
        .text-muted { color: var(--text-muted); }
        .text-sm { font-size: 13px; }
        .text-center { text-align: center; }
        .mt-2 { margin-top: 8px; }
        .mt-4 { margin-top: 16px; }
        .mb-4 { margin-bottom: 16px; }
        .flex { display: flex; }
        .gap-2 { gap: 8px; }
        .gap-4 { gap: 16px; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 250px; }

        @media print {
            .sidebar, .topbar, .btn, .filter-bar, .pagination { display: none !important; }
            .main { margin-left: 0 !important; }
            .content { padding: 0 !important; }
        }
    </style>
</head>
<body>
    <div class="layout">
        {{-- Sidebar --}}
        <aside class="sidebar">
            <div class="sidebar-brand">
                🏛️ Pol<span>Lapor</span>
            </div>
            <nav class="sidebar-nav">
                <div class="sidebar-section">Menu Utama</div>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="icon">📋</span> Dashboard Laporan
                </a>
                <a href="{{ route('eskalasi.index') }}" class="{{ request()->routeIs('eskalasi.*') ? 'active' : '' }}">
                    <span class="icon">⚠️</span> Eskalasi
                </a>

                @if(auth()->user()->isKajur())
                <div class="sidebar-section">Kajur</div>
                <a href="{{ route('kajur.index') }}" class="{{ request()->routeIs('kajur.*') ? 'active' : '' }}">
                    <span class="icon">✅</span> Persetujuan
                </a>
                @endif

                <div class="sidebar-section">Administrasi</div>
                <a href="{{ route('berita-acara.index') }}" class="{{ request()->routeIs('berita-acara.*') ? 'active' : '' }}">
                    <span class="icon">📄</span> Berita Acara
                </a>

                <div class="sidebar-section">Monitoring</div>
                <a href="{{ route('statistik.index') }}" class="{{ request()->routeIs('statistik.index') ? 'active' : '' }}">
                    <span class="icon">📊</span> Statistik
                </a>
                <a href="{{ route('statistik.performa') }}" class="{{ request()->routeIs('statistik.performa') ? 'active' : '' }}">
                    <span class="icon">👷</span> Performa Teknisi
                </a>
            </nav>
            <div class="sidebar-user">
                <div class="name">{{ auth()->user()->nama_lengkap }}</div>
                <div class="role">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</div>
                <form action="{{ route('logout') }}" method="POST" style="margin-top:8px;">
                    @csrf
                    <button type="submit" class="btn btn-outline btn-sm" style="color:#fff;border-color:rgba(255,255,255,.2);width:100%;justify-content:center;">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="main">
            <div class="topbar">
                <h1>@yield('page-title', 'Dashboard')</h1>
                <div class="text-sm text-muted">{{ now()->translatedFormat('l, d F Y') }}</div>
            </div>
            <div class="content">
                {{-- Flash messages --}}
                @if(session('success'))
                    <div class="alert alert-success">✅ {{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error">❌ {{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-error">
                        ❌ {{ $errors->first() }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
