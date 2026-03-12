@extends('layouts.app')
@section('title', 'Checkout')

@push('styles')
<style>
    .checkout-layout { display: grid; grid-template-columns: 1fr 380px; gap: 32px; align-items: start; }
    .checkout-section {
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 28px;
        margin-bottom: 2px;
    }
    .checkout-section-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 18px;
        letter-spacing: 2px;
        margin-bottom: 20px;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--text);
    }
    .checkout-section-title i { color: var(--red); font-size: 14px; }
    .address-option {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 14px 16px;
        border: 1px solid var(--border);
        margin-bottom: 2px;
        cursor: pointer;
        transition: border-color 0.2s;
    }
    .address-option:hover { border-color: var(--border-red); }
    .address-option input[type="radio"] { accent-color: var(--red); margin-top: 3px; flex-shrink: 0; }
    .address-option-label {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 13px;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--text);
        margin-bottom: 4px;
    }
    .address-option-detail { font-size: 13px; color: var(--text-muted); line-height: 1.5; }

    .purchase-option {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 16px 20px;
        border: 1px solid var(--border);
        margin-bottom: 2px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .purchase-option:hover { border-color: var(--border-red); background: rgba(224,0,0,0.03); }
    .purchase-option input[type="radio"] { accent-color: var(--red); margin-top: 2px; flex-shrink: 0; }
    .purchase-option-title {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 15px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--text);
        margin-bottom: 3px;
    }
    .purchase-option-desc { font-size: 12px; color: var(--text-muted); }

    .order-summary-card {
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 28px;
        position: sticky;
        top: 80px;
    }
    .summary-item { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
    .summary-item-name { font-size: 13px; color: var(--text-muted); }
    .summary-item-sub { font-family: 'Barlow Condensed', sans-serif; font-size: 11px; letter-spacing: 1px; color: var(--text-dim); margin-top: 2px; }
    .summary-item-price { font-family: 'Barlow Condensed', sans-serif; font-size: 14px; letter-spacing: 1px; color: var(--text); }
</style>
@endpush

@section('content')
<div style="margin-bottom:32px">
    <div class="section-label">Pembelian</div>
    <h1 class="page-title">CHECKOUT</h1>
</div>

<div class="checkout-layout">
    <form method="POST" action="/orders">
        @csrf

        <div class="checkout-section">
            <div class="checkout-section-title">
                <i class="fa-solid fa-location-dot"></i>
                ALAMAT PENGIRIMAN
            </div>
            @forelse($addresses as $addr)
                <label class="address-option">
                    <input type="radio" name="address_id" value="{{ $addr->id }}"
                           {{ $addr->is_default ? 'checked' : '' }}>
                    <div>
                        <div class="address-option-label">
                            {{ $addr->label }}
                            @if($addr->is_default)<span class="badge badge-green" style="margin-left:8px">Utama</span>@endif
                        </div>
                        <div class="address-option-detail">
                            <strong>{{ $addr->recipient_name }}</strong><br>
                            {{ $addr->street }}, {{ $addr->city }}, {{ $addr->province }} {{ $addr->postal_code }}
                        </div>
                    </div>
                </label>
            @empty
                <div style="text-align:center;padding:24px;color:var(--text-dim)">
                    <i class="fa-solid fa-location-dot" style="font-size:24px;display:block;margin-bottom:10px"></i>
                    Belum ada alamat.
                    <a href="/profile/addresses" style="color:var(--red);text-decoration:none"> Tambah alamat</a>
                </div>
            @endforelse
        </div>

        <div class="checkout-section">
            <div class="checkout-section-title">
                <i class="fa-solid fa-wallet"></i>
                METODE PEMBELIAN
            </div>
            <label class="purchase-option">
                <input type="radio" name="purchase_type" value="cash" checked>
                <div>
                    <div class="purchase-option-title">
                        <i class="fa-solid fa-money-bill-wave" style="margin-right:8px;color:var(--red)"></i>Bayar Lunas
                    </div>
                    <div class="purchase-option-desc">Bayar penuh melalui transfer bank, QRIS, atau e-wallet</div>
                </div>
            </label>
            <label class="purchase-option">
                <input type="radio" name="purchase_type" value="credit">
                <div>
                    <div class="purchase-option-title">
                        <i class="fa-solid fa-landmark" style="margin-right:8px;color:var(--red)"></i>Kredit / Cicilan
                    </div>
                    <div class="purchase-option-desc">Ajukan cicilan ke leasing pilihan — KYC wajib terverifikasi</div>
                </div>
            </label>
        </div>

        <button type="submit" class="btn btn-primary" style="font-size:15px;letter-spacing:3px;padding:15px 32px">
            <i class="fa-solid fa-bag-shopping" style="margin-right:10px"></i>BUAT PESANAN
        </button>
    </form>

    <div class="order-summary-card">
        <div style="font-family:'Bebas Neue';font-size:18px;letter-spacing:2px;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--border)">
            RINGKASAN PESANAN
        </div>
        @foreach($cartItems as $item)
        <div class="summary-item" style="padding-bottom:12px;border-bottom:1px solid var(--border);margin-bottom:12px">
            <div>
                <div class="summary-item-name" style="font-size:14px;color:var(--text)">{{ $item->product->name }}</div>
                <div class="summary-item-sub">{{ $item->quantity }} unit</div>
            </div>
            <div class="summary-item-price">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</div>
        </div>
        @endforeach
        <div style="display:flex;justify-content:space-between;align-items:center;padding-top:8px">
            <span style="font-family:'Bebas Neue';font-size:16px;letter-spacing:2px;color:var(--text-muted)">TOTAL</span>
            <span style="font-family:'Bebas Neue';font-size:28px;letter-spacing:1px;color:var(--red)">
                Rp {{ number_format($grandTotal, 0, ',', '.') }}
            </span>
        </div>
    </div>
</div>
@endsection
