@extends('layouts.app')
@section('title', 'Masuk')

@section('content')
<div class="max-w-md mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6 text-center">Masuk ke Akun</h1>
    <form method="POST" action="/login" class="bg-gray-900 rounded-lg p-6 space-y-4 border border-gray-800">
        @csrf
        <div>
            <label class="block text-sm text-gray-400 mb-1">Email</label>
            <input type="email"<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DUCATI — Daftar</title>
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
        body { background: var(--black); color: var(--text); font-family: 'Barlow', sans-serif; font-weight: 300; }

        .auth-layout { display: grid; grid-template-columns: 1fr 560px; min-height: 100vh; }

        .auth-visual {
            position: relative;
            overflow: hidden;
            background: #050505;
        }
        .auth-visual-bg {
            position: absolute;
            inset: 0;
            background-image: url('https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?w=1200&q=80');
            background-size: cover;
            background-position: center 30%;
            filter: brightness(0.4) saturate(0.7);
            transition: transform 8s ease;
        }
        .auth-visual:hover .auth-visual-bg { transform: scale(1.04); }
        .auth-visual-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg, rgba(224,0,0,0.1) 0%, transparent 40%, rgba(0,0,0,0.7) 100%);
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
        .auth-logo-line { width: 32px; height: 2px; background: var(--red); }

        .auth-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 0;
        }
        .auth-stat {
            border-left: 2px solid var(--red);
            padding-left: 16px;
        }
        .auth-stat-num {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 36px;
            letter-spacing: 2px;
            color: white;
            line-height: 1;
        }
        .auth-stat-label {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
            margin-top: 4px;
        }

        .auth-form-panel {
            background: var(--surface);
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 52px;
            overflow-y: auto;
        }
        .auth-form-header { margin-bottom: 32px; }
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
        .auth-form-sub { margin-top: 8px; font-size: 13px; color: var(--text-muted); }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group { margin-bottom: 16px; }
        .form-label {
            display: block;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 7px;
        }
        .form-hint {
            font-size: 11px;
            color: var(--text-dim);
            margin-top: 5px;
        }
        .form-input-wrap { position: relative; }
        .form-input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
            font-size: 12px;
            transition: color 0.2s;
        }
        .form-control {
            width: 100%;
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 12px 14px 12px 40px;
            font-family: 'Barlow', sans-serif;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }
        .form-control:focus { border-color: var(--border-red); background: #141414; }
        .form-control:focus + .form-input-icon,
        .form-input-wrap:focus-within .form-input-icon { color: var(--red); }
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
            transition: background 0.2s;
            margin-top: 8px;
        }
        .btn-submit:hover { background: var(--red-dark); }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 20px 0;
        }
        .auth-divider-line { flex: 1; height: 1px; background: var(--border); }
        .auth-divider-text {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 11px;
            letter-spacing: 2px;
            color: var(--text-dim);
            text-transform: uppercase;
        }

        .auth-footer-link { text-align: center; font-size: 13px; color: var(--text-muted); }
        .auth-footer-link a {
            color: var(--red);
            text-decoration: none;
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
            margin-bottom: 20px;
            font-family: 'Barlow Condensed', sans-serif;
        }
        .flash-error ul { padding-left: 16px; margin: 0; }

        @media (max-width: 900px) {
            .auth-layout { grid-template-columns: 1fr; }
            .auth-visual { display: none; }
            .auth-form-panel { padding: 48px 32px; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="auth-layout">

    {{-- KIRI: FOTO --}}
    <div class="auth-visual">
        <div class="auth-visual-bg"></div>
        <div class="auth-visual-overlay"></div>
        <div class="auth-visual-content">
            <a href="/products" class="auth-logo">
                <span class="auth-logo-line"></span>
                DUCATI
            </a>
            <div class="auth-stats">
                <div class="auth-stat">
                    <div class="auth-stat-num">100+</div>
                    <div class="auth-stat-label">Model Tersedia</div>
                </div>
                <div class="auth-stat">
                    <div class="auth-stat-num">1946</div>
                    <div class="auth-stat-label">Tahun Berdiri</div>
                </div>
                <div class="auth-stat">
                    <div class="auth-stat-num">30+</div>
                    <div class="auth-stat-label">Negara Distribusi</div>
                </div>
                <div class="auth-stat">
                    <div class="auth-stat-num">16x</div>
                    <div class="auth-stat-label">Juara MotoGP</div>
                </div>
            </div>
        </div>
    </div>

    {{-- KANAN: FORM --}}
    <div class="auth-form-panel">
        <div class="auth-form-header">
            <div class="auth-form-eyebrow">Bergabung Sekarang</div>
            <div class="auth-form-title">BUAT AKUN</div>
            <div class="auth-form-sub">Daftar untuk akses pembelian & kredit Ducati</div>
        </div>

        @if($errors->any())
            <div class="flash-error">
                <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <div class="form-input-wrap">
                    <i class="fa-regular fa-user form-input-icon"></i>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" required
                           placeholder="Nama sesuai KTP" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Alamat Email</label>
                <div class="form-input-wrap">
                    <i class="fa-regular fa-envelope form-input-icon"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="nama@email.com" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">No. Handphone</label>
                    <div class="form-input-wrap">
                        <i class="fa-solid fa-phone form-input-icon"></i>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               placeholder="08xxxxxxxxxx" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">NIK <span style="color:#444;font-size:10px">(opsional)</span></label>
                    <div class="form-input-wrap">
                        <i class="fa-solid fa-id-card form-input-icon"></i>
                        <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16"
                               placeholder="16 digit NIK" class="form-control">
                    </div>
                    <div class="form-hint">Wajib diisi untuk kredit</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="form-input-wrap">
                        <i class="fa-solid fa-lock form-input-icon"></i>
                        <input type="password" name="password" required minlength="8"
                               placeholder="Min. 8 karakter" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="form-input-wrap">
                        <i class="fa-solid fa-lock form-input-icon"></i>
                        <input type="password" name="password_confirmation" required
                               placeholder="Ulangi password" class="form-control">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-user-plus" style="margin-right:8px"></i>
                DAFTAR SEKARANG
            </button>
        </form>

        <div class="auth-divider">
            <div class="auth-divider-line"></div>
            <div class="auth-divider-text">sudah punya akun</div>
            <div class="auth-divider-line"></div>
        </div>

        <div class="auth-footer-link">
            Sudah terdaftar? <a href="/login">Masuk di sini</a>
        </div>
    </div>
</div>
</body>
</html>
 name="email" value="{{ old('email') }}" required
                   class="w-full bg-gray-800 border border-gray-700 rounded px-3 py-2 focus:outline-none focus:border-red-500">
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full bg-gray-800 border border-gray-700 rounded px-3 py-2 focus:outline-none focus:border-red-500">
        </div>
        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 rounded transition">
            Masuk
        </button>
        <p class="text-center text-sm text-gray-400">
            Belum punya akun? <a href="/register" class="text-red-500 hover:underline">Daftar</a>
        </p>
    </form>
</div>
@endsection
