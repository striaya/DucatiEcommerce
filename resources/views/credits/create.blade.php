@extends('layouts.app')
@section('title', 'Ajukan Kredit')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
    <div>
        <div class="section-label">Pembiayaan</div>
        <h1 class="page-title" style="font-size:36px">AJUKAN <span>KREDIT</span></h1>
    </div>
    <a href="/orders/{{ $order->id }}" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left" style="margin-right:6px"></i>Kembali
    </a>
</div>

<div style="display:grid;grid-template-columns:1fr 360px;gap:32px;align-items:start">
    <form method="POST" action="/orders/{{ $order->id }}/credit">
        @csrf
        <div style="background:var(--surface);border:1px solid var(--border);padding:28px;margin-bottom:2px">
            <div style="font-family:'Bebas Neue';font-size:16px;letter-spacing:2px;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px">
                <i class="fa-solid fa-landmark" style="color:var(--red);font-size:13px"></i>DATA PEMBIAYAAN
            </div>

            <div class="form-group">
                <label class="form-label">Perusahaan Leasing</label>
                <select name="provider" class="form-control">
                    @foreach($providers as $p)
                        <option value="{{ $p }}">{{ $p }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div class="form-group">
                    <label class="form-label">Tenor (Bulan)</label>
                    <select name="tenure_months" class="form-control">
                        @foreach($tenors as $t)
                            <option value="{{ $t }}">{{ $t }} Bulan</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Bunga / Tahun (%)</label>
                    <div style="position:relative">
                        <input type="number" name="interest_rate_pct" value="9" step="0.1" min="0" max="100"
                               class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Uang Muka (DP)</label>
                <input type="number" name="dp_amount" step="100000" min="0"
                       placeholder="Contoh: 50000000" class="form-control">
            </div>
        </div>

        <div style="background:var(--surface);border:1px solid var(--border);padding:28px;margin-bottom:24px">
            <div style="font-family:'Bebas Neue';font-size:16px;letter-spacing:2px;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px">
                <i class="fa-solid fa-file-lines" style="color:var(--red);font-size:13px"></i>DOKUMEN PENDUKUNG
            </div>

            <div class="form-group">
                <label class="form-label">URL Foto KTP <span style="color:var(--red)">*</span></label>
                <input type="url" name="doc_ktp_url" placeholder="https://drive.google.com/..." required class="form-control">
                <div style="font-size:11px;color:var(--text-dim);margin-top:6px;font-family:'Barlow Condensed';letter-spacing:1px">
                    Upload ke Google Drive / Cloudinary lalu tempel link-nya
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">URL Slip Gaji <span style="color:var(--text-dim);font-size:10px">(opsional)</span></label>
                <input type="url" name="doc_slip_gaji_url" placeholder="https://..." class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="font-size:15px;letter-spacing:3px;padding:15px 40px">
            <i class="fa-solid fa-paper-plane" style="margin-right:10px"></i>KIRIM PENGAJUAN
        </button>
    </form>

    <div style="background:var(--surface);border:1px solid var(--border);padding:24px 28px;position:sticky;top:80px">
        <div style="font-family:'Bebas Neue';font-size:16px;letter-spacing:2px;margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid var(--border)">
            DETAIL ORDER
        </div>
        <div style="font-family:'Barlow Condensed';font-size:11px;letter-spacing:2px;text-transform:uppercase;color:var(--text-dim);margin-bottom:4px">Nomor Pesanan</div>
        <div style="font-family:'Bebas Neue';font-size:20px;letter-spacing:1px;margin-bottom:16px">{{ $order->order_number }}</div>
        @foreach($order->items as $item)
        <div style="margin-bottom:10px;padding-bottom:10px;border-bottom:1px solid var(--border);font-size:13px">
            <div style="font-family:'Bebas Neue';font-size:16px;letter-spacing:1px">{{ $item->product_name }}</div>
            <div style="color:var(--text-dim);font-family:'Barlow Condensed';letter-spacing:1px">{{ $item->quantity }} unit</div>
        </div>
        @endforeach
        <div style="display:flex;justify-content:space-between;align-items:center;padding-top:8px">
            <span style="font-family:'Barlow Condensed';font-size:11px;letter-spacing:2px;text-transform:uppercase;color:var(--text-dim)">Harga Motor</span>
            <span style="font-family:'Bebas Neue';font-size:22px;letter-spacing:1px;color:var(--red)">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
        </div>
    </div>
</div>
@endsection
