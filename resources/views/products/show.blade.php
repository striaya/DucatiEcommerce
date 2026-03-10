@extends('layouts.app')
@section('title', $product->name)

@push('styles')
<style>
    .product-detail-grid {
        display: grid;
        grid-template-columns: 1fr 420px;
        gap: 40px;
        margin-bottom: 64px;
    }
    .product-visual { position: relative; }
    .product-main-img {
        width: 100%;
        aspect-ratio: 16/9;
        object-fit: cover;
        background: var(--surface);
        border: 1px solid var(--border);
        filter: brightness(0.9);
    }
    .product-main-placeholder {
        width: 100%;
        aspect-ratio: 16/9;
        background: var(--surface);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-dim);
        font-size: 80px;
    }
    .product-cat-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }
    .product-cat-bar a {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--text-dim);
        text-decoration: none;
        transition: color 0.2s;
    }
    .product-cat-bar a:hover { color: var(--red); }
    .product-cat-bar span { color: var(--text-dim); font-size: 11px; }

    .product-detail-name {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 52px;
        letter-spacing: 2px;
        line-height: 0.95;
        margin-bottom: 16px;
    }
    .product-rating {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }
    .stars { color: #C9A84C; letter-spacing: 2px; font-size: 14px; }
    .rating-count { font-family: 'Barlow Condensed', sans-serif; font-size: 12px; letter-spacing: 1px; color: var(--text-dim); }

    .product-price-block {
        padding: 20px 0;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        margin-bottom: 24px;
    }
    .product-detail-price {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 40px;
        letter-spacing: 2px;
        color: var(--red);
    }
    .product-detail-price-note {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 12px;
        letter-spacing: 1px;
        color: var(--text-dim);
        margin-top: 4px;
    }

    .specs-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2px;
        margin-bottom: 24px;
    }
    .spec-item {
        background: var(--surface2);
        padding: 14px 16px;
        border: 1px solid var(--border);
    }
    .spec-label {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--text-dim);
        margin-bottom: 4px;
    }
    .spec-value {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 22px;
        letter-spacing: 1px;
        color: var(--text);
    }

    .qty-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }
    .qty-label {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--text-muted);
        min-width: 60px;
    }
    .qty-input {
        background: var(--surface2);
        border: 1px solid var(--border);
        color: var(--text);
        width: 80px;
        padding: 10px 14px;
        font-family: 'Barlow', sans-serif;
        font-size: 16px;
        text-align: center;
        outline: none;
    }
    .qty-input:focus { border-color: var(--border-red); }

    .stock-info {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 12px;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 16px;
    }
    .stock-dot { width: 6px; height: 6px; border-radius: 50%; }
    .stock-dot.available { background: #00C864; box-shadow: 0 0 6px #00C864; }
    .stock-dot.empty { background: var(--text-dim); }

    .add-to-cart-form { margin-bottom: 12px; }

    .product-desc {
        padding-top: 24px;
        border-top: 1px solid var(--border);
    }
    .product-desc-title {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--text-dim);
        margin-bottom: 12px;
    }
    .product-desc p {
        font-size: 14px;
        line-height: 1.7;
        color: var(--text-muted);
    }

    .reviews-section { margin-top: 64px; }
    .reviews-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border);
        margin-bottom: 24px;
    }
    .review-card {
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 20px 24px;
        margin-bottom: 2px;
    }
    .review-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .reviewer-name {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 14px;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--text);
        margin-bottom: 2px;
    }
    .review-title { font-size: 14px; font-weight: 500; color: var(--text); margin-bottom: 6px; }
    .review-body { font-size: 13px; color: var(--text-muted); line-height: 1.6; }

    .related-section { margin-top: 64px; }
    .related-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2px;
        margin-top: 24px;
    }
    .related-card {
        background: var(--surface);
        border: 1px solid var(--border);
        text-decoration: none;
        color: inherit;
        transition: border-color 0.2s;
        display: block;
    }
    .related-card:hover { border-color: var(--border-red); }
    .related-img {
        width: 100%;
        aspect-ratio: 16/9;
        object-fit: cover;
        background: var(--surface2);
        filter: brightness(0.85);
    }
    .related-info { padding: 14px 16px; }
    .related-name {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 18px;
        letter-spacing: 1px;
        margin-bottom: 4px;
    }
    .related-price {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 14px;
        color: var(--red);
        letter-spacing: 1px;
    }
