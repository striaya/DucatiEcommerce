@extends('layouts.app')
@section('title', 'Detail Pesanan')

@push('styles')
<style>
    .order-detail-layout { display: grid; grid-template-columns: 1fr 340px; gap: 32px; align-items: start; }
    .detail-section {
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 24px 28px;
        margin-bottom: 2px;
    }
    .detail-section-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 16px;
        letter-spacing: 2px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .detail-section-title i { color: var(--red); font-size: 13px; }

    .order-item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid var(--border);
    }
    .order-item-row:last-child { border-bottom: none; }
    .order-item-name {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 18px;
        letter-spacing: 1px;
        margin-bottom: 2px;
    }
    .order-item-qty {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        letter-spacing: 1px;
        color: var(--text-dim);
        text-transform: uppercase;
    }
    .order-item-total {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 18px;
        letter-spacing: 1px;
        color: var(--red);
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid var(--border);
        font-size: 13px;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row-label {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--text-dim);
    }
    .info-row-val { color: var(--text); text-align: right; }

    .review-form-section {
        background: var(--surface);
        border: 1px solid var(--border-red);
        padding: 24px 28px;
        margin-top: 2px;
    }
    .star-rating { display: flex; gap: 4px; margin-bottom: 12px; }
    .star-rating input { display: none; }
    .star-rating label {
        font-size: 24px;
        color: var(--text-dim);
        cursor: pointer;
        transition: color 0.15s;
    }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label { color: var(--gold) !important; }
    .star-rating { flex-direction: row-reverse; }
    .star-rating label:hover,
    .star-rating label:hover ~ label { color: var(--gold); }
    .star-rating input:checked ~ label { color: var(--gold); }
</style>
@endpush

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
    <div>
        <div class="section-label">Pesanan Saya</div>
        <h1 class="page-title" style="font-size:36px">DETAIL <span>PESANAN</span></h1>
    </div>
    <a href="/orders" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left" style="margin-right:6px"></i>Kembali
    </a>
</div>

