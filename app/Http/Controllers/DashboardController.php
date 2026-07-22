<?php
namespace App\Http\Controllers;
use App\Models\Lapangan;
use App\Models\Pelanggan;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\View\View;
class DashboardController extends Controller {
 public function index(Request $request): View {
  $request->validate(['tanggal'=>['nullable','date']]);
  $tanggalJadwal=$request->date('tanggal')?->toDateString() ?? today()->toDateString();
  $query=Reservasi::query(); if(auth()->user()->role==='pelanggan') $query->where('pelanggan_id',auth()->user()->pelanggan?->id ?? 0);
  $lapangans=Lapangan::orderBy('jenis')->orderBy('nama_lapangan')->get();
  $reservasiJadwal=Reservasi::with(['lapangan','pelanggan'])->whereDate('tanggal',$tanggalJadwal)->where('status_reservasi','!=','dibatalkan')->get()->groupBy('lapangan_id');
  $jamJadwal=range(0,23);
  $jadwalLapangan=$lapangans->map(function($lapangan)use($reservasiJadwal,$jamJadwal){
   $reservasis=$reservasiJadwal->get($lapangan->id,collect());
   return ['lapangan'=>$lapangan,'slots'=>collect($jamJadwal)->mapWithKeys(function($jam)use($reservasis){
    $slotMulai=sprintf('%02d:00',$jam); $slotSelesai=sprintf('%02d:00',$jam+1);
    $reservasi=$reservasis->first(fn($r)=>substr($r->jam_mulai,0,5)<$slotSelesai && substr($r->jam_selesai,0,5)>$slotMulai);
    return [$jam=>$reservasi];
   })];
  });
  return view('dashboard',[
   'jumlahLapangan'=>Lapangan::count(),'jumlahPelanggan'=>Pelanggan::count(),'reservasiHariIni'=>(clone $query)->whereDate('tanggal',today())->count(),
   'pendapatanBulanIni'=>(clone $query)->where('status_pembayaran','lunas')->whereMonth('tanggal',now()->month)->whereYear('tanggal',now()->year)->sum('total_harga'),
   'reservasiTerbaru'=>(clone $query)->with(['lapangan','pelanggan'])->latest()->limit(8)->get(),'tanggalJadwal'=>$tanggalJadwal,'jamJadwal'=>$jamJadwal,'jadwalLapangan'=>$jadwalLapangan,
  ]);
 }
}
