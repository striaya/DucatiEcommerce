@extends('layouts.app')
@section('title', 'Keranjang')

@push('styles')
<style>
    .cart-layout { display: grid; grid-template-columns: 1fr 360px; gap: 32px; align-items: start; }
    .cart-item {
        background: var(--surface);
        border: 1px solid var(--border);
        display: grid;
        grid-template-columns: 140px 1fr auto;
        gap: 0;
        margin-bottom: 2px;
        transition: border-color 0.2s;
    }
    .cart-item:hover { border-color: var(--border-red); }
    .cart-item-img {
        width: 140px;
        height: 90px;
        object-fit: cover;
        filter: brightness(0.8);
    }
    .cart-item-img-placeholder {
        width: 140px;
        height: 90px;
        background: var(--surface2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-dim);
        font-size: 28px;
    }
    .cart-item-info { padding: 16px 20px; }
    .cart-item-name {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 20px;
        letter-spacing: 1.5px;
        color: var(--text);
        margin-bottom: 4px;
        text-decoration: none;
        display: block;
    }
    .cart-item-name:hover { color: var(--red); }
    .cart-item-cat {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--text-dim);
        margin-bottom: 12px;
    }
    .cart-qty-form { display: flex; align-items: center; gap: 8px; }
    .cart-qty-input {
        background: var(--surface2);
        border: 1px solid var(--border);
        color: var(--text);
        width: 60px;
        padding: 7px 10px;
        font-family: 'Barlow', sans-serif;
        font-size: 14px;
        text-align: center;
        outline: none;
    }
    .cart-qty-input:focus { border-color: var(--border-red); }
    .cart-item-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: space-between;
        padding: 16px 20px;
        border-left: 1px solid var(--border);
        min-width: 140px;
    }
    .cart-item-price {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 20px;
        letter-spacing: 1px;
        color: var(--red);
    }
    .cart-remove-btn {
        background: none;
        border: none;
        color: var(--text-dim);
        cursor: pointer;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
        font-family: 'Barlow Condensed', sans-serif;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 0;
        transition: color 0.2s;
    }
    .cart-remove-btn:hover { color: var(--red); }

    .cart-summary {
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 28px;
        position: sticky;
        top: 80px;
    }
    .summary-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 22px;
        letter-spacing: 2px;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border);
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 13px;
    }
    .summary-row-label {
        font-family: 'Barlow Condensed', sans-serif;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--text-muted);
    }
    .summary-row-val { color: var(--text); }
    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 16px;
        border-top: 1px solid var(--border);
        margin-top: 8px;
        margin-bottom: 24px;
    }
    .summary-total-label {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 16px;
        letter-spacing: 2px;
        color: var(--text-muted);
    }
    .summary-total-val {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 28px;
        letter-spacing: 1px;
        color: var(--red);
    }

    .empty-cart {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 0;
    }
    .empty-cart-icon {
        font-size: 64px;
        color: var(--text-dim);
        margin-bottom: 20px;
    }
    .empty-cart-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 32px;
        letter-spacing: 3px;
        color: var(--text-muted);
        margin-bottom: 8px;
    }
</style>
@endpush

@section('content')
<div style="margin-bottom:32px">
    <div class="section-label">Belanja</div>
    <h1 class="page-title">KERANJANG <span>BELANJA</span></h1>
</div>

@if($items->isEmpty())
    <div class="empty-cart">
        <div class="empty-cart-icon"><i class="fa-solid fa-bag-shopping"></i></div>
        <div class="empty-cart-title">Keranjang Kosong</div>
        <p style="color:var(--text-dim);font-size:14px;margin-bottom:24px">Belum ada motor yang dipilih</p>
        <a href="/products" class="btn btn-primary">
            <i class="fa-solid fa-motorcycle" style="margin-right:8px"></i>Lihat Koleksi Motor
        </a>
    </div>
@else
<div class="cart-layout">
    <div>
        @foreach($items as $item)
        <div class="cart-item">
            @if($item->product->image_url)
                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="cart-item-img">
            @else
                <div class="cart-item-img-placeholder"><i class="fa-solid fa-motorcycle"></i></div>
            @endif

            <div class="cart-item-info">
                <a href="/products/{{ $item->product->id }}" class="cart-item-name">{{ $item->product->name }}</a>
                <div class="cart-item-cat">{{ $item->product->category->name ?? 'Ducati' }}</div>
                <form method="POST" action="/cart/{{ $item->id }}" class="cart-qty-form">
                    @csrf @method('PUT')
                    <span style="font-family:'Barlow Condensed';font-size:11px;letter-spacing:2px;text-transform:uppercase;color:var(--text-dim)">Qty</span>
                    <input type="number" name="quantity" value="{{ $item->quantity }}"
                           min="1" max="{{ $item->product->stock }}" class="cart-qty-input">
                    <button type="submit" class="btn btn-ghost btn-sm">Update</button>
                </form>
            </div>

            <div class="cart-item-actions">
                <div class="cart-item-price">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</div>
                <form method="POST" action="/cart/{{ $item->id }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="cart-remove-btn">
                        <i class="fa-solid fa-xmark"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach

        <div style="margin-top:16px">
            <form method="POST" action="/cart">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-ghost btn-sm"
                        onclick="return confirm('Kosongkan seluruh keranjang?')">
                    <i class="fa-solid fa-trash" style="margin-right:6px"></i>Kosongkan Keranjang
                </button>
            </form>
        </div>
    </div>

    <div class="cart-summary">
        <div class="summary-title">RINGKASAN ORDER</div>
        <div class="summary-row">
            <span class="summary-row-label">{{ $items->count() }} Item</span>
            <span class="summary-row-val">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-row-label">Pengiriman</span>
            <span style="color:var(--text-dim);font-size:12px;font-family:'Barlow Condensed';letter-spacing:1px">Dihitung saat checkout</span>
        </div>
        <div class="summary-total">
            <span class="summary-total-label">Total</span>
            <span class="summary-total-val">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
        </div>
        <a href="/checkout" class="btn btn-primary btn-block" style="font-size:15px;letter-spacing:3px;margin-bottom:12px">
            <i class="fa-solid fa-arrow-right" style="margin-right:8px"></i>CHECKOUT
        </a>
        <a href="/products" class="btn btn-ghost btn-block" style="font-size:12px">
            Lanjut Belanja
        </a>
    </div>
</div>
@endif
@endsection
