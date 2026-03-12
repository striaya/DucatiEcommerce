@extends('layouts.app')
@section('title', 'Kredit Saya')

@section('content')
<div style="margin-bottom:32px">
    <div class="section-label">Pembiayaan</div>
    <h1 class="page-title">KREDIT <span>SAYA</span></h1>
</div>

@forelse($credits as $credit)
<a href="/credits/{{ $credit->id }}" style="text-decoration:none;color:inherit;display:block">
    <div style="background:var(--surface);border:1px solid var(--border);padding:24px 28px;margin-bottom:2px;display:grid;grid-template-columns:1fr auto;gap:24px;transition:border-color 0.2s"
         onmouseenter="this.style.borderColor='rgba(224,0,0,0.3)'"
         onmouseleave="this.style.borderColor='rgba(255,255,255,0.07)'">
        <div>
            <div style="font-family:'Barlow Condensed';font-size:11px;letter-spacing:3px;text-transform:uppercase;color:var(--text-dim);margin-bottom:6px">
                {{ $credit->provider }}
            </div>
            <div style="font-family:'Bebas Neue';font-size:24px;letter-spacing:1.5px;margin-bottom:8px">
                {{ $credit->order->order_number ?? '-' }}
            </div>
            <div style="display:flex;gap:20px">
                <div>
                    <div style="font-family:'Barlow Condensed';font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--text-dim)">Tenor</div>
                    <div style="font-family:'Bebas Neue';font-size:18px;letter-spacing:1px">{{ $credit->tenure_months }} Bulan</div>
                </div>
                <div>
                    <div style="font-family:'Barlow Condensed';font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--text-dim)">Cicilan/Bulan</div>
                    <div style="font-family:'Bebas Neue';font-size:18px;letter-spacing:1px;color:var(--red)">Rp {{ number_format($credit->monthly_installment, 0, ',', '.') }}</div>
                </div>
                <div>
                    <div style="font-family:'Barlow Condensed';font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--text-dim)">Progress</div>
                    <div style="font-family:'Bebas Neue';font-size:18px;letter-spacing:1px">
                        {{ $credit->installmentSchedules->where('status','paid')->count() }}/{{ $credit->installmentSchedules->count() }}
                    </div>
                </div>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;justify-content:space-between;align-items:flex-end">
            @php
                $cMap = ['pending'=>'badge-yellow','approved'=>'badge-blue','active'=>'badge-green','rejected'=>'badge-red','completed'=>'badge-green'];
            @endphp
            <span class="badge {{ $cMap[$credit->status] ?? 'badge-gray' }}" style="font-size:11px;padding:5px 12px">
                {{ ucfirst($credit->status) }}
            </span>
            <span style="font-family:'Barlow Condensed';font-size:11px;letter-spacing:1px;color:var(--text-dim)">
                {{ $credit->submitted_at->format('d M Y') }}
            </span>
        </div>
    </div>
</a>
@empty
    <div style="text-align:center;padding:80px 0;color:var(--text-dim)">
        <i class="fa-solid fa-landmark" style="font-size:48px;display:block;margin-bottom:16px"></i>
        <div style="font-family:'Bebas Neue';font-size:28px;letter-spacing:2px;color:var(--text-muted);margin-bottom:8px">BELUM ADA KREDIT</div>
        <a href="/products?credit_eligible=1" class="btn btn-outline" style="margin-top:16px">Lihat Motor Tersedia Kredit</a>
    </div>
@endforelse
{{ $credits->links() }}
@endsection
