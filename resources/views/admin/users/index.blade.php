@extends('admin.layout')
@section('title', 'Users & KYC')
@section('topbar-title', 'Users & KYC')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <div class="label">Manajemen</div>
        <h1>USERS & KYC</h1>
    </div>
</div>

{{-- FILTER --}}
<form method="GET" action="/admin/users">
    <div class="filter-bar">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..." class="form-control" style="min-width:220px">
        <select name="kyc_status" class="form-control">
            <option value="">Semua KYC</option>
            <option value="unverified" {{ request('kyc_status')==='unverified' ? 'selected' : '' }}>Unverified</option>
            <option value="verified"   {{ request('kyc_status')==='verified'   ? 'selected' : '' }}>Verified</option>
            <option value="rejected"   {{ request('kyc_status')==='rejected'   ? 'selected' : '' }}>Rejected</option>
        </select>
        <select name="role" class="form-control">
            <option value="">Semua Role</option>
            <option value="customer" {{ request('role')==='customer' ? 'selected' : '' }}>Customer</option>
            <option value="admin"    {{ request('role')==='admin'    ? 'selected' : '' }}>Admin</option>
        </select>
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-filter"></i>Filter
        </button>
        @if(request()->anyFilled(['search','kyc_status','role']))
            <a href="/admin/users" class="btn btn-ghost btn-sm">Reset</a>
        @endif
    </div>
</form>

<div class="table-card">
    <div class="table-card-header">
        <div class="table-card-title">DAFTAR USER</div>
        <span style="font-family:'Barlow Condensed';font-size:12px;letter-spacing:1px;color:var(--text-dim)">
            {{ $users->total() }} total
        </span>
    </div>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>NIK</th>
                <th>Role</th>
                <th>KYC Status</th>
                <th>Orders</th>
                <th>Bergabung</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            @php
                $kycMap = [
                    'verified'   => 'badge-green',
                    'rejected'   => 'badge-red',
                    'unverified' => 'badge-yellow',
                ];
            @endphp
            <tr>
                <td>
                    <div style="font-family:'Barlow Condensed';font-size:14px;letter-spacing:0.5px">{{ $user->full_name }}</div>
                    <div style="font-size:11px;color:var(--text-dim);margin-top:2px">{{ $user->email }}</div>
                </td>
                <td style="font-family:'Barlow Condensed';font-size:12px;letter-spacing:1px;color:var(--text-dim)">
                    {{ $user->nik ?? '—' }}
                </td>
                <td>
                    <span class="badge {{ $user->role === 'admin' ? 'badge-red' : 'badge-gray' }}">
                        {{ $user->role }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $kycMap[$user->kyc_status] ?? 'badge-gray' }}">
                        @if($user->kyc_status === 'verified') <i class="fa-solid fa-circle-check"></i> @endif
                        {{ $user->kyc_status }}
                    </span>
                </td>
                <td style="font-family:'Bebas Neue';font-size:18px;color:var(--text-dim)">
                    {{ $user->orders_count }}
                </td>
                <td style="font-size:12px;color:var(--text-dim);font-family:'Barlow Condensed';letter-spacing:1px">
                    {{ $user->created_at->format('d M Y') }}
                </td>
                <td>
                    @if($user->role !== 'admin')
                    <div style="display:flex;gap:6px;align-items:center">
                        {{-- KYC VERIFY --}}
                        @if($user->kyc_status !== 'verified')
                        <form method="POST" action="/admin/users/{{ $user->id }}/kyc" style="display:inline">
                            @csrf @method('PATCH')
                            <input type="hidden" name="kyc_status" value="verified">
                            <button type="submit" class="btn btn-success btn-sm" title="Verifikasi KYC">
                                <i class="fa-solid fa-check"></i>Verify
                            </button>
                        </form>
                        @endif
                        @if($user->kyc_status !== 'rejected')
                        <form method="POST" action="/admin/users/{{ $user->id }}/kyc" style="display:inline">
                            @csrf @method('PATCH')
                            <input type="hidden" name="kyc_status" value="rejected">
                            <button type="submit" class="btn btn-danger btn-sm" title="Tolak KYC">
                                <i class="fa-solid fa-xmark"></i>Tolak
                            </button>
                        </form>
                        @endif
                    </div>
                    @else
                    <span style="font-size:11px;color:var(--text-muted)">—</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <i class="fa-solid fa-users"></i>
                        <p>Tidak ada user ditemukan</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-wrap">
        <span>Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }}</span>
        <div class="pagination-links">{{ $users->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
