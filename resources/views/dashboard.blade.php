@extends('layouts.app')

@section('title','Dashboard')

@section('content')
<style>
 .arena-header{background:linear-gradient(135deg,#12311f,#164e63 58%,#7c2d12);border-radius:1rem;color:white;padding:1.5rem;box-shadow:0 22px 55px rgba(15,23,42,.18);position:relative;overflow:hidden}
 .arena-header:after{content:"";position:absolute;right:-45px;top:-45px;width:180px;height:180px;border-radius:50%;border:26px solid rgba(255,255,255,.12)}
 .arena-header>*{position:relative;z-index:1}
 .schedule-table{border-color:#dbe4ef}
 .schedule-table th,.schedule-table td{font-size:.78rem;vertical-align:middle}
 .schedule-table .field-col{min-width:210px;position:sticky;left:0;background:white;z-index:2;box-shadow:8px 0 18px rgba(15,23,42,.06)}
 .schedule-table thead .field-col{z-index:3}
 .schedule-slot{min-width:78px;height:50px;text-align:center;font-weight:750;border:2px solid white}
 .schedule-slot.available{background:#e9fbe9;color:#15803d}
 .schedule-slot.booked{background:#ffebe5;color:#9a3412}
 .schedule-slot:hover{outline:2px solid #2563eb;outline-offset:-2px}
 .schedule-code{display:block;font-size:.68rem;line-height:1.1;color:#7c2d12}
 .field-type{background:#e0f2fe;color:#075985}
 .table-card .card-body{padding:1.25rem}
</style>

<div class="arena-header d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
 <div>
  <div class="text-white-50 fw-semibold mb-1">Arena Overview</div>
  <h2 class="page-title mb-1">Dashboard SM Sport Center</h2>
  <div class="text-white-50">Pantau reservasi, lapangan, dan slot kosong dalam satu layar.</div>
 </div>
 <form class="d-flex align-items-end gap-2" method="get" action="{{ route('dashboard') }}">
  <div>
   <label class="form-label small mb-1 text-white-50" for="tanggal">Tanggal Jadwal</label>
   <input class="form-control" type="date" id="tanggal" name="tanggal" value="{{ $tanggalJadwal }}">
  </div>
  <button class="btn btn-light">Cek</button>
  <a class="btn btn-outline-light" href="{{ route('dashboard') }}">Hari Ini</a>
 </form>
</div>

<div class="row g-3 mb-4">
 <div class="col-md-3"><div class="card metric-card p-3"><small class="metric-label">Lapangan</small><p class="metric-value text-success">{{ $jumlahLapangan }}</p></div></div>
 <div class="col-md-3"><div class="card metric-card p-3"><small class="metric-label">Pelanggan</small><p class="metric-value text-primary">{{ $jumlahPelanggan }}</p></div></div>
 <div class="col-md-3"><div class="card metric-card p-3"><small class="metric-label">Reservasi Hari Ini</small><p class="metric-value text-warning">{{ $reservasiHariIni }}</p></div></div>
 <div class="col-md-3"><div class="card metric-card p-3"><small class="metric-label">Pendapatan Bulan Ini</small><h5 class="fw-bold mt-2 mb-0">Rp{{ number_format($pendapatanBulanIni,0,',','.') }}</h5></div></div>
</div>

<div class="card table-card mb-4">
 <div class="card-body">
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
   <div>
    <h5 class="mb-0 fw-bold">Jadwal Lapangan 24 Jam</h5>
    <div class="text-muted small">Tanggal {{ \Carbon\Carbon::parse($tanggalJadwal)->format('d/m/Y') }}</div>
   </div>
   <div class="d-flex gap-2 small">
    <span><span class="badge text-bg-success">Kosong</span></span>
    <span><span class="badge text-bg-warning">Terisi</span></span>
   </div>
  </div>
  <div class="table-responsive">
   <table class="table table-bordered schedule-table mb-0">
    <thead>
     <tr>
      <th class="field-col">Lapangan</th>
      @foreach($jamJadwal as $jam)
       <th class="text-center">{{ sprintf('%02d:00', $jam) }}</th>
      @endforeach
     </tr>
    </thead>
    <tbody>
     @forelse($jadwalLapangan as $baris)
      <tr>
       <th class="field-col">
        {{ $baris['lapangan']->nama_lapangan }}
        <span class="badge field-type ms-1">{{ ucfirst($baris['lapangan']->jenis) }}</span>
       </th>
       @foreach($baris['slots'] as $jam => $reservasi)
        @if($reservasi)
         <td class="schedule-slot booked" title="{{ $reservasi->kode_reservasi }}: {{ substr($reservasi->jam_mulai,0,5) }}-{{ substr($reservasi->jam_selesai,0,5) }}">
          Terisi
          @if(auth()->user()->role === 'admin')
           <span class="schedule-code">{{ $reservasi->kode_reservasi }}</span>
          @endif
         </td>
        @else
         <td class="schedule-slot available">Kosong</td>
        @endif
       @endforeach
      </tr>
     @empty
      <tr><td colspan="{{ count($jamJadwal) + 1 }}" class="text-center">Belum ada data lapangan.</td></tr>
     @endforelse
    </tbody>
   </table>
  </div>
 </div>
</div>

<div class="card">
 <div class="card-body">
  <h5 class="fw-bold">Reservasi Terbaru</h5>
  <div class="table-responsive">
   <table class="table">
    <thead><tr><th>Kode</th><th>Pelanggan</th><th>Lapangan</th><th>Tanggal</th><th>Jam</th><th>Status</th></tr></thead>
    <tbody>
     @forelse($reservasiTerbaru as $r)
      <tr>
       <td>{{ $r->kode_reservasi }}</td>
       <td>{{ $r->pelanggan->nama }}</td>
       <td>{{ $r->lapangan->nama_lapangan }}</td>
       <td>{{ $r->tanggal->format('d/m/Y') }}</td>
       <td>{{ substr($r->jam_mulai,0,5) }}-{{ substr($r->jam_selesai,0,5) }}</td>
       <td><span class="badge bg-info">{{ $r->status_reservasi }}</span></td>
      </tr>
     @empty
      <tr><td colspan="6" class="text-center">Belum ada data.</td></tr>
     @endforelse
    </tbody>
   </table>
  </div>
 </div>
</div>
@endsection
