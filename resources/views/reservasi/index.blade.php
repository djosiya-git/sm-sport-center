@extends('layouts.app')

@section('content')
<style>
 .booking-table td{padding:1rem .85rem}
 .booking-code{font-weight:850;color:#172033}
 .booking-sub{color:#64748b;font-size:.82rem}
 .price-stack strong{display:block}
 .status-select{min-width:150px}
 .action-grid{display:flex;flex-wrap:wrap;gap:.35rem;min-width:185px}
 .row-pending{background:linear-gradient(90deg,rgba(251,191,36,.16),transparent 45%)}
 .filter-card{background:white;border:1px solid rgba(148,163,184,.22);border-radius:.9rem;padding:1rem;box-shadow:0 12px 28px rgba(15,23,42,.06)}
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
 <div>
  <div class="text-muted small">Manajemen Booking</div>
  <h2 class="page-title mb-0">Data Reservasi</h2>
 </div>
 <a class="btn btn-primary" href="{{ route('reservasi.create') }}">Tambah Reservasi</a>
</div>

<form class="filter-card row g-2 align-items-end mb-3">
 <div class="col-lg-5">
  <label class="form-label small fw-semibold">Pencarian</label>
  <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari kode, pelanggan, lapangan...">
 </div>
 <div class="col-lg-3">
  <label class="form-label small fw-semibold">Tanggal</label>
  <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
 </div>
 <div class="col-lg-2">
  <label class="form-label small fw-semibold">Status</label>
  <select name="status_reservasi" class="form-select">
   <option value="">Semua</option>
   <option value="menunggu" @selected(request('status_reservasi')==='menunggu')>Menunggu</option>
   <option value="dikonfirmasi" @selected(request('status_reservasi')==='dikonfirmasi')>Dikonfirmasi</option>
   <option value="selesai" @selected(request('status_reservasi')==='selesai')>Selesai</option>
   <option value="dibatalkan" @selected(request('status_reservasi')==='dibatalkan')>Dibatalkan</option>
  </select>
 </div>
 <div class="col-lg-2 d-grid">
  <button class="btn btn-outline-secondary">Terapkan</button>
 </div>
</form>

<div class="card">
 <div class="table-responsive">
  <table class="table booking-table align-middle mb-0">
   <thead>
    <tr>
     <th>Booking</th>
     <th>Jadwal</th>
     <th>Tagihan</th>
     <th>Pembayaran</th>
     <th>Reservasi</th>
     <th>Aksi</th>
    </tr>
   </thead>
   <tbody>
    @forelse($data as $x)
     <tr class="{{ $x->status_reservasi==='menunggu' ? 'row-pending' : '' }}">
      <td>
       <div class="booking-code">{{ $x->kode_reservasi }}</div>
       <div>{{ $x->pelanggan->nama }}</div>
       <div class="booking-sub">{{ $x->pelanggan->no_telepon }}</div>
      </td>
      <td>
       <div class="fw-bold">{{ $x->lapangan->nama_lapangan }}</div>
       <div>{{ $x->tanggal->format('d/m/Y') }}</div>
       <div class="booking-sub">{{ substr($x->jam_mulai,0,5) }}-{{ substr($x->jam_selesai,0,5) }} · {{ $x->durasi }} jam</div>
      </td>
      <td class="price-stack">
       <strong>Rp{{ number_format($x->total_harga,0,',','.') }}</strong>
       <span class="booking-sub">DP Rp{{ number_format($x->dp_amount ?? 50000,0,',','.') }}</span>
       <span class="booking-sub">Sisa Rp{{ number_format($x->status_pembayaran==='lunas' ? 0 : max((float)$x->total_harga-(float)($x->dp_amount ?? 50000),0),0,',','.') }}</span>
      </td>
      <td>
       @if(auth()->user()->role==='admin')
        <form method="post" action="{{ route('reservasi.status-pembayaran',$x) }}">
         @csrf
         @method('PATCH')
         <select name="status_pembayaran" class="form-select form-select-sm status-select" onchange="this.form.submit()">
          <option value="sebagian" @selected($x->status_pembayaran==='sebagian' || $x->status_pembayaran==='belum_bayar')>DP / Sebagian</option>
          <option value="lunas" @selected($x->status_pembayaran==='lunas')>Lunas</option>
         </select>
        </form>
       @else
        <span class="badge {{ $x->status_pembayaran==='lunas' ? 'text-bg-success' : 'text-bg-warning' }}">{{ $x->status_pembayaran==='lunas' ? 'Lunas' : 'DP / Sebagian' }}</span>
       @endif
      </td>
      <td>
       @if(auth()->user()->role==='admin')
        <form method="post" action="{{ route('reservasi.status-reservasi',$x) }}">
         @csrf
         @method('PATCH')
         <select name="status_reservasi" class="form-select form-select-sm status-select" onchange="this.form.submit()">
          <option value="menunggu" @selected($x->status_reservasi==='menunggu')>Menunggu</option>
          <option value="dikonfirmasi" @selected($x->status_reservasi==='dikonfirmasi')>Dikonfirmasi</option>
          <option value="selesai" @selected($x->status_reservasi==='selesai')>Selesai</option>
          <option value="dibatalkan" @selected($x->status_reservasi==='dibatalkan')>Dibatalkan</option>
         </select>
        </form>
       @else
        <span class="badge text-bg-info">{{ ucfirst($x->status_reservasi) }}</span>
       @endif
      </td>
      <td>
       <div class="action-grid">
        <a class="btn btn-sm btn-outline-primary" href="{{ route('reservasi.show',$x) }}">Struk</a>
        <a class="btn btn-sm btn-warning" href="{{ route('reservasi.edit',$x) }}">Edit</a>
        <form method="post" action="{{ route('reservasi.destroy',$x) }}">
         @csrf
         @method('DELETE')
         <button class="btn btn-sm btn-danger">Hapus</button>
        </form>
       </div>
      </td>
     </tr>
    @empty
     <tr><td colspan="6" class="text-center py-4">Belum ada reservasi.</td></tr>
    @endforelse
   </tbody>
  </table>
 </div>
</div>

<div class="mt-3">{{ $data->links() }}</div>
@endsection
