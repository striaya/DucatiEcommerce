@extends('admin.layout')
@section('title', 'Orders')
@section('topbar-title', 'Manajemen Orders')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <div class="label">Manajemen</div>
        <h1>ORDERS</h1>
    </div>
</div>

<form method="GET" action="/admin/orders">
    <div class="filter-bar">
        <select name="status" class="form-control">
            <option value="">Semua Status</option>
            @foreach(['pending','confirmed','shipped','delivered','cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status')===$s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <select name="purchase_type" class="form-control">
            <option value="">Semua Tipe</option>
            <option value="cash"   {{ request('purchase_type')==='cash'   ? 'selected' : '' }}>Cash</option>
            <option value="credit" {{ request('purchase_type')==='credit' ? 'selected' : '' }}>Kredit</option>
        </select>
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-filter"></i>Filter</button>
        @if(request()->anyFilled(['status','purchase_type']))
            <a href="/admin/orders" class="btn btn-ghost btn-sm">Reset</a>
        @endif
    </div>
</form>

<div class="table-card">
    <div class="table-card-header">
        <div class="table-card-title">DAFTAR ORDER</div>
        <span style="font-family:'Barlow Condensed';font-size:12px;letter-spacing:1px;color:var(--text-dim)">
            {{ $orders->total() }} order
        </span>
    </div>
    <table>
        <thead>
            <tr>
                <th>Order</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total</th>
                <th>Tipe</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            @php
                $statusMap = [
                    'pending'   => 'badge-yellow',
                    'confirmed' => 'badge-blue',
                    'shipped'   => 'badge-orange',
                    'delivered' => 'badge-green',
                    'cancelled' => 'badge-red',
                ];
            @endphp
            <tr>
                <td>
                    <div style="font-family:'Barlow Condensed';font-size:13px;letter-spacing:1px">{{ $order->order_number }}</div>
                </td>
                <td>
                    <div style="font-size:13px">{{ $order->user->full_name ?? '—' }}</div>
                    <div style="font-size:11px;color:var(--text-dim)">{{ $order->user->email ?? '' }}</div>
                </td>
                <td style="font-family:'Bebas Neue';font-size:18px;color:var(--text-dim)">
                    {{ $order->items->count() }}
                </td>
                <td style="font-family:'Bebas Neue';font-size:16px;color:var(--red)">
                    Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                </td>
                <td>
                    <span class="badge {{ $order->purchase_type === 'credit' ? 'badge-blue' : 'badge-gray' }}">
                        {{ $order->purchase_type }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $statusMap[$order->status] ?? 'badge-gray' }}">{{ $order->status }}</span>
                </td>
                <td style="font-size:11px;color:var(--text-dim);font-family:'Barlow Condensed';letter-spacing:1px">
                    {{ $order->ordered_at->format('d M Y') }}
                </td>
                <td>
                    <a href="/admin/orders/{{ $order->id }}" class="btn btn-ghost btn-sm">
                        <i class="fa-solid fa-eye"></i>Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">
                    <div class="empty-state">
                        <i class="fa-solid fa-receipt"></i>
                        <p>Tidak ada order ditemukan</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-wrap">
        <span>Menampilkan {{ $orders->firstItem() }}–{{ $orders->lastItem() }} dari {{ $orders->total() }}</span>
        <div class="pagination-links">{{ $orders->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
