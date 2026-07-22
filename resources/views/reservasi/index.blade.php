@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
 <div>
  <div class="text-muted small">Manajemen Booking</div>
  <h2 class="page-title mb-0">Data Reservasi</h2>
 </div>
 <a class="btn btn-primary" href="{{ route('reservasi.create') }}">Tambah Reservasi</a>
</div>

<form class="row g-2 mb-3">
 <div class="col-md-6"><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari kode, pelanggan, lapangan..."></div>
 <div class="col-md-3"><input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control"></div>
 <div class="col-md-3"><button class="btn btn-outline-secondary w-100">Cari</button></div>
</form>

<div class="card">
 <div class="table-responsive">
  <table class="table align-middle mb-0">
   <thead>
    <tr>
     <th>Kode</th>
     <th>Pelanggan</th>
     <th>Lapangan</th>
     <th>Tanggal</th>
     <th>Jam</th>
     <th>Total</th>
     <th>DP</th>
     <th>Bayar</th>
     <th>Status</th>
     <th>Aksi</th>
    </tr>
   </thead>
   <tbody>
    @forelse($data as $x)
     <tr>
      <td class="fw-semibold">{{ $x->kode_reservasi }}</td>
      <td>{{ $x->pelanggan->nama }}</td>
      <td>{{ $x->lapangan->nama_lapangan }}</td>
      <td>{{ $x->tanggal->format('d/m/Y') }}</td>
      <td>{{ substr($x->jam_mulai,0,5) }}-{{ substr($x->jam_selesai,0,5) }}</td>
      <td>Rp{{ number_format($x->total_harga,0,',','.') }}</td>
      <td>Rp{{ number_format($x->dp_amount ?? 50000,0,',','.') }}</td>
      <td>
       @if(auth()->user()->role==='admin')
        <form method="post" action="{{ route('reservasi.status-pembayaran',$x) }}">
         @csrf
         @method('PATCH')
         <select name="status_pembayaran" class="form-select form-select-sm" onchange="this.form.submit()">
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
         <select name="status_reservasi" class="form-select form-select-sm" onchange="this.form.submit()">
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
       <a class="btn btn-sm btn-outline-primary" href="{{ route('reservasi.show',$x) }}">Struk</a>
       <a class="btn btn-sm btn-warning" href="{{ route('reservasi.edit',$x) }}">Edit</a>
       <form class="d-inline" method="post" action="{{ route('reservasi.destroy',$x) }}">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger">Hapus</button>
       </form>
      </td>
     </tr>
    @empty
     <tr><td colspan="10" class="text-center">Belum ada reservasi.</td></tr>
    @endforelse
   </tbody>
  </table>
 </div>
</div>

<div class="mt-3">{{ $data->links() }}</div>
@endsection
