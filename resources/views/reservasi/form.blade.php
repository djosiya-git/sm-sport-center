@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
 <div>
  <div class="text-muted small">Reservasi Lapangan</div>
  <h2 class="page-title mb-0">{{ $item->exists?'Edit':'Tambah' }} Reservasi</h2>
 </div>
 <a href="{{ route('reservasi.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>

<div class="card">
 <div class="card-body">
  <form method="post" action="{{ $item->exists?route('reservasi.update',$item):route('reservasi.store') }}">
   @csrf
   @if($item->exists) @method('PUT') @endif

   @if(auth()->user()->role==='admin')
    <div class="mb-3">
     <label class="form-label fw-semibold">Pelanggan</label>
     <select name="pelanggan_id" class="form-select" required>
      <option value="">Pilih pelanggan</option>
      @foreach($pelanggans as $p)
       <option value="{{ $p->id }}" @selected(old('pelanggan_id',$item->pelanggan_id)==$p->id)>{{ $p->kode_pelanggan }} - {{ $p->nama }}</option>
      @endforeach
     </select>
    </div>
   @endif

   <div class="mb-3">
    <label class="form-label fw-semibold">Lapangan</label>
    <select name="lapangan_id" class="form-select" required>
     <option value="">Pilih lapangan</option>
     @foreach($lapangans as $l)
      <option value="{{ $l->id }}" @selected(old('lapangan_id',$item->lapangan_id)==$l->id)>{{ $l->nama_lapangan }} - Rp{{ number_format($l->harga_per_jam,0,',','.') }}/jam</option>
     @endforeach
    </select>
   </div>

   <div class="row">
    <div class="col-md-4 mb-3">
     <label class="form-label fw-semibold">Tanggal</label>
     <input type="date" name="tanggal" value="{{ old('tanggal',$item->tanggal?->format('Y-m-d')) }}" min="{{ now()->format('Y-m-d') }}" class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
     <label class="form-label fw-semibold">Jam Mulai</label>
     <input type="time" name="jam_mulai" value="{{ old('jam_mulai',substr($item->jam_mulai??'',0,5)) }}" class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
     <label class="form-label fw-semibold">Jam Selesai</label>
     <input type="time" name="jam_selesai" value="{{ old('jam_selesai',substr($item->jam_selesai??'',0,5)) }}" class="form-control" required>
    </div>
   </div>

   <div class="row">
    <div class="col-md-4 mb-3">
     <label class="form-label fw-semibold">DP Wajib</label>
     <div class="input-group">
      <span class="input-group-text">Rp</span>
      <input type="number" name="dp_amount" value="{{ old('dp_amount',$item->dp_amount ?? 50000) }}" min="50000" step="1000" class="form-control" required>
     </div>
     <div class="form-text">Minimal DP Rp50.000 untuk membuat reservasi.</div>
    </div>
    <div class="col-md-4 mb-3">
     <label class="form-label fw-semibold">Status Reservasi</label>
     @if(auth()->user()->role==='admin')
      <select name="status_reservasi" class="form-select" required>
       <option value="menunggu" @selected(old('status_reservasi',$item->status_reservasi ?: 'menunggu')==='menunggu')>Menunggu</option>
       <option value="dikonfirmasi" @selected(old('status_reservasi',$item->status_reservasi)==='dikonfirmasi')>Dikonfirmasi</option>
       <option value="selesai" @selected(old('status_reservasi',$item->status_reservasi)==='selesai')>Selesai</option>
       <option value="dibatalkan" @selected(old('status_reservasi',$item->status_reservasi)==='dibatalkan')>Dibatalkan</option>
      </select>
     @else
      <input type="text" class="form-control" value="{{ ucfirst($item->status_reservasi ?: 'menunggu') }}" disabled>
     @endif
    </div>
    <div class="col-md-4 mb-3">
     <label class="form-label fw-semibold">Status Pembayaran</label>
     @if(auth()->user()->role==='admin')
      <select name="status_pembayaran" class="form-select" required>
       <option value="sebagian" @selected(old('status_pembayaran',$item->status_pembayaran ?: 'sebagian')==='sebagian')>DP / Sebagian</option>
       <option value="lunas" @selected(old('status_pembayaran',$item->status_pembayaran)==='lunas')>Lunas</option>
      </select>
     @else
      <input type="text" class="form-control" value="DP / Sebagian" disabled>
     @endif
    </div>
   </div>

   <div class="mb-3">
    <label class="form-label fw-semibold">Catatan</label>
    <textarea name="catatan" class="form-control" rows="3">{{ old('catatan',$item->catatan) }}</textarea>
   </div>

   @if($errors->any())
    <div class="alert alert-danger">
     <ul class="mb-0">
      @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
     </ul>
    </div>
   @endif

   <button class="btn btn-primary">Simpan Reservasi</button>
  </form>
 </div>
</div>
@endsection