</style>
@endpush

@section('content')

<div class="product-cat-bar" style="margin-bottom:24px">
    <a href="/products"><i class="fa-solid fa-house" style="font-size:10px"></i></a>
    <span>/</span>
    <a href="/products">Motor</a>
    @if($product->category)
        <span>/</span>
        <a href="/products?category_id={{ $product->category->id }}">{{ $product->category->name }}</a>
    @endif
    <span>/</span>
    <span style="color: var(--text-muted); font-family:'Barlow Condensed'; font-size:11px; letter-spacing:2px; text-transform:uppercase">{{ $product->name }}</span>
</div>

<div class="product-detail-grid">

    <div class="product-visual">
        @if($product->image_url)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-main-img">
        @else
            <div class="product-main-placeholder">
                <i class="fa-solid fa-motorcycle"></i>
            </div>
        @endif
    </div>

    <div>
        <div class="product-cat-bar">
            @if($product->category)
                <span class="badge badge-red">{{ $product->category->name }}</span>
            @endif
            @if($product->credit_eligible)
                <span class="badge badge-yellow">Tersedia Kredit</span>
            @endif
        </div>

        <h1 class="product-detail-name">{{ $product->name }}</h1>

        <div class="product-rating">
            <div class="stars">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($avgRating))
                        <i class="fa-solid fa-star" style="font-size:13px"></i>
                    @elseif($i - $avgRating < 1)
                        <i class="fa-solid fa-star-half-stroke" style="font-size:13px"></i>
                    @else
                        <i class="fa-regular fa-star" style="font-size:13px"></i>
                    @endif
                @endfor
            </div>
            <span class="rating-count">{{ $avgRating }} / 5.0 &nbsp;·&nbsp; {{ $product->reviews->count() }} Ulasan</span>
        </div>

        <div class="product-price-block">
            <div class="product-detail-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            @if($product->credit_eligible)
                <div class="product-detail-price-note">
                    <i class="fa-solid fa-info-circle" style="margin-right:4px; color:var(--red)"></i>
                    Tersedia opsi kredit &amp; cicilan
                </div>
            @endif
        </div>

        @if($product->engine_cc || $product->power_hp)
        <div class="specs-grid">
            @if($product->engine_cc)
            <div class="spec-item">
                <div class="spec-label"><i class="fa-solid fa-gear" style="margin-right:4px"></i>Kapasitas Mesin</div>
                <div class="spec-value">{{ $product->engine_cc }} <span style="font-size:14px;color:var(--text-muted)">CC</span></div>
            </div>
            @endif
            @if($product->power_hp)
            <div class="spec-item">
                <div class="spec-label"><i class="fa-solid fa-bolt" style="margin-right:4px"></i>Tenaga Maksimal</div>
                <div class="spec-value">{{ $product->power_hp }} <span style="font-size:14px;color:var(--text-muted)">HP</span></div>
            </div>
            @endif
        </div>
        @endif

        <div class="stock-info">
            @if($product->stock > 0)
                <div class="stock-dot available"></div>
                <span style="color:#00C864">Tersedia</span>
                <span style="color:var(--text-dim)">— {{ $product->stock }} unit</span>
            @else
                <div class="stock-dot empty"></div>
                <span style="color:var(--text-dim)">Stok Habis</span>
            @endif
        </div>

        @if($product->stock > 0)
            @auth
            <form method="POST" action="/cart" class="add-to-cart-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="qty-wrap">
                    <span class="qty-label">Jumlah</span>
                    <input type="number" name="quantity" value="1" min="1"
                           max="{{ $product->stock }}" class="qty-input">
                </div>
                <button type="submit" class="btn btn-primary btn-block" style="font-size:15px;letter-spacing:3px">
                    <i class="fa-solid fa-bag-shopping" style="margin-right:10px"></i>
                    TAMBAH KE KERANJANG
                </button>
            </form>
            @else
                <a href="/login" class="btn btn-primary btn-block" style="font-size:15px;letter-spacing:3px">
                    <i class="fa-solid fa-arrow-right-to-bracket" style="margin-right:10px"></i>
                    MASUK UNTUK MEMBELI
                </a>
            @endauth
        @else
            <button class="btn btn-ghost btn-block" disabled style="opacity:0.4;cursor:not-allowed">
                STOK HABIS
            </button>
        @endif

        @if($product->description)
        <div class="product-desc">
            <div class="product-desc-title">Deskripsi</div>
            <p>{{ $product->description }}</p>
        </div>
        @endif
    </div>
