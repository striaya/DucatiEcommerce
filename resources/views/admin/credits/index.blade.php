@extends('admin.layout')
@section('title', 'Credits')
@section('topbar-title', 'Manajemen Credits')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <div class="label">Manajemen</div>
        <h1>KREDIT</h1>
    </div>
</div>

<form method="GET" action="/admin/credits">
    <div class="filter-bar">
        <select name="status" class="form-control">
            <option value="">Semua Status</option>
            @foreach(['pending','approved','rejected','active','completed'] as $s)
                <option value="{{ $s }}" {{ request('status')===$s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-filter"></i>Filter</button>
        @if(request('status'))
            <a href="/admin/credits" class="btn btn-ghost btn-sm">Reset</a>
        @endif
    </div>
</form>

<div class="table-card">
    <div class="table-card-header">
        <div class="table-card-title">PENGAJUAN KREDIT</div>
        <span style="font-family:'Barlow Condensed';font-size:12px;letter-spacing:1px;color:var(--text-dim)">
            {{ $credits->total() }} pengajuan
        </span>
    </div>
    <table>
        <thead>
            <tr>
                <th>Customer</th>
                <th>Order</th>
                <th>Provider</th>
                <th>DP</th>
                <th>Cicilan/bln</th>
                <th>Tenor</th>
                <th>Status</th>
                <th>Diajukan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($credits as $credit)
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
                <td>
                    <div style="font-size:13px">{{ $credit->user->full_name ?? '—' }}</div>
                    <div style="font-size:11px;color:var(--text-dim)">{{ $credit->user->email ?? '' }}</div>
                </td>
                <td style="font-family:'Barlow Condensed';font-size:12px;letter-spacing:1px;color:var(--text-dim)">
                    {{ $credit->order->order_number ?? '—' }}
                </td>
                <td style="font-family:'Barlow Condensed';font-size:13px;letter-spacing:0.5px">{{ $credit->provider }}</td>
                <td style="font-size:12px">Rp {{ number_format($credit->dp_amount, 0, ',', '.') }}</td>
                <td style="font-family:'Bebas Neue';font-size:16px;color:var(--red)">
                    Rp {{ number_format($credit->monthly_installment, 0, ',', '.') }}
                </td>
                <td style="font-family:'Barlow Condensed';font-size:13px;color:var(--text-dim)">
                    {{ $credit->tenure_months }} bln
                </td>
                <td><span class="badge {{ $cMap[$credit->status] ?? 'badge-gray' }}">{{ $credit->status }}</span></td>
                <td style="font-size:11px;color:var(--text-dim);font-family:'Barlow Condensed';letter-spacing:1px">
                    {{ $credit->submitted_at->format('d M Y') }}
                </td>
                <td>
                    <a href="/admin/credits/{{ $credit->id }}" class="btn btn-ghost btn-sm">
                        <i class="fa-solid fa-eye"></i>Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9">
                    <div class="empty-state">
                        <i class="fa-solid fa-landmark"></i>
                        <p>Tidak ada pengajuan kredit</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-wrap">
        <span>Menampilkan {{ $credits->firstItem() }}–{{ $credits->lastItem() }} dari {{ $credits->total() }}</span>
        <div class="pagination-links">{{ $credits->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
