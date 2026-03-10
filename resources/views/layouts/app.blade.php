<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DUCATI — @yield('title', 'The Art of Speed')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:ital,wght@0,300;0,400;0,500;0,600;1,300&family=Barlow+Condensed:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --red: #E00000;
            --red-dark: #A50000;
            --red-glow: rgba(224,0,0,0.15);
            --black: #0A0A0A;
            --surface: #111111;
            --surface2: #181818;
            --surface3: #1F1F1F;
            --border: rgba(255,255,255,0.07);
            --border-red: rgba(224,0,0,0.3);
            --text: #F0F0F0;
            --text-muted: #888;
            --text-dim: #555;
            --gold: #C9A84C;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: var(--black);
            color: var(--text);
            font-family: 'Barlow', sans-serif;
            font-weight: 300;
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 9999;
            opacity: 0.4;
        }

        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(10,10,10,0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            height: 64px;
            display: flex;
            align-items: center;
        }
        .navbar-inner {
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .nav-logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 28px;
            letter-spacing: 4px;
            color: var(--red);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nav-logo-dot {
            width: 6px;
            height: 6px;
            background: var(--red);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
        }
        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 13px;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: color 0.2s;
        }
        .nav-links a:hover { color: var(--text); }
        .nav-links a.active { color: var(--red); }
        .nav-btn {
            background: var(--red);
            color: white !important;
            padding: 8px 20px;
            font-family: 'Barlow Condensed', sans-serif !important;
            font-size: 12px !important;
            letter-spacing: 2px !important;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            transition: background 0.2s !important;
            text-decoration: none;
            display: inline-block;
        }
        .nav-btn:hover { background: var(--red-dark) !important; color: white !important; }
        .nav-btn-ghost {
            background: transparent;
            border: 1px solid var(--border-red);
            color: var(--red) !important;
            padding: 7px 20px;
        }
        .nav-btn-ghost:hover { background: var(--red-glow) !important; }
        .nav-user {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 13px;
            letter-spacing: 1px;
        }
        .nav-divider {
            width: 1px;
            height: 16px;
            background: var(--border);
        }
        .cart-badge {
            background: var(--red);
            color: white;
            font-size: 10px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 4px;
        }

        .flash-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 16px 32px 0;
        }
        .flash {
            padding: 12px 20px;
            border-left: 3px solid;
            font-size: 14px;
            margin-bottom: 8px;
            font-family: 'Barlow Condensed', sans-serif;
            letter-spacing: 0.5px;
        }
        .flash-success { background: rgba(0,200,100,0.05); border-color: #00C864; color: #00C864; }
        .flash-error   { background: rgba(224,0,0,0.05);   border-color: var(--red); color: #FF4444; }
        .flash-info    { background: rgba(0,150,255,0.05); border-color: #0096FF; color: #0096FF; }
        .flash-list    { background: rgba(224,0,0,0.05);   border-color: var(--red); color: #FF6666; }
        .flash-list ul { padding-left: 16px; }

        main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 32px;
        }

        .page-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 48px;
            letter-spacing: 3px;
            line-height: 1;
            color: var(--text);
        }
        .page-title span { color: var(--red); }
        .section-label {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 8px;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 24px;
        }
        .card:hover { border-color: var(--border-red); }

        .btn {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 13px;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 12px 28px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-block;
            text-decoration: none;
            text-align: center;
        }
        .btn-primary { background: var(--red); color: white; }
        .btn-primary:hover { background: var(--red-dark); color: white; }
        .btn-outline { background: transparent; border: 1px solid var(--border-red); color: var(--red); }
        .btn-outline:hover { background: var(--red-glow); }
        .btn-ghost { background: transparent; border: 1px solid var(--border); color: var(--text-muted); }
        .btn-ghost:hover { border-color: var(--text-muted); color: var(--text); }
        .btn-sm { padding: 8px 16px; font-size: 11px; }
        .btn-block { display: block; width: 100%; }

        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 8px;
        }
        .form-control {
            width: 100%;
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 12px 16px;
            font-family: 'Barlow', sans-serif;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-control:focus { border-color: var(--red); }
        .form-control::placeholder { color: var(--text-dim); }
        select.form-control { cursor: pointer; }

        /* ── FOOTER ── */
        .footer {
            border-top: 1px solid var(--border);
            margin-top: 80px;
            padding: 32px;
            text-align: center;
        }
        .footer-logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 20px;
            letter-spacing: 4px;
            color: var(--red);
            margin-bottom: 8px;
        }
        .footer-text {
            font-size: 12px;
            color: var(--text-dim);
            letter-spacing: 1px;
        }

        .badge {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 3px 8px;
            border: 1px solid;
        }
        .badge-red    { color: var(--red);    border-color: var(--border-red);    background: rgba(224,0,0,0.07); }
        .badge-green  { color: #00C864;       border-color: rgba(0,200,100,0.3);  background: rgba(0,200,100,0.05); }
        .badge-yellow { color: var(--gold);   border-color: rgba(201,168,76,0.3); background: rgba(201,168,76,0.05); }
        .badge-gray   { color: var(--text-muted); border-color: var(--border);    background: transparent; }
        .badge-blue   { color: #4A9EFF;       border-color: rgba(74,158,255,0.3); background: rgba(74,158,255,0.05); }

        .table { width: 100%; border-collapse: collapse; }
        .table th {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-dim);
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            font-weight: 400;
        }
        .table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            color: var(--text-muted);
        }
        .table tr:hover td { background: var(--surface2); }
        .table tr:last-child td { border-bottom: none; }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--black); }
        ::-webkit-scrollbar-thumb { background: var(--surface3); }
        ::-webkit-scrollbar-thumb:hover { background: var(--red-dark); }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar">
    <div class="navbar-inner">
        <a href="/products" class="nav-logo">
            <span class="nav-logo-dot"></span>
            DUCATI
        </a>

        <ul class="nav-links">
            <li><a href="/products"><i class="fa-solid fa-motorcycle fa-sm" style="margin-right:6px"></i>Motor</a></li>
            @auth
                <li class="nav-divider"></li>
                <li>
                    <a href="/cart">
                        <i class="fa-solid fa-bag-shopping fa-sm" style="margin-right:6px"></i>Keranjang
                    </a>
                </li>
                <li><a href="/orders"><i class="fa-solid fa-receipt fa-sm" style="margin-right:6px"></i>Pesanan</a></li>
                <li><a href="/credits"><i class="fa-solid fa-landmark fa-sm" style="margin-right:6px"></i>Kredit</a></li>
                <li class="nav-divider"></li>
                <li>
                    <span class="nav-user">
                        <i class="fa-solid fa-circle-user"></i>
                        <a href="/profile" style="color: var(--text-muted); text-decoration:none; font-family:'Barlow Condensed'; font-size:13px; letter-spacing:1px;">
                            {{ Auth::user()->full_name }}
                        </a>
                    </span>
                </li>
                @if(Auth::user()->isAdmin())
                <li>
                    <a href="/admin" style="color: var(--gold) !important;">
                        <i class="fa-solid fa-shield-halved fa-sm" style="margin-right:4px"></i>Admin
                    </a>
                </li>
                @endif
                <li>
                    <form method="POST" action="/logout" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-sm">
                            <i class="fa-solid fa-arrow-right-from-bracket fa-sm" style="margin-right:4px"></i>Keluar
                        </button>
                    </form>
                </li>
            @else
                <li class="nav-divider"></li>
                <li><a href="/login" class="nav-btn nav-btn-ghost">Masuk</a></li>
                <li><a href="/register" class="nav-btn">Daftar</a></li>
            @endauth
        </ul>
    </div>
</nav>

<div class="flash-container">
    @if(session('success'))
        <div class="flash flash-success"><i class="fa-solid fa-circle-check fa-sm" style="margin-right:8px"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash flash-error"><i class="fa-solid fa-circle-xmark fa-sm" style="margin-right:8px"></i>{{ session('error') }}</div>
    @endif
    @if(session('info'))
        <div class="flash flash-info"><i class="fa-solid fa-circle-info fa-sm" style="margin-right:8px"></i>{{ session('info') }}</div>
    @endif
    @if($errors->any())
        <div class="flash flash-list">
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif
</div>

<main>
    @yield('content')
</main>

<footer class="footer">
    <div class="footer-logo">DUCATI</div>
    <div class="footer-text">© {{ date('Y') }} Ducati Motor Indonesia &nbsp;·&nbsp; The Art of Speed</div>
</footer>

@stack('scripts')
</body>
</html>
