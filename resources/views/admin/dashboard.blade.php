@extends('admin.layout')
@section('title', 'Dashboard')
@section('topbar-title', 'Dashboard')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <div class="label">Overview</div>
        <h1>DASHBOARD</h1>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card" style="--accent: var(--blue)">
        <div class="stat-label">Total Users</div>
        <div class="stat-value">{{ $totalUsers }}</div>
        <div class="stat-sub">{{ $verifiedUsers }} KYC terverifikasi</div>
        <i class="fa-solid fa-users stat-icon"></i>
    </div>
    <div class="stat-card" style="--accent: var(--red)">
        <div class="stat-label">Total Orders</div>
        <div class="stat-value">{{ $totalOrders }}</div>
        <div class="stat-sub">{{ $pendingOrders }} menunggu konfirmasi</div>
        <i class="fa-solid fa-receipt stat-icon"></i>
    </div>
    <div class="stat-card" style="--accent: var(--green)">
        <div class="stat-label">Total Pendapatan</div>
        <div class="stat-value" style="font-size:24px">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <div class="stat-sub">Dari order delivered</div>
        <i class="fa-solid fa-money-bill-wave stat-icon"></i>
    </div>
    <div class="stat-card" style="--accent: var(--yellow)">
        <div class="stat-label">Pengajuan Kredit</div>
        <div class="stat-value">{{ $totalCredits }}</div>
        <div class="stat-sub">{{ $pendingCredits }} menunggu review</div>
        <i class="fa-solid fa-landmark stat-icon"></i>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">

    <div class="table-card">
        <div class="table-card-header">
            <div class="table-card-title">ORDER TERBARU</div>
            <a href="/admin/orders" class="btn btn-ghost btn-sm">Semua</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nomor Order</th>
                    <th>User</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
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
                        <a href="/admin/orders/{{ $order->id }}" style="color:var(--text);text-decoration:none;font-family:'Barlow Condensed';letter-spacing:1px;font-size:13px">
                            {{ $order->order_number }}
                        </a>
                    </td>
                    <td style="color:var(--text-dim);font-size:12px">{{ $order->user->full_name ?? '-' }}</td>
                    <td style="font-family:'Bebas Neue';font-size:15px;color:var(--red)">
                        Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                    </td>
                    <td><span class="badge {{ $statusMap[$order->status] ?? 'badge-gray' }}">{{ $order->status }}</span></td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:var(--text-muted);padding:24px;font-size:12px">Belum ada order</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <div class="table-card-title">KREDIT PENDING</div>
            <a href="/admin/credits" class="btn btn-ghost btn-sm">Semua</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Provider</th>
                    <th>Tenor</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentCredits as $credit)
                @php
                    $cMap = [
                        'pending'   => 'badge-yellow',
                        'approved'  => 'badge-blue',
                        'active'    => 'badge-green',
                        'rejected'  => 'badge-red',
                        'completed' => 'badge-gray',
                    ];
                @endphp
                <tr>
                    <td style="font-size:12px">{{ $credit->user->full_name ?? '-' }}</td>
                    <td style="font-family:'Barlow Condensed';letter-spacing:1px;font-size:13px">{{ $credit->provider }}</td>
                    <td style="color:var(--text-dim);font-size:12px">{{ $credit->tenure_months }} bln</td>
                    <td><span class="badge {{ $cMap[$credit->status] ?? 'badge-gray' }}">{{ $credit->status }}</span></td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:var(--text-muted);padding:24px;font-size:12px">Tidak ada kredit pending</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@if($lowStockProducts->count() > 0)
<div class="table-card" style="margin-top:24px">
    <div class="table-card-header">
        <div class="table-card-title" style="display:flex;align-items:center;gap:8px">
            <i class="fa-solid fa-triangle-exclamation" style="color:var(--yellow);font-size:13px"></i>
            STOK MENIPIS
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lowStockProducts as $product)
            <tr>
                <td style="font-family:'Barlow Condensed';letter-spacing:1px">{{ $product->name }}</td>
                <td style="color:var(--text-dim);font-size:12px">{{ $product->category->name ?? '-' }}</td>
                <td>
                    <span class="badge {{ $product->stock === 0 ? 'badge-red' : 'badge-yellow' }}">
                        {{ $product->stock }} unit
                    </span>
                </td>
                <td>
                    <a href="/admin/products/{{ $product->id }}/edit" class="btn btn-ghost btn-sm">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection
