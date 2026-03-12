@extends('layouts.app')
@section('title', 'Instruksi Pembayaran')

@section('content')
<div style="max-width:560px;margin:0 auto">
    <div style="margin-bottom:32px">
        <div class="section-label">Pembayaran</div>
        <h1 class="page-title" style="font-size:36px">INSTRUKSI <span>BAYAR</span></h1>
    </div>

    <div style="background:var(--surface);border:1px solid var(--border);padding:32px;margin-bottom:2px">

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;padding-bottom:20px;border-bottom:1px solid var(--border)">
            <div>
                <div style="font-family:'Barlow Condensed';font-size:11px;letter-spacing:2px;text-transform:uppercase;color:var(--text-dim);margin-bottom:4px">Status</div>
                @php
                    $statusClass = ['success'=>'badge-green','failed'=>'badge-red','refunded'=>'badge-blue'];
                @endphp
                <span class="badge {{ $statusClass[$payment->status] ?? 'badge-yellow' }}" style="font-size:12px;padding:5px 12px">
                    @if($payment->status === 'pending')
                        <i class="fa-solid fa-clock" style="margin-right:4px"></i>Menunggu Pembayaran
                    @elseif($payment->status === 'success')
                        <i class="fa-solid fa-circle-check" style="margin-right:4px"></i>Lunas
                    @else
                        {{ ucfirst($payment->status) }}
                    @endif
                </span>
            </div>
            <div style="text-align:right">
                <div style="font-family:'Barlow Condensed';font-size:11px;letter-spacing:2px;text-transform:uppercase;color:var(--text-dim);margin-bottom:4px">Metode</div>
                <div style="font-family:'Barlow Condensed';font-size:14px;letter-spacing:1px;text-transform:uppercase">
                    {{ str_replace('_', ' ', $payment->method) }}
                </div>
            </div>
        </div>

        <div style="text-align:center;margin-bottom:28px">
            <div style="font-family:'Barlow Condensed';font-size:12px;letter-spacing:2px;text-transform:uppercase;color:var(--text-dim);margin-bottom:6px">Total Pembayaran</div>
            <div style="font-family:'Bebas Neue';font-size:52px;letter-spacing:3px;color:var(--red)">
                Rp {{ number_format($payment->amount, 0, ',', '.') }}
            </div>
        </div>

        @if($payment->va_number)
        <div style="background:var(--surface2);border:1px solid var(--border-red);padding:20px;text-align:center;margin-bottom:20px">
            <div style="font-family:'Barlow Condensed';font-size:11px;letter-spacing:2px;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px">
                <i class="fa-solid fa-building-columns" style="margin-right:4px;color:var(--red)"></i>Nomor Virtual Account
            </div>
            <div style="font-family:'Bebas Neue';font-size:36px;letter-spacing:6px;color:var(--text)">
                {{ $payment->va_number }}
            </div>
            <div style="font-family:'Barlow Condensed';font-size:11px;letter-spacing:1px;color:var(--text-dim);margin-top:8px">
                Transfer tepat sesuai nominal di atas
            </div>
        </div>
        @endif

        @if($payment->expires_at && $payment->status === 'pending')
        <div style="display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:24px;font-family:'Barlow Condensed';font-size:13px;letter-spacing:1px;color:var(--text-dim)">
            <i class="fa-regular fa-clock" style="color:var(--red)"></i>
            Bayar sebelum <strong style="color:var(--text)">{{ $payment->expires_at->format('d M Y, H:i') }}</strong>
        </div>
        @endif

        @if($payment->status === 'pending')
        <form method="POST" action="/payments/{{ $payment->id }}/confirm" style="margin-bottom:12px">
            @csrf
            <button type="submit" class="btn btn-primary btn-block" style="font-size:15px;letter-spacing:3px">
                <i class="fa-solid fa-circle-check" style="margin-right:8px"></i>KONFIRMASI SUDAH BAYAR
            </button>
        </form>
        <div style="font-family:'Barlow Condensed';font-size:11px;letter-spacing:1px;color:var(--text-dim);text-align:center">
            Tombol ini hanya untuk keperluan demo
        </div>
        @endif

        @if($payment->status === 'success')
        <a href="/orders/{{ $payment->order_id }}" class="btn btn-outline btn-block" style="font-size:13px;letter-spacing:2px">
            <i class="fa-solid fa-arrow-right" style="margin-right:8px"></i>LIHAT PESANAN
        </a>
        @endif
    </div>
</div>
@endsection
