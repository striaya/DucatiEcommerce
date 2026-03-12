@extends('layouts.app')
@section('title', 'Pesanan Saya')

@push('styles')
<style>
    .order-row {
        background: var(--surface);
        border: 1px solid var(--border);
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 24px;
        padding: 20px 24px;
        margin-bottom: 2px;
        text-decoration: none;
        color: inherit;
        transition: border-color 0.2s;
    }
    .order-row:hover { border-color: var(--border-red); }
    .order-number {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--text-dim);
        margin-bottom: 6px;
    }
    .order-items-preview {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 20px;
        letter-spacing: 1.5px;
        color: var(--text);
        margin-bottom: 8px;
    }
    .order-meta { display: flex; gap: 16px; align-items: center; }
    .order-date {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 12px;
        letter-spacing: 1px;
        color: var(--text-dim);
    }
    .order-right { text-align: right; display: flex; flex-direction: column; justify-content: space-between; }
    .order-total {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 24px;
        letter-spacing: 1px;
        color: var(--red);
    }
    .order-badges { display: flex; gap: 6px; justify-content: flex-end; margin-top: 8px; }
</style>
@endpush

@section('content')
<div style="margin-bottom:32px">
    <div class="section-label">Akun Saya</div>
    <h1 class="page-title">PESANAN <span>SAYA</span></h1>
</div>

@forelse($orders as $order)
<a href="/orders/{{ $order->id }}" class="order-row">
    <div>
        <div class="order-number">{{ $order->order_number }}</div>
        <div class="order-items-preview">
            {{ $order->items->first()->product_name ?? 'Order' }}
            @if($order->items->count() > 1)
                <span style="font-size:14px;color:var(--text-muted)"> +{{ $order->items->count() - 1 }} item lainnya</span>
            @endif
        </div>
        <div class="order-meta">
            <span class="order-date">
                <i class="fa-regular fa-clock" style="margin-right:4px"></i>
                {{ $order->ordered_at->format('d M Y, H:i') }}
            </span>
            @if($order->purchase_type === 'credit')
                <span class="badge badge-yellow"><i class="fa-solid fa-landmark" style="margin-right:4px"></i>Kredit</span>
            @else
                <span class="badge badge-gray"><i class="fa-solid fa-money-bill" style="margin-right:4px"></i>Cash</span>
            @endif
        </div>
    </div>
    <div class="order-right">
        <div class="order-total">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</div>
        <div class="order-badges">
            @php
                $statusMap = [
                    'pending'   => 'badge-yellow',
                    'confirmed' => 'badge-blue',
                    'shipped'   => 'badge-blue',
                    'delivered' => 'badge-green',
                    'cancelled' => 'badge-red',
                ];
                $statusLabel = [
                    'pending'   => 'Menunggu',
                    'confirmed' => 'Dikonfirmasi',
                    'shipped'   => 'Dikirim',
                    'delivered' => 'Diterima',
                    'cancelled' => 'Dibatalkan',
                ];
            @endphp
            <span class="badge {{ $statusMap[$order->status] ?? 'badge-gray' }}">
                {{ $statusLabel[$order->status] ?? $order->status }}
            </span>
        </div>
    </div>
</a>
@empty
    <div style="text-align:center;padding:80px 0;color:var(--text-dim)">
        <i class="fa-solid fa-receipt" style="font-size:48px;display:block;margin-bottom:16px"></i>
        <div style="font-family:'Bebas Neue';font-size:28px;letter-spacing:2px;color:var(--text-muted);margin-bottom:8px">BELUM ADA PESANAN</div>
        <a href="/products" class="btn btn-primary" style="margin-top:16px">Mulai Belanja</a>
    </div>
@endforelse

<div style="margin-top:24px">{{ $orders->links() }}</div>
@endsection
