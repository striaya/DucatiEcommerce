<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DUCATI — Masuk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@300;400;500&family=Barlow+Condensed:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --red: #E00000;
            --red-dark: #A50000;
            --black: #0A0A0A;
            --surface: #111111;
            --surface2: #181818;
            --border: rgba(255,255,255,0.07);
            --border-red: rgba(224,0,0,0.35);
            --text: #F0F0F0;
            --text-muted: #888;
            --text-dim: #444;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        html, body { height: 100%; }

        body {
            background: var(--black);
            color: var(--text);
            font-family: 'Barlow', sans-serif;
            font-weight: 300;
        }

        .auth-layout {
            display: grid;
            grid-template-columns: 1fr 520px;
            min-height: 100vh;
        }

        .auth-visual {
            position: relative;
            overflow: hidden;
            background: #050505;
        }
        .auth-visual-bg {
            position: absolute;
            inset: 0;
            background-image: url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&q=80');
            background-size: cover;
            background-position: center;
            filter: brightness(0.45) saturate(0.8);
            transition: transform 8s ease;
        }
        .auth-visual:hover .auth-visual-bg {
            transform: scale(1.04);
        }
        .auth-visual-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(224,0,0,0.12) 0%,
                transparent 50%,
                rgba(0,0,0,0.6) 100%
            );
        }
        .auth-visual-lines {
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 80px,
                rgba(255,255,255,0.015) 80px,
                rgba(255,255,255,0.015) 81px
            );
        }
        .auth-visual-content {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
        }
        .auth-logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 32px;
            letter-spacing: 6px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .auth-logo-line {
            width: 32px;
            height: 2px;
            background: var(--red);
        }
        .auth-tagline {
            margin-bottom: 0;
        }
        .auth-tagline-label {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 12px;
        }
        .auth-tagline-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 64px;
            line-height: 0.9;
            color: white;
            letter-spacing: 2px;
        }
        .auth-tagline-title span {
            color: var(--red);
            display: block;
        }
        .auth-tagline-sub {
            margin-top: 16px;
            font-size: 14px;
            color: rgba(255,255,255,0.45);
            letter-spacing: 0.5px;
            max-width: 320px;
            line-height: 1.6;
        }

        /* ── RIGHT PANEL — FORM ── */
        .auth-form-panel {
            background: var(--surface);
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 64px 56px;
            position: relative;
            overflow: hidden;
        }
        .auth-form-panel::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(224,0,0,0.06) 0%, transparent 70%);
            pointer-events: none;
        }
        .auth-form-header {
            margin-bottom: 40px;
        }
        .auth-form-eyebrow {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 10px;
        }
        .auth-form-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 42px;
            letter-spacing: 2px;
            color: var(--text);
            line-height: 1;
        }
        .auth-form-sub {
            margin-top: 8px;
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.5;
        }

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
        .form-input-wrap {
            position: relative;
        }
        .form-input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
            font-size: 13px;
            transition: color 0.2s;
        }
        .form-control {
            width: 100%;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-bottom: 1px solid rgba(255,255,255,0.12);
            color: var(--text);
            padding: 13px 16px 13px 44px;
            font-family: 'Barlow', sans-serif;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }
        .form-control:focus {
            border-color: var(--border-red);
            background: #141414;
        }
        .form-control:focus ~ .form-input-icon,
        .form-input-wrap:focus-within .form-input-icon {
            color: var(--red);
        }
        .form-control::placeholder { color: var(--text-dim); }

        .btn-submit {
            width: 100%;
            background: var(--red);
            color: white;
            border: none;
            padding: 15px;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 18px;
            letter-spacing: 4px;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
            margin-top: 8px;
        }
        .btn-submit::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.4s, height 0.4s;
        }
        .btn-submit:hover { background: var(--red-dark); }
        .btn-submit:active::after { width: 300px; height: 300px; }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 24px 0;
        }
        .auth-divider-line {
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        .auth-divider-text {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            letter-spacing: 2px;
            color: var(--text-dim);
            text-transform: uppercase;
        }

        .auth-footer-link {
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
        }
        .auth-footer-link a {
            color: var(--red);
            text-decoration: none;
            font-weight: 500;
            border-bottom: 1px solid var(--border-red);
            padding-bottom: 1px;
            transition: border-color 0.2s;
        }
        .auth-footer-link a:hover { border-color: var(--red); }

        .flash-error {
            background: rgba(224,0,0,0.07);
            border-left: 3px solid var(--red);
            padding: 12px 16px;
            font-size: 13px;
            color: #FF6666;
            margin-bottom: 24px;
            font-family: 'Barlow Condensed', sans-serif;
            letter-spacing: 0.5px;
        }
        .flash-error ul { padding-left: 16px; margin: 0; }

        @media (max-width: 900px) {
            .auth-layout { grid-template-columns: 1fr; }
            .auth-visual { display: none; }
            .auth-form-panel { padding: 48px 32px; }
        }
    </style>
</head>
<body>
<div class="auth-layout">

    <div class="auth-visual">
        <div class="auth-visual-bg"></div>
        <div class="auth-visual-overlay"></div>
        <div class="auth-visual-lines"></div>
        <div class="auth-visual-content">
            <a href="/products" class="auth-logo">
                <span class="auth-logo-line"></span>
                DUCATI
            </a>
            <div class="auth-tagline">
                <div class="auth-tagline-label">The Art of Speed</div>
                <div class="auth-tagline-title">
                    PURE
                    <span>POWER</span>
                </div>
                <div class="auth-tagline-sub">
                    Temukan motor impianmu. Performa tanpa kompromi, desain yang tak terlupakan.
                </div>
            </div>
        </div>
    </div>

    <div class="auth-form-panel">
        <div class="auth-form-header">
            <div class="auth-form-eyebrow">Selamat Datang</div>
            <div class="auth-form-title">MASUK</div>
            <div class="auth-form-sub">Akses koleksi Ducati eksklusif untukmu</div>
        </div>

        @if($errors->any())
            <div class="flash-error">
                <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <div class="form-group">
                <label class="form-label">Alamat Email</label>
                <div class="form-input-wrap">
                    <i class="fa-regular fa-envelope form-input-icon"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="nama@email.com" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="form-input-wrap">
                    <i class="fa-solid fa-lock form-input-icon"></i>
                    <input type="password" name="password" required
                           placeholder="Masukkan password" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-arrow-right-to-bracket" style="margin-right:8px"></i>
                MASUK SEKARANG
            </button>
        </form>

        <div class="auth-divider">
            <div class="auth-divider-line"></div>
            <div class="auth-divider-text">atau</div>
            <div class="auth-divider-line"></div>
        </div>

        <div class="auth-footer-link">
            Belum memiliki akun? <a href="/register">Daftar di sini</a>
        </div>
    </div>
</div>
</body>
</html>
