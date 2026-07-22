@extends('layouts.app')

@section('title','Dashboard')

@section('content')
<style>
 .schedule-table th,.schedule-table td{font-size:.78rem;vertical-align:middle}
 .schedule-table .field-col{min-width:190px;position:sticky;left:0;background:white;z-index:2}
 .schedule-table thead .field-col{z-index:3}
 .schedule-slot{min-width:74px;height:48px;text-align:center}
 .schedule-slot.available{background:#f0fdf4;color:#166534}
 .schedule-slot.booked{background:#fee2e2;color:#991b1b}
 .schedule-code{display:block;font-size:.68rem;line-height:1.1}
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
 <h2 class="mb-0">Dashboard</h2>
 <form class="d-flex align-items-end gap-2" method="get" action="{{ route('dashboard') }}">
  <div>
   <label class="form-label small mb-1" for="tanggal">Tanggal Jadwal</label>
   <input class="form-control" type="date" id="tanggal" name="tanggal" value="{{ $tanggalJadwal }}">
  </div>
  <button class="btn btn-primary">Cek</button>
  <a class="btn btn-outline-secondary" href="{{ route('dashboard') }}">Hari Ini</a>
 </form>
</div>

<div class="row g-3 mb-4">
 <div class="col-md-3"><div class="card shadow-sm p-3"><small>Lapangan</small><h3>{{ $jumlahLapangan }}</h3></div></div>
 <div class="col-md-3"><div class="card shadow-sm p-3"><small>Pelanggan</small><h3>{{ $jumlahPelanggan }}</h3></div></div>
 <div class="col-md-3"><div class="card shadow-sm p-3"><small>Reservasi Hari Ini</small><h3>{{ $reservasiHariIni }}</h3></div></div>
 <div class="col-md-3"><div class="card shadow-sm p-3"><small>Pendapatan Bulan Ini</small><h5>Rp{{ number_format($pendapatanBulanIni,0,',','.') }}</h5></div></div>
</div>

<div class="card shadow-sm mb-4">
 <div class="card-body">
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
   <h5 class="mb-0">Jadwal Lapangan 24 Jam</h5>
   <div class="d-flex gap-2 small">
    <span><span class="badge text-bg-success">Kosong</span></span>
    <span><span class="badge text-bg-danger">Terisi</span></span>
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
        <span class="badge bg-secondary ms-1">{{ ucfirst($baris['lapangan']->jenis) }}</span>
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

<div class="card shadow-sm">
 <div class="card-body">
  <h5>Reservasi Terbaru</h5>
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
