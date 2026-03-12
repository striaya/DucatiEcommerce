@extends('layouts.app')
@section('title', 'Pembayaran')

@push('styles')
<style>
    .payment-method-grid { display: grid; gap: 2px; }
    .payment-method-option {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 18px 22px;
        border: 1px solid var(--border);
        cursor: pointer;
        transition: all 0.2s;
    }
    .payment-method-option:hover { border-color: var(--border-red); background: rgba(224,0,0,0.03); }
    .payment-method-option input[type="radio"] { accent-color: var(--red); width: 16px; height: 16px; flex-shrink: 0; }
    .payment-method-icon {
        width: 40px;
        height: 40px;
        background: var(--surface2);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--red);
        font-size: 16px;
        flex-shrink: 0;
    }
    .payment-method-title {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 15px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--text);
        margin-bottom: 2px;
    }
    .payment-method-desc { font-size: 12px; color: var(--text-dim); }
</style>
@endpush

@section('content')
<div style="margin-bottom:32px">
    <div class="section-label">Selesaikan Pesanan</div>
    <h1 class="page-title">PILIH <span>PEMBAYARAN</span></h1>
</div>

<div style="display:grid;grid-template-columns:1fr 360px;gap:32px;align-items:start">
    <div>
        <div style="background:var(--surface);border:1px solid var(--border);padding:24px 28px;margin-bottom:2px">
            <div style="font-family:'Barlow Condensed';font-size:11px;letter-spacing:2px;color:var(--text-dim);text-transform:uppercase;margin-bottom:4px">Total yang harus dibayar</div>
            <div style="font-family:'Bebas Neue';font-size:48px;letter-spacing:2px;color:var(--red)">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</div>
            <div style="font-family:'Barlow Condensed';font-size:12px;letter-spacing:1px;color:var(--text-dim)">Order #{{ $order->order_number }}</div>
        </div>

        <form method="POST" action="/orders/{{ $order->id }}/payment">
            @csrf
            <input type="hidden" name="gateway" value="Midtrans">
            <div class="payment-method-grid" style="margin-bottom:24px">
                @foreach([
                    ['value'=>'va_bank',     'icon'=>'fa-building-columns', 'title'=>'Virtual Account Bank',  'desc'=>'BCA, Mandiri, BNI, BRI — Transfer ke nomor VA'],
                    ['value'=>'qris',        'icon'=>'fa-qrcode',           'title'=>'QRIS',                  'desc'=>'Scan QR dari semua aplikasi e-wallet'],
                    ['value'=>'e_wallet',    'icon'=>'fa-mobile-screen',    'title'=>'E-Wallet',              'desc'=>'GoPay, OVO, Dana, ShopeePay'],
                    ['value'=>'credit_card', 'icon'=>'fa-credit-card',      'title'=>'Kartu Kredit / Debit',  'desc'=>'Visa, Mastercard, JCB'],
                ] as $m)
                <label class="payment-method-option">
                    <input type="radio" name="method" value="{{ $m['value'] }}">
                    <div class="payment-method-icon"><i class="fa-solid {{ $m['icon'] }}"></i></div>
                    <div>
                        <div class="payment-method-title">{{ $m['title'] }}</div>
                        <div class="payment-method-desc">{{ $m['desc'] }}</div>
                    </div>
                </label>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary" style="font-size:15px;letter-spacing:3px;padding:15px 40px">
                <i class="fa-solid fa-lock" style="margin-right:10px"></i>LANJUTKAN PEMBAYARAN
            </button>
        </form>
    </div>

    <div style="background:var(--surface);border:1px solid var(--border);padding:24px 28px;position:sticky;top:80px">
        <div style="font-family:'Bebas Neue';font-size:16px;letter-spacing:2px;margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid var(--border)">
            ITEM PESANAN
        </div>
        @foreach($order->items as $item)
        <div style="display:flex;justify-content:space-between;margin-bottom:10px;font-size:13px">
            <div>
                <div style="color:var(--text)">{{ $item->product_name }}</div>
                <div style="font-family:'Barlow Condensed';font-size:11px;letter-spacing:1px;color:var(--text-dim)">{{ $item->quantity }} unit</div>
            </div>
            <div style="font-family:'Barlow Condensed';letter-spacing:1px;color:var(--text)">Rp {{ number_format($item->total_price, 0, ',', '.') }}</div>
        </div>
        @endforeach
    </div>
</div>
@endsection
