<?php
namespace App\Http\Controllers;
use App\Models\Lapangan;
use App\Models\Pelanggan;
use App\Models\Reservasi;
use Illuminate\View\View;
class DashboardController extends Controller {
 public function index(): View {
  $query=Reservasi::query(); if(auth()->user()->role==='pelanggan') $query->where('pelanggan_id',auth()->user()->pelanggan?->id ?? 0);
  return view('dashboard',[
   'jumlahLapangan'=>Lapangan::count(),'jumlahPelanggan'=>Pelanggan::count(),'reservasiHariIni'=>(clone $query)->whereDate('tanggal',today())->count(),
   'pendapatanBulanIni'=>(clone $query)->where('status_pembayaran','lunas')->whereMonth('tanggal',now()->month)->whereYear('tanggal',now()->year)->sum('total_harga'),
   'reservasiTerbaru'=>(clone $query)->with(['lapangan','pelanggan'])->latest()->limit(8)->get(),
  ]);
 }
}
