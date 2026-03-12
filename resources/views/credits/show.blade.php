@extends('layouts.app')
@section('title', 'Detail Kredit')

@push('styles')
<style>
    .credit-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2px; margin-bottom: 2px; }
    .credit-stat-box {
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 20px 22px;
    }
    .credit-stat-label {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--text-dim);
        margin-bottom: 6px;
    }
    .credit-stat-val {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 26px;
        letter-spacing: 1px;
        color: var(--text);
        line-height: 1;
    }
    .credit-stat-val.red { color: var(--red); }

    .progress-bar-wrap {
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 20px 24px;
        margin-bottom: 2px;
    }
    .progress-bar-track {
        background: var(--surface2);
        height: 6px;
        position: relative;
        overflow: hidden;
        margin-top: 12px;
    }
    .progress-bar-fill {
        height: 100%;
        background: var(--red);
        transition: width 0.5s ease;
    }

    .schedule-table-wrap {
        background: var(--surface);
        border: 1px solid var(--border);
        overflow: hidden;
    }
    .schedule-table-header {
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .schedule-table-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 18px;
        letter-spacing: 2px;
    }
</style>
@endpush

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
    <div>
        <div class="section-label">Detail Pembiayaan</div>
        <h1 class="page-title" style="font-size:36px">JADWAL <span>CICILAN</span></h1>
    </div>
    <a href="/credits" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left" style="margin-right:6px"></i>Kembali
    </a>
</div>

<div class="credit-stats">
    <div class="credit-stat-box">
        <div class="credit-stat-label">Provider</div>
        <div class="credit-stat-val" style="font-size:18px">{{ $credit->provider }}</div>
    </div>
    <div class="credit-stat-box">
        <div class="credit-stat-label">Tenor</div>
        <div class="credit-stat-val">{{ $credit->tenure_months }} <span style="font-size:14px;color:var(--text-muted)">BLN</span></div>
    </div>
    <div class="credit-stat-box">
        <div class="credit-stat-label">Cicilan/Bulan</div>
        <div class="credit-stat-val red" style="font-size:18px">Rp {{ number_format($credit->monthly_installment, 0, ',', '.') }}</div>
    </div>
    <div class="credit-stat-box">
        <div class="credit-stat-label">Status</div>
        @php $cMap = ['pending'=>'badge-yellow','approved'=>'badge-blue','active'=>'badge-green','rejected'=>'badge-red','completed'=>'badge-green']; @endphp
        <span class="badge {{ $cMap[$credit->status] ?? 'badge-gray' }}" style="margin-top:4px;display:inline-block;font-size:12px;padding:5px 12px">
            {{ ucfirst($credit->status) }}
        </span>
    </div>
</div>
<div class="credit-stats" style="margin-bottom:24px">
    <div class="credit-stat-box">
        <div class="credit-stat-label">Uang Muka</div>
        <div class="credit-stat-val" style="font-size:18px">Rp {{ number_format($credit->dp_amount, 0, ',', '.') }}</div>
    </div>
    <div class="credit-stat-box">
        <div class="credit-stat-label">Pinjaman</div>
        <div class="credit-stat-val" style="font-size:18px">Rp {{ number_format($credit->loan_amount, 0, ',', '.') }}</div>
    </div>
    <div class="credit-stat-box">
        <div class="credit-stat-label">Total Bayar</div>
        <div class="credit-stat-val" style="font-size:18px">Rp {{ number_format($credit->total_payment, 0, ',', '.') }}</div>
    </div>
    <div class="credit-stat-box">
        <div class="credit-stat-label">Bunga</div>
        <div class="credit-stat-val">{{ $credit->interest_rate_pct }}<span style="font-size:14px;color:var(--text-muted)">%/THN</span></div>
    </div>
</div>

@php
    $paid  = $credit->installmentSchedules->where('status', 'paid')->count();
    $total = $credit->installmentSchedules->count();
    $pct   = $total > 0 ? round($paid / $total * 100) : 0;
@endphp
<div class="progress-bar-wrap">
    <div style="display:flex;justify-content:space-between;align-items:center">
        <div style="font-family:'Barlow Condensed';font-size:11px;letter-spacing:2px;text-transform:uppercase;color:var(--text-dim)">
            Progress Pelunasan
        </div>
        <div style="font-family:'Bebas Neue';font-size:24px;letter-spacing:1px">
            <span style="color:var(--red)">{{ $paid }}</span>
            <span style="color:var(--text-dim)"> / {{ $total }}</span>
            <span style="font-size:14px;color:var(--text-dim);margin-left:8px">{{ $pct }}%</span>
        </div>
    </div>
    <div class="progress-bar-track">
        <div class="progress-bar-fill" style="width: {{ $pct }}%"></div>
    </div>
</div>

@if($credit->installmentSchedules->isNotEmpty())
<div class="schedule-table-wrap">
    <div class="schedule-table-header">
        <div class="schedule-table-title">
            <i class="fa-regular fa-calendar" style="color:var(--red);margin-right:8px;font-size:14px"></i>
            JADWAL CICILAN
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Cicilan Ke</th>
                <th>Jatuh Tempo</th>
                <th>Jumlah</th>
                <th>Denda</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($credit->installmentSchedules->sortBy('period_number') as $schedule)
            <tr>
                <td>
                    <span style="font-family:'Bebas Neue';font-size:18px;letter-spacing:1px">{{ $schedule->period_number }}</span>
                </td>
                <td>
                    <span style="font-family:'Barlow Condensed';letter-spacing:1px;font-size:13px">
                        {{ \Carbon\Carbon::parse($schedule->due_date)->format('d M Y') }}
                    </span>
                </td>
                <td>
                    <span style="font-family:'Barlow Condensed';letter-spacing:1px;color:var(--text)">
                        Rp {{ number_format($schedule->amount_due, 0, ',', '.') }}
                    </span>
                </td>
                <td>
                    @if($schedule->late_penalty > 0)
                        <span style="color:var(--red);font-family:'Barlow Condensed';letter-spacing:1px">
                            +Rp {{ number_format($schedule->late_penalty, 0, ',', '.') }}
                        </span>
                    @else
                        <span style="color:var(--text-dim)">—</span>
                    @endif
                </td>
                <td>
                    @php
                        $schMap = ['paid'=>'badge-green','late'=>'badge-red','waived'=>'badge-gray','upcoming'=>'badge-yellow'];
                        $schLabel = ['paid'=>'Lunas','late'=>'Terlambat','waived'=>'Dibebaskan','upcoming'=>'Belum Bayar'];
                    @endphp
                    <span class="badge {{ $schMap[$schedule->status] ?? 'badge-gray' }}">
                        {{ $schLabel[$schedule->status] ?? $schedule->status }}
                    </span>
                </td>
                <td>
                    @if(in_array($schedule->status, ['upcoming','late']) && $credit->status === 'active')
                    <form method="POST" action="/credits/{{ $credit->id }}/schedules/{{ $schedule->id }}/pay" style="display:inline">
                        @csrf
                        <input type="hidden" name="method" value="va_bank">
                        <input type="hidden" name="gateway" value="Midtrans">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-money-bill-wave" style="margin-right:4px"></i>Bayar
                        </button>
                    </form>
                    @elseif($schedule->status === 'paid')
                        <span style="font-family:'Barlow Condensed';font-size:11px;letter-spacing:1px;color:#00C864">
                            <i class="fa-solid fa-circle-check" style="margin-right:4px"></i>Lunas
                        </span>
                    @else
                        <span style="color:var(--text-dim)">—</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
