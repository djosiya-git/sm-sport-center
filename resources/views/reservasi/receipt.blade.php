@extends('layouts.app')

@section('title','Struk Reservasi')

@section('content')
@php
 $dp=(float)($item->dp_amount ?? 50000);
 $total=(float)$item->total_harga;
 $sisa=max($total-$dp,0);
 if($item->status_pembayaran==='lunas') $sisa=0;
@endphp
<style>
 .receipt-wrap{max-width:760px;margin:0 auto}
 .receipt{background:white;border:1px solid #dbe4ef;border-radius:1rem;box-shadow:0 18px 45px rgba(15,23,42,.08);overflow:hidden}
 .receipt-head{background:linear-gradient(135deg,#12311f,#164e63 58%,#7c2d12);color:white;padding:1.35rem 1.5rem}
 .receipt-mark{width:48px;height:48px;border-radius:12px;background:linear-gradient(135deg,#22c55e,#2563eb);display:grid;place-items:center;font-weight:900}
 .receipt-body{padding:1.5rem}
 .receipt-row{display:flex;justify-content:space-between;gap:1rem;border-bottom:1px dashed #cbd5e1;padding:.65rem 0}
 .receipt-row span:first-child{color:#64748b}
 .amount-row{font-size:1.05rem;font-weight:800}
 .receipt-total{background:#f8fafc;border-radius:.9rem;padding:1rem}
 @media print{
  body{background:white}
  .sidebar,.navbar,.no-print{display:none!important}
  main{padding:0!important;background:white!important}
  .receipt-wrap{max-width:none}
  .receipt{box-shadow:none;border:0;border-radius:0}
 }
</style>

<div class="receipt-wrap">
 <div class="d-flex justify-content-between align-items-center mb-3 no-print">
  <a href="{{ route('reservasi.index') }}" class="btn btn-outline-secondary">Kembali</a>
  <button class="btn btn-primary" onclick="window.print()">Print Struk</button>
 </div>

 <div class="receipt">
  <div class="receipt-head d-flex justify-content-between align-items-start gap-3">
   <div class="d-flex align-items-center gap-3">
    <div class="receipt-mark">SM</div>
    <div>
     <h3 class="mb-0 fw-bold">SM Sport Center</h3>
     <div class="text-white-50">Struk Reservasi Lapangan</div>
    </div>
   </div>
   <div class="text-end">
    <div class="text-white-50 small">Kode Reservasi</div>
    <div class="fw-bold">{{ $item->kode_reservasi }}</div>
   </div>
  </div>

  <div class="receipt-body">
   <div class="row g-4">
    <div class="col-md-6">
     <h6 class="fw-bold mb-2">Data Pelanggan</h6>
     <div class="receipt-row"><span>Nama</span><strong>{{ $item->pelanggan->nama }}</strong></div>
     <div class="receipt-row"><span>Kode</span><strong>{{ $item->pelanggan->kode_pelanggan }}</strong></div>
     <div class="receipt-row"><span>No. Telepon</span><strong>{{ $item->pelanggan->no_telepon }}</strong></div>
    </div>
    <div class="col-md-6">
     <h6 class="fw-bold mb-2">Data Reservasi</h6>
     <div class="receipt-row"><span>Lapangan</span><strong>{{ $item->lapangan->nama_lapangan }}</strong></div>
     <div class="receipt-row"><span>Tanggal</span><strong>{{ $item->tanggal->format('d/m/Y') }}</strong></div>
     <div class="receipt-row"><span>Jam</span><strong>{{ substr($item->jam_mulai,0,5) }}-{{ substr($item->jam_selesai,0,5) }}</strong></div>
     <div class="receipt-row"><span>Durasi</span><strong>{{ $item->durasi }} jam</strong></div>
    </div>
   </div>

   <div class="receipt-total mt-4">
    <div class="receipt-row"><span>Harga per Jam</span><strong>Rp{{ number_format($item->harga_per_jam,0,',','.') }}</strong></div>
    <div class="receipt-row amount-row"><span>Total</span><strong>Rp{{ number_format($total,0,',','.') }}</strong></div>
    <div class="receipt-row amount-row"><span>DP</span><strong>Rp{{ number_format($dp,0,',','.') }}</strong></div>
    <div class="receipt-row amount-row"><span>Sisa Bayar</span><strong>Rp{{ number_format($sisa,0,',','.') }}</strong></div>
   </div>

   <div class="row g-3 mt-3">
    <div class="col-md-6">
     <div class="p-3 rounded-3 bg-light">
      <div class="text-muted small">Status Reservasi</div>
      <strong>{{ ucfirst($item->status_reservasi) }}</strong>
     </div>
    </div>
    <div class="col-md-6">
     <div class="p-3 rounded-3 bg-light">
      <div class="text-muted small">Status Pembayaran</div>
      <strong>{{ $item->status_pembayaran==='lunas' ? 'Lunas' : 'DP / Sebagian' }}</strong>
     </div>
    </div>
   </div>

   @if($item->catatan)
    <div class="mt-4">
     <h6 class="fw-bold">Catatan</h6>
     <p class="mb-0 text-muted">{{ $item->catatan }}</p>
    </div>
   @endif

   <div class="text-center text-muted small mt-4">
    Dicetak pada {{ now()->format('d/m/Y H:i') }}. Simpan struk ini sebagai bukti reservasi.
   </div>
  </div>
 </div>
</div>
@endsection
