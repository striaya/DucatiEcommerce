@extends('admin.layout')
@section('title', isset($product) ? 'Edit Motor' : 'Tambah Motor')
@section('topbar-title', isset($product) ? 'Edit Motor' : 'Tambah Motor')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <div class="label">Products</div>
        <h1>{{ isset($product) ? 'EDIT MOTOR' : 'TAMBAH MOTOR' }}</h1>
    </div>
    <a href="/admin/products" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left"></i>Kembali
    </a>
</div>

<form method="POST" action="{{ isset($product) ? '/admin/products/'.$product->id : '/admin/products' }}"
      style="max-width:800px">
    @csrf
    @if(isset($product)) @method('PUT') @endif

    @if($errors->any())
    <div class="flash flash-error" style="margin-bottom:20px">
        <i class="fa-solid fa-circle-xmark"></i>
        <div>
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
    </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">
        <div>
            <div class="info-block">
                <div class="info-block-title"><i class="fa-solid fa-motorcycle"></i>INFORMASI DASAR</div>

                <div class="form-group">
                    <label class="form-label">Nama Motor <span style="color:var(--red)">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}"
                           required class="form-control" placeholder="Ducati Panigale V4 S">
                </div>

                <div class="form-group">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $product->slug ?? '') }}"
                           class="form-control" placeholder="ducati-panigale-v4-s">
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori <span style="color:var(--red)">*</span></label>
                    <select name="category_id" required class="form-control">
                        <option value="">— Pilih Kategori —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" rows="4" class="form-control"
                              placeholder="Deskripsi motor...">{{ old('description', $product->description ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">URL Gambar</label>
                    <input type="url" name="image_url" value="{{ old('image_url', $product->image_url ?? '') }}"
                           class="form-control" placeholder="https://...">
                </div>
            </div>
        </div>

        <div>
            <div class="info-block">
                <div class="info-block-title"><i class="fa-solid fa-gear"></i>SPESIFIKASI & HARGA</div>

                <div class="form-group">
                    <label class="form-label">Harga (Rp) <span style="color:var(--red)">*</span></label>
                    <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}"
                           required class="form-control" placeholder="750000000" min="0">
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div class="form-group">
                        <label class="form-label">Engine (CC)</label>
                        <input type="number" name="engine_cc" value="{{ old('engine_cc', $product->engine_cc ?? '') }}"
                               class="form-control" placeholder="998">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Power (HP)</label>
                        <input type="number" name="power_hp" step="0.1" value="{{ old('power_hp', $product->power_hp ?? '') }}"
                               class="form-control" placeholder="214.5">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Stok <span style="color:var(--red)">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}"
                           required class="form-control" min="0">
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div class="form-group">
                        <label class="form-label">Kredit Eligible</label>
                        <select name="credit_eligible" class="form-control">
                            <option value="1" {{ old('credit_eligible', $product->credit_eligible ?? 1) == 1 ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ old('credit_eligible', $product->credit_eligible ?? 1) == 0 ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ old('is_active', $product->is_active ?? 1) == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active', $product->is_active ?? 1) == 0 ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:14px">
                <i class="fa-solid fa-floppy-disk"></i>
                {{ isset($product) ? 'SIMPAN PERUBAHAN' : 'TAMBAH MOTOR' }}
            </button>
        </div>
    </div>
</form>
@endsection
