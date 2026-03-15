@extends('admin.layout')
@section('title', 'Products')
@section('topbar-title', 'Manajemen Products')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <div class="label">Manajemen</div>
        <h1>PRODUCTS</h1>
    </div>
    <a href="/admin/products/create" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i>Tambah Motor
    </a>
</div>

<form method="GET" action="/admin/products">
    <div class="filter-bar">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama motor..." class="form-control" style="min-width:220px">
        <select name="category_id" class="form-control">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <select name="is_active" class="form-control">
            <option value="">Semua Status</option>
            <option value="1" {{ request('is_active')==='1' ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ request('is_active')==='0' ? 'selected' : '' }}>Nonaktif</option>
        </select>
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-filter"></i>Filter</button>
        @if(request()->anyFilled(['search','category_id','is_active']))
            <a href="/admin/products" class="btn btn-ghost btn-sm">Reset</a>
        @endif
    </div>
</form>

<div class="table-card">
    <div class="table-card-header">
        <div class="table-card-title">DAFTAR MOTOR</div>
        <span style="font-family:'Barlow Condensed';font-size:12px;letter-spacing:1px;color:var(--text-dim)">
            {{ $products->total() }} produk
        </span>
    </div>
    <table>
        <thead>
            <tr>
                <th>Motor</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Kredit</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:12px">
                        @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                             style="width:48px;height:36px;object-fit:cover;border:1px solid var(--border)">
                        @else
                        <div style="width:48px;height:36px;background:var(--surface2);border:1px solid var(--border);display:flex;align-items:center;justify-content:center">
                            <i class="fa-solid fa-motorcycle" style="color:var(--text-muted);font-size:14px"></i>
                        </div>
                        @endif
                        <div>
                            <div style="font-family:'Barlow Condensed';font-size:14px;letter-spacing:0.5px">{{ $product->name }}</div>
                            <div style="font-size:11px;color:var(--text-dim);margin-top:1px">{{ $product->engine_cc }}cc · {{ $product->power_hp }}hp</div>
                        </div>
                    </div>
                </td>
                <td style="font-size:12px;color:var(--text-dim)">{{ $product->category->name ?? '—' }}</td>
                <td style="font-family:'Bebas Neue';font-size:16px;color:var(--red)">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </td>
                <td>
                    <span class="badge {{ $product->stock === 0 ? 'badge-red' : ($product->stock <= 3 ? 'badge-yellow' : 'badge-green') }}">
                        {{ $product->stock }} unit
                    </span>
                </td>
                <td>
                    @if($product->credit_eligible)
                        <span class="badge badge-green"><i class="fa-solid fa-check"></i>Ya</span>
                    @else
                        <span class="badge badge-gray">Tidak</span>
                    @endif
                </td>
                <td>
                    <span class="badge {{ $product->is_active ? 'badge-green' : 'badge-red' }}">
                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px">
                        <a href="/admin/products/{{ $product->id }}/edit" class="btn btn-ghost btn-sm">
                            <i class="fa-solid fa-pen"></i>Edit
                        </a>
                        <form method="POST" action="/admin/products/{{ $product->id }}"
                              onsubmit="return confirm('Hapus motor ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <i class="fa-solid fa-motorcycle"></i>
                        <p>Tidak ada produk ditemukan</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-wrap">
        <span>Menampilkan {{ $products->firstItem() }}–{{ $products->lastItem() }} dari {{ $products->total() }}</span>
        <div class="pagination-links">{{ $products->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