<div class="order-detail-layout">
    <div>
        <div class="detail-section">
            <div style="display:flex;justify-content:space-between;align-items:flex-start">
                <div>
                    <div style="font-family:'Barlow Condensed';font-size:11px;letter-spacing:3px;text-transform:uppercase;color:var(--text-dim);margin-bottom:6px">
                        Nomor Pesanan
                    </div>
                    <div style="font-family:'Bebas Neue';font-size:28px;letter-spacing:2px">{{ $order->order_number }}</div>
                    <div style="font-family:'Barlow Condensed';font-size:12px;letter-spacing:1px;color:var(--text-dim);margin-top:4px">
                        <i class="fa-regular fa-clock" style="margin-right:4px"></i>
                        {{ $order->ordered_at->format('d M Y, H:i') }}
                    </div>
                </div>
                <div style="text-align:right">
                    @php
                        $sMap = ['pending'=>'badge-yellow','confirmed'=>'badge-blue','shipped'=>'badge-blue','delivered'=>'badge-green','cancelled'=>'badge-red'];
                        $sLabel = ['pending'=>'Menunggu','confirmed'=>'Dikonfirmasi','shipped'=>'Dikirim','delivered'=>'Diterima','cancelled'=>'Dibatalkan'];
                    @endphp
                    <span class="badge {{ $sMap[$order->status] ?? 'badge-gray' }}" style="font-size:12px;padding:5px 12px">
                        {{ $sLabel[$order->status] ?? $order->status }}
                    </span>
                    <br>
                    @if($order->purchase_type === 'credit')
                        <span class="badge badge-yellow" style="margin-top:6px;display:inline-block">
                            <i class="fa-solid fa-landmark" style="margin-right:4px"></i>Kredit
                        </span>
                    @else
                        <span class="badge badge-gray" style="margin-top:6px;display:inline-block">Cash</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-motorcycle"></i>ITEM PESANAN
            </div>
            @foreach($order->items as $item)
            <div class="order-item-row">
                <div>
                    <div class="order-item-name">{{ $item->product_name }}</div>
                    <div class="order-item-qty">{{ $item->quantity }} unit &times; Rp {{ number_format($item->unit_price, 0, ',', '.') }}</div>
                </div>
                <div class="order-item-total">Rp {{ number_format($item->total_price, 0, ',', '.') }}</div>
            </div>
            @endforeach
            <div style="display:flex;justify-content:space-between;align-items:center;padding-top:16px;margin-top:4px">
                <span style="font-family:'Bebas Neue';font-size:16px;letter-spacing:2px;color:var(--text-muted)">GRAND TOTAL</span>
                <span style="font-family:'Bebas Neue';font-size:28px;letter-spacing:1px;color:var(--red)">
                    Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                </span>
            </div>
        </div>

        @if($order->status === 'delivered')
        <div class="review-form-section">
            <div class="detail-section-title" style="border-bottom-color:var(--border-red)">
                <i class="fa-solid fa-star"></i>TULIS ULASAN
            </div>
            @foreach($order->items as $item)
            <form method="POST" action="/reviews" style="margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid var(--border)">
                @csrf
                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <div style="font-family:'Bebas Neue';font-size:18px;letter-spacing:1px;margin-bottom:10px">{{ $item->product_name }}</div>
                <div class="star-rating">
                    @for($i = 5; $i >= 1; $i--)
                        <input type="radio" name="rating" id="star{{ $item->id }}_{{ $i }}" value="{{ $i }}">
                        <label for="star{{ $item->id }}_{{ $i }}"><i class="fa-solid fa-star"></i></label>
                    @endfor
                </div>
                <div class="form-group">
                    <input type="text" name="title" placeholder="Judul ulasan..." class="form-control" style="margin-bottom:8px">
                </div>
                <div class="form-group">
                    <textarea name="body" placeholder="Ceritakan pengalamanmu dengan motor ini..."
                              class="form-control" rows="2" style="resize:vertical"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-paper-plane" style="margin-right:6px"></i>Kirim Ulasan
                </button>
            </form>
            @endforeach
        </div>
        @endif
    </div>

    <div>
        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-location-dot"></i>ALAMAT KIRIM
            </div>
            <div style="font-weight:500;margin-bottom:6px">{{ $order->address->recipient_name }}</div>
            <div style="font-size:13px;color:var(--text-muted);line-height:1.7">
                {{ $order->address->street }},<br>
                {{ $order->address->city }}, {{ $order->address->province }}<br>
                {{ $order->address->postal_code }}
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-credit-card"></i>PEMBAYARAN
            </div>
            @if($order->payments->isEmpty())
                @if($order->purchase_type === 'cash')
                    <a href="/orders/{{ $order->id }}/payment" class="btn btn-primary btn-block btn-sm">
                        <i class="fa-solid fa-wallet" style="margin-right:6px"></i>Bayar Sekarang
                    </a>
                @elseif(!$order->creditApplication)
                    <a href="/orders/{{ $order->id }}/credit" class="btn btn-outline btn-block btn-sm">
                        <i class="fa-solid fa-landmark" style="margin-right:6px"></i>Ajukan Kredit
                    </a>
                @endif
            @else
                @foreach($order->payments as $pay)
                <div class="info-row">
                    <span class="info-row-label">{{ strtoupper(str_replace('_', ' ', $pay->method)) }}</span>
                    <span class="badge {{ $pay->status === 'success' ? 'badge-green' : 'badge-yellow' }}">
                        {{ ucfirst($pay->status) }}
                    </span>
                </div>
                @endforeach
            @endif
        </div>

        @if($order->creditApplication)
        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-landmark"></i>INFO KREDIT
            </div>
            <div class="info-row">
                <span class="info-row-label">Provider</span>
                <span class="info-row-val">{{ $order->creditApplication->provider }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Tenor</span>
                <span class="info-row-val">{{ $order->creditApplication->tenure_months }} bulan</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Cicilan/Bulan</span>
                <span class="info-row-val" style="color:var(--red);font-family:'Bebas Neue';font-size:18px;letter-spacing:1px">
                    Rp {{ number_format($order->creditApplication->monthly_installment, 0, ',', '.') }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Status</span>
                <span class="badge badge-yellow">{{ ucfirst($order->creditApplication->status) }}</span>
            </div>
            <a href="/credits/{{ $order->creditApplication->id }}" class="btn btn-ghost btn-block btn-sm" style="margin-top:16px">
                Lihat Jadwal Cicilan
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
