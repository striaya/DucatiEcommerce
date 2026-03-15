<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — @yield('title', 'Dashboard') | Ducati</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow+Condensed:wght@300;400;500;600;700&family=Barlow:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --red: #E00;
            --red-dim: #990000;
            --bg: #0a0a0a;
            --surface: #111111;
            --surface2: #161616;
            --surface3: #1c1c1c;
            --border: #242424;
            --border-bright: #333;
            --text: #f0f0f0;
            --text-dim: #888;
            --text-muted: #555;
            --sidebar-w: 240px;
            --green: #22c55e;
            --yellow: #eab308;
            --blue: #3b82f6;
            --orange: #f97316;
        }

        body {
            font-family: 'Barlow', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 24px 20px 20px;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-logo .brand {
            font-family: 'Bebas Neue';
            font-size: 28px;
            letter-spacing: 4px;
            color: var(--text);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sidebar-logo .brand span { color: var(--red); }

        .sidebar-logo .admin-badge {
            font-family: 'Barlow Condensed';
            font-size: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--text-dim);
            margin-top: 2px;
        }

        .sidebar-nav {
            padding: 16px 0;
            flex: 1;
        }

        .nav-section-label {
            font-family: 'Barlow Condensed';
            font-size: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 8px 20px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            color: var(--text-dim);
            text-decoration: none;
            font-family: 'Barlow Condensed';
            font-size: 14px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            transition: all 0.15s;
            border-left: 3px solid transparent;
            position: relative;
        }

        .nav-item:hover {
            color: var(--text);
            background: var(--surface2);
        }

        .nav-item.active {
            color: var(--red);
            background: rgba(238,0,0,0.06);
            border-left-color: var(--red);
        }

        .nav-item i {
            width: 16px;
            font-size: 13px;
            text-align: center;
        }

        .nav-item .badge-count {
            margin-left: auto;
            background: var(--red);
            color: white;
            font-size: 10px;
            padding: 1px 6px;
            border-radius: 10px;
            font-family: 'Barlow Condensed';
        }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .sidebar-user .avatar {
            width: 32px; height: 32px;
            background: var(--red);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Bebas Neue';
            font-size: 14px;
            color: white;
            flex-shrink: 0;
        }

        .sidebar-user .info .name {
            font-family: 'Barlow Condensed';
            font-size: 13px;
            letter-spacing: 1px;
            color: var(--text);
        }

        .sidebar-user .info .role {
            font-size: 10px;
            letter-spacing: 2px;
            color: var(--red);
            font-family: 'Barlow Condensed';
            text-transform: uppercase;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 8px 12px;
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-dim);
            font-family: 'Barlow Condensed';
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-logout:hover {
            border-color: var(--red);
            color: var(--red);
        }

        /* MAIN CONTENT */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 32px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title {
            font-family: 'Bebas Neue';
            font-size: 20px;
            letter-spacing: 3px;
            color: var(--text);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-link {
            font-family: 'Barlow Condensed';
            font-size: 12px;
            letter-spacing: 2px;
            color: var(--text-dim);
            text-decoration: none;
            text-transform: uppercase;
            transition: color 0.15s;
        }

        .topbar-link:hover { color: var(--text); }

        .content {
            padding: 32px;
            flex: 1;
        }

        .page-header {
            margin-bottom: 28px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
        }

        .page-header-left .label {
            font-family: 'Barlow Condensed';
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 4px;
        }

        .page-header-left h1 {
            font-family: 'Bebas Neue';
            font-size: 36px;
            letter-spacing: 3px;
            line-height: 1;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 20px 24px;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 3px; height: 100%;
            background: var(--accent, var(--red));
        }

        .stat-card .stat-label {
            font-family: 'Barlow Condensed';
            font-size: 11px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--text-dim);
            margin-bottom: 8px;
        }

        .stat-card .stat-value {
            font-family: 'Bebas Neue';
            font-size: 36px;
            letter-spacing: 2px;
            line-height: 1;
            color: var(--text);
        }

        .stat-card .stat-sub {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 4px;
            font-family: 'Barlow Condensed';
            letter-spacing: 1px;
        }

        .stat-card .stat-icon {
            position: absolute;
            right: 20px; top: 50%;
            transform: translateY(-50%);
            font-size: 32px;
            opacity: 0.07;
            color: var(--text);
        }

        .table-card {
            background: var(--surface);
            border: 1px solid var(--border);
        }

        .table-card-header {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table-card-title {
            font-family: 'Bebas Neue';
            font-size: 16px;
            letter-spacing: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            font-family: 'Barlow Condensed';
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-dim);
            padding: 12px 24px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            background: var(--surface2);
            white-space: nowrap;
        }

        tbody td {
            padding: 12px 24px;
            font-size: 13px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        tbody tr:last-child td { border-bottom: none; }

        tbody tr:hover { background: var(--surface2); }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-family: 'Barlow Condensed';
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 2px;
        }

        .badge-green  { background: rgba(34,197,94,0.12);  color: #22c55e; }
        .badge-red    { background: rgba(238,0,0,0.12);    color: #ff4444; }
        .badge-yellow { background: rgba(234,179,8,0.12);  color: #eab308; }
        .badge-blue   { background: rgba(59,130,246,0.12); color: #3b82f6; }
        .badge-gray   { background: rgba(136,136,136,0.12);color: #888; }
        .badge-orange { background: rgba(249,115,22,0.12); color: #f97316; }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: 'Barlow Condensed';
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s;
        }

        .btn-primary { background: var(--red); color: white; }
        .btn-primary:hover { background: #cc0000; }

        .btn-ghost {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-dim);
        }
        .btn-ghost:hover { border-color: var(--text-dim); color: var(--text); }

        .btn-sm { font-size: 11px; padding: 5px 12px; letter-spacing: 1.5px; }

        .btn-danger { background: rgba(238,0,0,0.1); border: 1px solid rgba(238,0,0,0.3); color: #ff4444; }
        .btn-danger:hover { background: var(--red); color: white; }

        .btn-success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3); color: #22c55e; }
        .btn-success:hover { background: #22c55e; color: white; }

        .form-control {
            width: 100%;
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 9px 14px;
            font-family: 'Barlow', sans-serif;
            font-size: 13px;
            transition: border-color 0.15s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--red);
        }

        select.form-control { cursor: pointer; }

        .form-label {
            display: block;
            font-family: 'Barlow Condensed';
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-dim);
            margin-bottom: 6px;
        }

        .form-group { margin-bottom: 16px; }

        .filter-bar {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-bar .form-control {
            width: auto;
            min-width: 140px;
        }

        .pagination-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            font-family: 'Barlow Condensed';
            font-size: 12px;
            letter-spacing: 1px;
            color: var(--text-dim);
        }

        .pagination-links a, .pagination-links span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px; height: 32px;
            font-family: 'Barlow Condensed';
            font-size: 13px;
            color: var(--text-dim);
            text-decoration: none;
            border: 1px solid transparent;
            transition: all 0.15s;
        }

        .pagination-links a:hover { color: var(--text); border-color: var(--border); }
        .pagination-links span.active { color: var(--red); border-color: var(--red); }

        .flash {
            padding: 12px 20px;
            margin-bottom: 20px;
            font-family: 'Barlow Condensed';
            font-size: 13px;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .flash-success { background: rgba(34,197,94,0.1); border-left: 3px solid #22c55e; color: #22c55e; }
        .flash-error   { background: rgba(238,0,0,0.1);   border-left: 3px solid var(--red); color: #ff4444; }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            align-items: start;
        }

        .info-block {
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 24px;
            margin-bottom: 16px;
        }

        .info-block-title {
            font-family: 'Bebas Neue';
            font-size: 14px;
            letter-spacing: 2px;
            color: var(--text-dim);
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-block-title i { color: var(--red); font-size: 12px; }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid var(--border);
            font-size: 13px;
        }

        .info-row:last-child { border-bottom: none; }

        .info-row-label {
            font-family: 'Barlow Condensed';
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-dim);
        }

        .info-row-val {
            font-family: 'Barlow Condensed';
            font-size: 14px;
            letter-spacing: 0.5px;
            color: var(--text);
            text-align: right;
        }

        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: var(--text-muted);
        }

        .empty-state i { font-size: 32px; margin-bottom: 12px; opacity: 0.3; }
        .empty-state p { font-family: 'Barlow Condensed'; letter-spacing: 1px; font-size: 13px; }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: var(--border-bright); }
        ::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <a href="/admin" class="brand">•<span>DUCATI</span></a>
        <div class="admin-badge">Control Panel</div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Overview</div>
        <a href="/admin" class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high"></i>Dashboard
        </a>

        <div class="nav-section-label" style="margin-top:8px">Manajemen</div>
        <a href="/admin/users" class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i>Users & KYC
        </a>
        <a href="/admin/products" class="nav-item {{ Request::is('admin/products*') ? 'active' : '' }}">
            <i class="fa-solid fa-motorcycle"></i>Products
        </a>
        <a href="/admin/orders" class="nav-item {{ Request::is('admin/orders*') ? 'active' : '' }}">
            <i class="fa-solid fa-receipt"></i>Orders
        </a>
        <a href="/admin/credits" class="nav-item {{ Request::is('admin/credits*') ? 'active' : '' }}">
            <i class="fa-solid fa-landmark"></i>Credits
        </a>

        <div class="nav-section-label" style="margin-top:8px">Lainnya</div>
        <a href="/products" class="nav-item" target="_blank">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>Lihat Toko
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="avatar">{{ strtoupper(substr(Auth::user()->full_name, 0, 1)) }}</div>
            <div class="info">
                <div class="name">{{ Auth::user()->full_name }}</div>
                <div class="role">Administrator</div>
            </div>
        </div>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fa-solid fa-right-from-bracket"></i>Keluar
            </button>
        </form>
    </div>
</aside>

<div class="main">
    <div class="topbar">
        <div class="topbar-title">@yield('topbar-title', 'Dashboard')</div>
        <div class="topbar-right">
            <span style="font-family:'Barlow Condensed';font-size:12px;letter-spacing:1px;color:var(--text-dim)">
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="flash flash-success">
                <i class="fa-solid fa-circle-check"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="flash flash-error">
                <i class="fa-solid fa-circle-xmark"></i>{{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</div>

</body>
</html>
