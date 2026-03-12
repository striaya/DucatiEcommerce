@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
<div style="margin-bottom:32px">
    <div class="section-label">Akun Saya</div>
    <h1 class="page-title">PROFIL</h1>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:32px;align-items:start">

    <div>
        <div style="background:var(--surface);border:1px solid var(--border);padding:28px;margin-bottom:2px">
            <div style="font-family:'Bebas Neue';font-size:16px;letter-spacing:2px;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px">
                <i class="fa-regular fa-user" style="color:var(--red);font-size:13px"></i>DATA DIRI
            </div>
            <form method="POST" action="/profile">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="full_name" value="{{ $user->full_name }}" required class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="text" value="{{ $user->email }}" disabled
                           class="form-control" style="opacity:0.5;cursor:not-allowed">
                </div>
                <div class="form-group">
                    <label class="form-label">No. Handphone</label>
                    <input type="text" name="phone" value="{{ $user->phone }}" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">NIK</label>
                    <input type="text" name="nik" value="{{ $user->nik }}" maxlength="16" class="form-control">
                    <div style="font-size:11px;color:var(--text-dim);margin-top:6px;font-family:'Barlow Condensed';letter-spacing:1px">
                        Wajib diisi untuk pengajuan kredit
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-floppy-disk" style="margin-right:6px"></i>Simpan Perubahan
                </button>
            </form>
        </div>

        <div style="background:var(--surface);border:1px solid var(--border);padding:24px 28px">
            <div style="font-family:'Bebas Neue';font-size:16px;letter-spacing:2px;margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px">
                <i class="fa-solid fa-shield-halved" style="color:var(--red);font-size:13px"></i>STATUS KYC
            </div>
            @php $kycMap = ['verified'=>'badge-green','rejected'=>'badge-red','unverified'=>'badge-yellow']; @endphp
            <div style="display:flex;align-items:center;gap:12px">
                <span class="badge {{ $kycMap[$user->kyc_status] ?? 'badge-gray' }}" style="font-size:12px;padding:6px 14px">
                    @if($user->kyc_status === 'verified')
                        <i class="fa-solid fa-circle-check" style="margin-right:4px"></i>Terverifikasi
                    @elseif($user->kyc_status === 'rejected')
                        <i class="fa-solid fa-circle-xmark" style="margin-right:4px"></i>Ditolak
                    @else
                        <i class="fa-solid fa-clock" style="margin-right:4px"></i>Belum Diverifikasi
                    @endif
                </span>
                @if($user->kyc_status !== 'verified')
                <span style="font-family:'Barlow Condensed';font-size:12px;letter-spacing:1px;color:var(--text-dim)">
                    Hubungi admin untuk verifikasi
                </span>
                @endif
            </div>
        </div>
    </div>

    <div>

        <div style="background:var(--surface);border:1px solid var(--border);padding:28px;margin-bottom:2px">
            <div style="font-family:'Bebas Neue';font-size:16px;letter-spacing:2px;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center">
                <span style="display:flex;align-items:center;gap:8px">
                    <i class="fa-solid fa-location-dot" style="color:var(--red);font-size:13px"></i>ALAMAT SAYA
                </span>
                <a href="/profile/addresses" class="btn btn-ghost btn-sm">Kelola</a>
            </div>
            @forelse($user->addresses as $addr)
            <div style="padding:12px 16px;border:1px solid var(--border);margin-bottom:2px">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
                    <span style="font-family:'Barlow Condensed';font-size:13px;letter-spacing:1.5px;text-transform:uppercase;color:var(--text)">
                        {{ $addr->label }}
                    </span>
                    @if($addr->is_default)
                        <span class="badge badge-green" style="font-size:10px">Utama</span>
                    @endif
                </div>
                <div style="font-size:12px;color:var(--text-muted);line-height:1.5">
                    {{ $addr->recipient_name }} · {{ $addr->city }}, {{ $addr->province }}
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:20px;color:var(--text-dim)">
                <a href="/profile/addresses" style="color:var(--red);text-decoration:none;font-family:'Barlow Condensed';letter-spacing:1px;font-size:13px">
                    <i class="fa-solid fa-plus" style="margin-right:4px"></i>Tambah Alamat
                </a>
            </div>
            @endforelse
        </div>

        <div style="background:var(--surface);border:1px solid var(--border);padding:28px">
            <div style="font-family:'Bebas Neue';font-size:16px;letter-spacing:2px;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center">
                <span style="display:flex;align-items:center;gap:8px">
                    <i class="fa-solid fa-receipt" style="color:var(--red);font-size:13px"></i>PESANAN TERBARU
                </span>
                <a href="/orders" class="btn btn-ghost btn-sm">Semua</a>
            </div>
            @forelse($orders as $order)
            <a href="/orders/{{ $order->id }}" style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border);text-decoration:none;color:inherit;transition:color 0.2s"
               onmouseenter="this.style.color='var(--red)'"
               onmouseleave="this.style.color='inherit'">
                <div>
                    <div style="font-family:'Barlow Condensed';font-size:12px;letter-spacing:1px;text-transform:uppercase">{{ $order->order_number }}</div>
                    <div style="font-size:11px;color:var(--text-dim);margin-top:2px">{{ $order->ordered_at->format('d M Y') }}</div>
                </div>
                <div style="text-align:right">
                    <div style="font-family:'Bebas Neue';font-size:16px;letter-spacing:1px;color:var(--red)">
                        Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                    </div>
                </div>
            </a>
            @empty
                <div style="text-align:center;padding:20px;color:var(--text-dim);font-size:13px">Belum ada pesanan</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
