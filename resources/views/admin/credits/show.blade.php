@extends('admin.layout')
@section('title', 'Detail Kredit')
@section('topbar-title', 'Detail Kredit')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <div class="label">Credits</div>
        <h1>DETAIL KREDIT</h1>
    </div>
    <a href="/admin/credits" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left"></i>Kembali
    </a>
</div>

@php
    $cMap = [
        'pending'   => 'badge-yellow',
        'approved'  => 'badge-blue',
        'active'    => 'badge-green',
        'rejected'  => 'badge-red',
        'completed' => 'badge-gray',
    ];
@endphp

<div class="detail-grid">
    <div>
        {{-- CREDIT INFO --}}
        <div class="info-block">
            <div class="info-block-title"><i class="fa-solid fa-landmark"></i>INFORMASI KREDIT</div>
            <div class="info-row">
                <span class="info-row-label">Status</span>
                <span class="badge {{ $cMap[$credit->status] ?? 'badge-gray' }}" style="font-size:12px">{{ ucfirst($credit->status) }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Provider Leasing</span>
                <span class="info-row-val">{{ $credit->provider }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Tenor</span>
                <span class="info-row-val">{{ $credit->tenure_months }} bulan</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Bunga / Tahun</span>
                <span class="info-row-val">{{ $credit->interest_rate_pct }}%</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Harga Motor</span>
                <span class="info-row-val">Rp {{ number_format($credit->order->grand_total ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Uang Muka (DP)</span>
                <span class="info-row-val">Rp {{ number_format($credit->dp_amount, 0, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Pokok Pinjaman</span>
                <span class="info-row-val">Rp {{ number_format($credit->loan_amount, 0, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Cicilan / Bulan</span>
                <span class="info-row-val" style="color:var(--red);font-family:'Bebas Neue';font-size:22px">
                    Rp {{ number_format($credit->monthly_installment, 0, ',', '.') }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Total Pembayaran</span>
                <span class="info-row-val">Rp {{ number_format($credit->total_payment, 0, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Diajukan</span>
                <span class="info-row-val" style="font-size:12px">{{ $credit->submitted_at->format('d M Y H:i') }}</span>
            </div>
            @if($credit->approved_at)
            <div class="info-row">
                <span class="info-row-label">Disetujui</span>
                <span class="info-row-val" style="font-size:12px">{{ $credit->approved_at->format('d M Y H:i') }}</span>
            </div>
            @endif
        </div>

        {{-- DOKUMEN --}}
        <div class="info-block">
            <div class="info-block-title"><i class="fa-solid fa-file-lines"></i>DOKUMEN</div>
            <div class="info-row">
                <span class="info-row-label">Foto KTP</span>
                @if($credit->doc_ktp_url)
                    <a href="{{ $credit->doc_ktp_url }}" target="_blank" class="btn btn-ghost btn-sm">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>Lihat
                    </a>
                @else
                    <span style="color:var(--text-muted);font-size:12px">—</span>
                @endif
            </div>
            <div class="info-row">
                <span class="info-row-label">Slip Gaji</span>
                @if($credit->doc_slip_gaji_url)
                    <a href="{{ $credit->doc_slip_gaji_url }}" target="_blank" class="btn btn-ghost btn-sm">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>Lihat
                    </a>
                @else
                    <span style="color:var(--text-muted);font-size:12px">—</span>
                @endif
            </div>
        </div>

        {{-- UPDATE STATUS --}}
        @if(in_array($credit->status, ['pending','approved']))
        <div class="info-block">
            <div class="info-block-title"><i class="fa-solid fa-pen-to-square"></i>UPDATE STATUS</div>
            <form method="POST" action="/admin/credits/{{ $credit->id }}/status" style="display:flex;gap:12px;align-items:flex-end">
                @csrf @method('PUT')
                <div class="form-group" style="flex:1;margin-bottom:0">
                    <label class="form-label">Status Baru</label>
                    <select name="status" class="form-control">
                        <option value="approved"  {{ $credit->status==='approved'  ? 'selected':'' }}>Approved</option>
                        <option value="rejected"  {{ $credit->status==='rejected'  ? 'selected':'' }}>Rejected</option>
                        <option value="active"    {{ $credit->status==='active'    ? 'selected':'' }}>Active</option>
                        <option value="completed" {{ $credit->status==='completed' ? 'selected':'' }}>Completed</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>Update
                </button>
            </form>
            @if($credit->status === 'pending')
            <div style="margin-top:12px;font-size:11px;color:var(--text-dim);font-family:'Barlow Condensed';letter-spacing:1px">
                <i class="fa-solid fa-circle-info" style="color:var(--blue)"></i>
                Mengubah ke "Approved" akan otomatis generate jadwal cicilan
            </div>
            @endif
        </div>
        @endif
    </div>

    <div>
        {{-- CUSTOMER --}}
        <div class="info-block">
            <div class="info-block-title"><i class="fa-solid fa-user"></i>DATA CUSTOMER</div>
            <div class="info-row">
                <span class="info-row-label">Nama</span>
                <span class="info-row-val">{{ $credit->user->full_name ?? '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Email</span>
                <span class="info-row-val" style="font-size:12px">{{ $credit->user->email ?? '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">NIK</span>
                <span class="info-row-val" style="font-family:'Barlow Condensed';letter-spacing:1px">{{ $credit->user->nik ?? '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">KYC</span>
                @php $kycMap = ['verified'=>'badge-green','rejected'=>'badge-red','unverified'=>'badge-yellow']; @endphp
                <span class="badge {{ $kycMap[$credit->user->kyc_status] ?? 'badge-gray' }}">{{ $credit->user->kyc_status ?? '—' }}</span>
            </div>
        </div>

        {{-- ORDER --}}
        @if($credit->order)
        <div class="info-block">
            <div class="info-block-title"><i class="fa-solid fa-receipt"></i>ORDER TERKAIT</div>
            <div class="info-row">
                <span class="info-row-label">Nomor Order</span>
                <span class="info-row-val" style="font-family:'Bebas Neue';letter-spacing:1px">{{ $credit->order->order_number }}</span>
            </div>
            @foreach($credit->order->items as $item)
            <div style="padding:8px 0;border-bottom:1px solid var(--border);font-size:12px">
                <div style="font-family:'Barlow Condensed';font-size:14px">{{ $item->product_name }}</div>
                <div style="color:var(--text-dim)">{{ $item->quantity }} unit · Rp {{ number_format($item->unit_price, 0, ',', '.') }}</div>
            </div>
            @endforeach
            <div style="margin-top:12px">
                <a href="/admin/orders/{{ $credit->order->id }}" class="btn btn-ghost btn-sm" style="width:100%;justify-content:center">
                    <i class="fa-solid fa-eye"></i>Lihat Order
                </a>
            </div>
        </div>
        @endif

        {{-- INSTALLMENT SCHEDULES --}}
        @if($credit->installmentSchedules->count() > 0)
        <div class="info-block">
            <div class="info-block-title"><i class="fa-solid fa-calendar-days"></i>JADWAL CICILAN</div>
            <div style="max-height:320px;overflow-y:auto">
                @foreach($credit->installmentSchedules as $s)
                @php
                    $sMap = ['paid'=>'badge-green','upcoming'=>'badge-gray','late'=>'badge-red','waived'=>'badge-orange'];
                @endphp
                <div style="display:flex;justify-content:space-between;align-items:center;padding:7px 0;border-bottom:1px solid var(--border);font-size:12px">
                    <div style="font-family:'Barlow Condensed';letter-spacing:1px;color:var(--text-dim)">
                        Cicilan #{{ $s->period_number }} · {{ \Carbon\Carbon::parse($s->due_date)->format('d M Y') }}
                    </div>
                    <div style="display:flex;align-items:center;gap:8px">
                        <span style="font-family:'Bebas Neue';font-size:14px">Rp {{ number_format($s->amount_due, 0, ',', '.') }}</span>
                        <span class="badge {{ $sMap[$s->status] ?? 'badge-gray' }}" style="font-size:10px">{{ $s->status }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
