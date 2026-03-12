@extends('admin.layout')
@section('title', 'Detail Order')
@section('topbar-title', 'Detail Order')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <div class="label">Orders</div>
        <h1>{{ $order->order_number }}</h1>
    </div>
    <a href="/admin/orders" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left"></i>Kembali
    </a>
</div>

@php
    $statusMap = [
        'pending'   => 'badge-yellow',
        'confirmed' => 'badge-blue',
        'shipped'   => 'badge-orange',
        'delivered' => 'badge-green',
        'cancelled' => 'badge-red',
    ];
@endphp

<div class="detail-grid">
    <div>
        {{-- ORDER INFO --}}
        <div class="info-block">
            <div class="info-block-title"><i class="fa-solid fa-receipt"></i>INFORMASI ORDER</div>
            <div class="info-row">
                <span class="info-row-label">Nomor Order</span>
                <span class="info-row-val" style="font-family:'Bebas Neue';letter-spacing:1px">{{ $order->order_number }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Status</span>
                <span class="badge {{ $statusMap[$order->status] ?? 'badge-gray' }}">{{ $order->status }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Tipe Pembelian</span>
                <span class="badge {{ $order->purchase_type === 'credit' ? 'badge-blue' : 'badge-gray' }}">{{ $order->purchase_type }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Tanggal Order</span>
                <span class="info-row-val">{{ $order->ordered_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Subtotal</span>
                <span class="info-row-val">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Grand Total</span>
                <span class="info-row-val" style="color:var(--red);font-family:'Bebas Neue';font-size:20px">
                    Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- ITEMS --}}
        <div class="info-block">
            <div class="info-block-title"><i class="fa-solid fa-motorcycle"></i>ITEM ORDER</div>
            @foreach($order->items as $item)
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border)">
                <div>
                    <div style="font-family:'Barlow Condensed';font-size:15px;letter-spacing:0.5px">{{ $item->product_name }}</div>
                    <div style="font-size:11px;color:var(--text-dim);margin-top:2px">
                        {{ $item->quantity }} unit × Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                    </div>
                </div>
                <div style="font-family:'Bebas Neue';font-size:16px;color:var(--red)">
                    Rp {{ number_format($item->total_price, 0, ',', '.') }}
                </div>
            </div>
            @endforeach
        </div>

        {{-- UPDATE STATUS --}}
        <div class="info-block">
            <div class="info-block-title"><i class="fa-solid fa-pen-to-square"></i>UPDATE STATUS</div>
            <form method="POST" action="/admin/orders/{{ $order->id }}/status" style="display:flex;gap:12px;align-items:flex-end">
                @csrf @method('PUT')
                <div class="form-group" style="flex:1;margin-bottom:0">
                    <label class="form-label">Status Baru</label>
                    <select name="status" class="form-control">
                        @foreach(['pending','confirmed','shipped','delivered','cancelled'] as $s)
                            <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>Update
                </button>
            </form>
        </div>
    </div>

    <div>
        {{-- CUSTOMER INFO --}}
        <div class="info-block">
            <div class="info-block-title"><i class="fa-solid fa-user"></i>DATA CUSTOMER</div>
            <div class="info-row">
                <span class="info-row-label">Nama</span>
                <span class="info-row-val">{{ $order->user->full_name ?? '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Email</span>
                <span class="info-row-val" style="font-size:12px">{{ $order->user->email ?? '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Telepon</span>
                <span class="info-row-val">{{ $order->user->phone ?? '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">KYC Status</span>
                @php $kycMap = ['verified'=>'badge-green','rejected'=>'badge-red','unverified'=>'badge-yellow']; @endphp
                <span class="badge {{ $kycMap[$order->user->kyc_status] ?? 'badge-gray' }}">{{ $order->user->kyc_status ?? '—' }}</span>
            </div>
        </div>

        {{-- ADDRESS --}}
        @if($order->address)
        <div class="info-block">
            <div class="info-block-title"><i class="fa-solid fa-location-dot"></i>ALAMAT PENGIRIMAN</div>
            <div style="font-family:'Barlow Condensed';font-size:14px;letter-spacing:0.5px;margin-bottom:6px">
                {{ $order->address->recipient_name }}
            </div>
            <div style="font-size:12px;color:var(--text-dim);line-height:1.7">
                {{ $order->address->street }}<br>
                {{ $order->address->city }}, {{ $order->address->province }}<br>
                {{ $order->address->postal_code }}
            </div>
        </div>
        @endif

        {{-- PAYMENTS --}}
        @if($order->payments->count() > 0)
        <div class="info-block">
            <div class="info-block-title"><i class="fa-solid fa-credit-card"></i>PEMBAYARAN</div>
            @foreach($order->payments as $pay)
            @php $payMap = ['success'=>'badge-green','pending'=>'badge-yellow','failed'=>'badge-red','refunded'=>'badge-orange']; @endphp
            <div class="info-row">
                <span class="info-row-label">{{ strtoupper($pay->method) }}</span>
                <span class="badge {{ $payMap[$pay->status] ?? 'badge-gray' }}">{{ $pay->status }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Jumlah</span>
                <span class="info-row-val">Rp {{ number_format($pay->amount, 0, ',', '.') }}</span>
            </div>
            @if($pay->paid_at)
            <div class="info-row">
                <span class="info-row-label">Dibayar</span>
                <span class="info-row-val" style="font-size:12px">{{ $pay->paid_at->format('d M Y H:i') }}</span>
            </div>
            @endif
            @endforeach
        </div>
        @endif

        {{-- CREDIT --}}
        @if($order->creditApplication)
        <div class="info-block">
            <div class="info-block-title"><i class="fa-solid fa-landmark"></i>KREDIT</div>
            <div class="info-row">
                <span class="info-row-label">Provider</span>
                <span class="info-row-val">{{ $order->creditApplication->provider }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Tenor</span>
                <span class="info-row-val">{{ $order->creditApplication->tenure_months }} bulan</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Cicilan/bulan</span>
                <span class="info-row-val" style="color:var(--red)">
                    Rp {{ number_format($order->creditApplication->monthly_installment, 0, ',', '.') }}
                </span>
            </div>
            <div style="margin-top:12px">
                <a href="/admin/credits/{{ $order->creditApplication->id }}" class="btn btn-ghost btn-sm" style="width:100%;justify-content:center">
                    <i class="fa-solid fa-eye"></i>Lihat Detail Kredit
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