</div>

<div class="reviews-section">
    <div class="reviews-header">
        <div>
            <div class="section-label">Ulasan Pembeli</div>
            <h2 class="page-title" style="font-size:32px">{{ $product->reviews->count() }} <span>ULASAN</span></h2>
        </div>
        <div style="display:flex;align-items:center;gap:8px">
            <span style="font-family:'Bebas Neue';font-size:48px;color:var(--gold)">{{ $avgRating }}</span>
            <div>
                <div class="stars" style="font-size:16px">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($avgRating))<i class="fa-solid fa-star"></i>
                        @elseif($i - $avgRating < 1)<i class="fa-solid fa-star-half-stroke"></i>
                        @else<i class="fa-regular fa-star"></i>
                        @endif
                    @endfor
                </div>
                <div style="font-family:'Barlow Condensed';font-size:11px;letter-spacing:2px;color:var(--text-dim);margin-top:4px">DARI 5.0</div>
            </div>
        </div>
    </div>

    @forelse($product->reviews as $review)
    <div class="review-card">
        <div class="review-card-header">
            <div>
                <div class="reviewer-name">{{ $review->user->full_name }}</div>
                <div class="stars" style="font-size:11px">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)<i class="fa-solid fa-star"></i>
                        @else<i class="fa-regular fa-star"></i>
                        @endif
                    @endfor
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px">
                @if($review->is_verified)
                    <span class="badge badge-green">
                        <i class="fa-solid fa-circle-check" style="margin-right:4px"></i>Pembelian Terverifikasi
                    </span>
                @endif
                <span style="font-family:'Barlow Condensed';font-size:11px;letter-spacing:1px;color:var(--text-dim)">
                    {{ $review->created_at->format('d M Y') }}
                </span>
            </div>
        </div>
        @if($review->title)
            <div class="review-title">{{ $review->title }}</div>
        @endif
        @if($review->body)
            <div class="review-body">{{ $review->body }}</div>
        @endif
    </div>
    @empty
        <div style="padding:40px;text-align:center;color:var(--text-dim)">
            <i class="fa-regular fa-comment" style="font-size:32px;display:block;margin-bottom:12px"></i>
            <div style="font-family:'Barlow Condensed';font-size:13px;letter-spacing:2px;text-transform:uppercase">Belum Ada Ulasan</div>
        </div>
    @endforelse
</div>

@if($related->isNotEmpty())
<div class="related-section">
    <div class="section-label">Model Lainnya</div>
    <h2 class="page-title" style="font-size:32px">MUNGKIN <span>KAMU SUKA</span></h2>
    <div class="related-grid">
        @foreach($related as $rel)
        <a href="/products/{{ $rel->id }}" class="related-card">
            @if($rel->image_url)
                <img src="{{ $rel->image_url }}" alt="{{ $rel->name }}" class="related-img">
            @else
                <div class="related-img" style="display:flex;align-items:center;justify-content:center;color:var(--text-dim)">
                    <i class="fa-solid fa-motorcycle" style="font-size:32px"></i>
                </div>
            @endif
            <div class="related-info">
                <div class="related-name">{{ $rel->name }}</div>
                <div class="related-price">Rp {{ number_format($rel->price, 0, ',', '.') }}</div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

@endsection
