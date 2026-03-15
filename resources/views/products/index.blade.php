@extends('layouts.app')
@section('title', 'Koleksi Motor')

@push('styles')
<style>
    .products-hero {
        border-bottom: 1px solid var(--border);
        padding-bottom: 32px;
        margin-bottom: 40px;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
    }   
    .products-hero-left .section-label { margin-bottom: 6px; }
    .products-count {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 13px;
        letter-spacing: 1px;
        color: var(--text-dim);
        margin-top: 8px;
    }

    .filter-bar {
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 20px 24px;
        margin-bottom: 32px;
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: flex-end;
    }
    .filter-group { display: flex; flex-direction: column; gap: 6px; }
    .filter-label {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--text-dim);
    }
    .filter-control {
        background: var(--surface2);
        border: 1px solid var(--border);
        color: var(--text);
        padding: 9px 14px;
        font-family: 'Barlow', sans-serif;
        font-size: 13px;
        outline: none;
        transition: border-color 0.2s;
        min-width: 160px;
    }
    .filter-control:focus { border-color: var(--border-red); }
    .filter-control::placeholder { color: var(--text-dim); }
    .filter-check-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 9px 0;
    }
    .filter-check-wrap input[type="checkbox"] { accent-color: var(--red); width: 14px; height: 14px; }
    .filter-check-wrap label {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 12px;
        letter-spacing: 1px;
        color: var(--text-muted);
        cursor: pointer;
        text-transform: uppercase;
    }
    .filter-actions { display: flex; gap: 8px; align-items: flex-end; margin-left: auto; }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2px;
    }
    .product-card {
        background: var(--surface);
        border: 1px solid var(--border);
        text-decoration: none;
        color: inherit;
        display: block;
        position: relative;
        overflow: hidden;
        transition: border-color 0.25s;
        cursor: pointer;
    }
    .product-card:hover { border-color: var(--border-red); }
    .product-card:hover .product-img { transform: scale(1.05); }
    .product-card:hover .product-overlay { opacity: 1; }

    .product-img-wrap {
        aspect-ratio: 16/9;
        overflow: hidden;
        background: var(--surface2);
        position: relative;
    }
    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
        filter: brightness(0.85);
    }
    .product-img-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-dim);
        font-size: 48px;
    }
    .product-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(224,0,0,0.15), transparent);
        opacity: 0;
        transition: opacity 0.3s;
    }
    .product-cat-tag {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(10,10,10,0.85);
        border: 1px solid var(--border-red);
        padding: 3px 10px;
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--red);
        backdrop-filter: blur(4px);
    }

    .product-info { padding: 18px 20px; }
    .product-name {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 22px;
        letter-spacing: 1.5px;
        color: var(--text);
        line-height: 1.1;
        margin-bottom: 4px;
    }
    .product-specs {
        display: flex;
        gap: 12px;
        margin-bottom: 12px;
    }
    .product-spec {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        letter-spacing: 1px;
        color: var(--text-dim);
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .product-spec i { font-size: 9px; color: var(--red); }

    .product-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid var(--border);
    }
    .product-price {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 20px;
        letter-spacing: 1px;
        color: var(--red);
    }
    .product-price-sub {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 10px;
        letter-spacing: 1px;
        color: var(--text-dim);
        margin-top: 1px;
    }
    .product-badges { display: flex; gap: 6px; flex-wrap: wrap; }

    .empty-state {
        text-align: center;
        padding: 80px 0;
        color: var(--text-dim);
    }
    .empty-state i { font-size: 48px; margin-bottom: 16px; display: block; }
    .empty-state-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 28px;
        letter-spacing: 2px;
        color: var(--text-muted);
        margin-bottom: 8px;
    }

    .pagination-wrap {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }
    .pagination-wrap nav { display: flex; gap: 4px; }
</style>
@endpush

@section('content')
<div class="products-hero">
    <div class="products-hero-left">
        <div class="section-label">Koleksi Eksklusif</div>
        <h1 class="page-title">MOTOR <span>DUCATI</span></h1>
        <div class="products-count">Menampilkan {{ $products->total() }} model tersedia</div>
    </div>
    @auth
    <a href="/cart" class="btn btn-outline">
        <i class="fa-solid fa-bag-shopping" style="margin-right:8px"></i>Keranjang
    </a>
    @endauth
</div>

<form method="GET" action="/products" class="filter-bar">
    <div class="filter-group">
        <span class="filter-label">Kategori</span>
        <select name="category_id" class="filter-control">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="filter-group">
        <span class="filter-label">Cari Model</span>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Contoh: Panigale..." class="filter-control">
    </div>
    <div class="filter-group">
        <span class="filter-label">Harga Maksimal</span>
        <input type="number" name="max_price" value="{{ request('max_price') }}"
               placeholder="Rp 1.000.000.000" class="filter-control">
    </div>
    <div class="filter-group">
        <span class="filter-label">Opsi</span>
        <div class="filter-check-wrap">
            <input type="checkbox" name="credit_eligible" id="credit_eligible" value="1"
                   {{ request('credit_eligible') ? 'checked' : '' }}>
            <label for="credit_eligible">Tersedia Kredit</label>
        </div>
    </div>
    <div class="filter-actions">
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-sliders" style="margin-right:6px"></i>Filter
        </button>
        <a href="/products" class="btn btn-ghost btn-sm">Reset</a>
    </div>
</form>

@if($products->isEmpty())
    <div class="empty-state">
        <i class="fa-solid fa-magnifying-glass"></i>
        <div class="empty-state-title">Tidak Ada Motor Ditemukan</div>
        <p style="font-size:14px">Coba ubah filter pencarianmu</p>
    </div>
@else
    <div class="product-grid">
        @foreach($products as $product)
        <a href="/products/{{ $product->id }}" class="product-card">
            <div class="product-img-wrap">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-img">
                @else
                    <div class="product-img-placeholder">
                        <i class="fa-solid fa-motorcycle"></i>
                    </div>
                @endif
                <div class="product-overlay"></div>
                @if($product->category)
                    <div class="product-cat-tag">{{ $product->category->name }}</div>
                @endif
            </div>
            <div class="product-info">
                <div class="product-name">{{ $product->name }}</div>
                <div class="product-specs">
                    @if($product->engine_cc)
                        <div class="product-spec">
                            <i class="fa-solid fa-circle"></i>{{ $product->engine_cc }} cc
                        </div>
                    @endif
                    @if($product->power_hp)
                        <div class="product-spec">
                            <i class="fa-solid fa-circle"></i>{{ $product->power_hp }} HP
                        </div>
                    @endif
                </div>
                <div class="product-footer">
                    <div>
                        <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        @if($product->credit_eligible)
                            <div class="product-price-sub">Tersedia cicilan</div>
                        @endif
                    </div>
                    <div class="product-badges">
                        @if($product->stock > 0)
                            <span class="badge badge-green">
                                <i class="fa-solid fa-circle" style="font-size:6px;margin-right:4px"></i>Tersedia
                            </span>
                        @else
                            <span class="badge badge-gray">Habis</span>
                        @endif
                        @if($product->credit_eligible)
                            <span class="badge badge-yellow">Kredit</span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="pagination-wrap">
        {{ $products->links() }}
    </div>
@endif
@endsection
