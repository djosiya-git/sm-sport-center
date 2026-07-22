<?php
namespace App\Http\Controllers;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\View\View;
class LaporanController extends Controller {
 public function index(Request $r): View { $awal=$r->tanggal_awal??now()->startOfMonth()->toDateString(); $akhir=$r->tanggal_akhir??now()->endOfMonth()->toDateString(); $q=Reservasi::with(['pelanggan','lapangan'])->whereBetween('tanggal',[$awal,$akhir]); return view('laporan.index',['data'=>(clone $q)->orderBy('tanggal')->paginate(20)->withQueryString(),'awal'=>$awal,'akhir'=>$akhir,'totalReservasi'=>(clone $q)->count(),'totalPendapatan'=>(clone $q)->where('status_pembayaran','lunas')->sum('total_harga'),'perLapangan'=>(clone $q)->selectRaw('lapangan_id, COUNT(*) total')->groupBy('lapangan_id')->with('lapangan')->get()]); }
}
