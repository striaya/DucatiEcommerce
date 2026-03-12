@extends('layouts.app')
@section('title', 'Alamat Saya')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
    <div>
        <div class="section-label">Akun Saya</div>
        <h1 class="page-title" style="font-size:36px">ALAMAT <span>SAYA</span></h1>
    </div>
    <a href="/profile" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left" style="margin-right:6px"></i>Kembali
    </a>
</div>

<div style="display:grid;grid-template-columns:1fr 400px;gap:32px;align-items:start">
    <div>
        @forelse($addresses as $addr)
        <div style="background:var(--surface);border:1px solid var(--border);padding:20px 24px;margin-bottom:2px;display:flex;justify-content:space-between;align-items:flex-start">
            <div>
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
                    <span style="font-family:'Bebas Neue';font-size:18px;letter-spacing:1.5px">{{ $addr->label }}</span>
                    @if($addr->is_default)
                        <span class="badge badge-green">Utama</span>
                    @endif
                </div>
                <div style="font-weight:500;margin-bottom:4px;font-size:14px">{{ $addr->recipient_name }}</div>
                <div style="font-size:13px;color:var(--text-muted);line-height:1.6">
                    {{ $addr->street }}<br>
                    {{ $addr->city }}, {{ $addr->province }} {{ $addr->postal_code }}
                </div>
            </div>
            <form method="POST" action="/profile/addresses/{{ $addr->id }}">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-ghost btn-sm"
                        onclick="return confirm('Hapus alamat ini?')"
                        style="color:var(--red);border-color:rgba(224,0,0,0.2)">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </div>
        @empty
            <div style="text-align:center;padding:60px;color:var(--text-dim)">
                <i class="fa-solid fa-location-dot" style="font-size:40px;display:block;margin-bottom:12px"></i>
                <div style="font-family:'Bebas Neue';font-size:22px;letter-spacing:2px;color:var(--text-muted)">BELUM ADA ALAMAT</div>
            </div>
        @endforelse
    </div>

    <div style="background:var(--surface);border:1px solid var(--border);padding:28px;position:sticky;top:80px">
        <div style="font-family:'Bebas Neue';font-size:16px;letter-spacing:2px;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px">
            <i class="fa-solid fa-plus" style="color:var(--red);font-size:12px"></i>TAMBAH ALAMAT
        </div>
        <form method="POST" action="/profile/addresses">
            @csrf
            <div class="form-group">
                <label class="form-label">Label</label>
                <input type="text" name="label" placeholder="Rumah / Kantor / Lainnya" required class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Nama Penerima</label>
                <input type="text" name="recipient_name" placeholder="Nama lengkap" required class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Alamat Lengkap</label>
                <textarea name="street" placeholder="Jalan, nomor, RT/RW, kelurahan" required
                          class="form-control" rows="2" style="resize:vertical"></textarea>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                <div class="form-group">
                    <label class="form-label">Kota</label>
                    <input type="text" name="city" required class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Provinsi</label>
                    <input type="text" name="province" required class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Kode Pos</label>
                <input type="text" name="postal_code" required class="form-control">
            </div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px">
                <input type="checkbox" name="is_default" id="is_default" value="1" style="accent-color:var(--red);width:14px;height:14px">
                <label for="is_default" style="font-family:'Barlow Condensed';font-size:12px;letter-spacing:1.5px;text-transform:uppercase;color:var(--text-muted);cursor:pointer">
                    Jadikan alamat utama
                </label>
            </div>
            <button type="submit" class="btn btn-primary btn-block">
                <i class="fa-solid fa-plus" style="margin-right:8px"></i>Simpan Alamat
            </button>
        </form>
    </div>
</div>
@endsection
