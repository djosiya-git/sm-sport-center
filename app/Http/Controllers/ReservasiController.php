<?php
namespace App\Http\Controllers;
use App\Models\Lapangan;
use App\Models\Pelanggan;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
class ReservasiController extends Controller {
 public function index(Request $r): View { $q=Reservasi::with(['pelanggan','lapangan']); if(auth()->user()->role==='pelanggan')$q->where('pelanggan_id',auth()->user()->pelanggan?->id??0); $q->when($r->q,function($x,$v){$x->where(fn($z)=>$z->where('kode_reservasi','like',"%$v%")->orWhereHas('pelanggan',fn($p)=>$p->where('nama','like',"%$v%"))->orWhereHas('lapangan',fn($l)=>$l->where('nama_lapangan','like',"%$v%")));})->when($r->tanggal,fn($x,$v)=>$x->whereDate('tanggal',$v)); return view('reservasi.index',['data'=>$q->latest('tanggal')->latest('jam_mulai')->paginate(10)->withQueryString()]); }
 public function create(Request $r): View {
  $r->validate(['lapangan_id'=>['nullable','exists:lapangans,id'],'tanggal'=>['nullable','date','after_or_equal:today'],'jam_mulai'=>['nullable','date_format:H:i']]);
  $item=new Reservasi;
  $item->lapangan_id=$r->integer('lapangan_id') ?: null;
  $item->tanggal=$r->tanggal ? Carbon::parse($r->tanggal) : null;
  $item->jam_mulai=$r->jam_mulai;
  $item->jam_selesai=$r->jam_mulai ? ($r->jam_mulai==='23:00' ? '23:59' : Carbon::createFromFormat('H:i',$r->jam_mulai)->addHour()->format('H:i')) : null;
  $item->dp_amount=50000;
  return view('reservasi.form',$this->formData($item));
 }
 public function store(Request $r): RedirectResponse { $data=$this->validated($r); $this->save($data); return redirect()->route('reservasi.index')->with('success','Reservasi berhasil disimpan.'); }
 public function edit(Reservasi $reservasi): View { $this->authorizeOwner($reservasi); return view('reservasi.form',$this->formData($reservasi)); }
 public function update(Request $r,Reservasi $reservasi): RedirectResponse { $this->authorizeOwner($reservasi); $data=$this->validated($r); $this->save($data,$reservasi); return redirect()->route('reservasi.index')->with('success','Reservasi berhasil diperbarui.'); }
 public function updateReservationStatus(Request $r,Reservasi $reservasi): RedirectResponse { $data=$r->validate(['status_reservasi'=>['required',Rule::in(['menunggu','dikonfirmasi','selesai','dibatalkan'])]]); $reservasi->update($data); return back()->with('success','Status reservasi berhasil diperbarui.'); }
 public function updatePaymentStatus(Request $r,Reservasi $reservasi): RedirectResponse { $data=$r->validate(['status_pembayaran'=>['required',Rule::in(['sebagian','lunas'])]]); $reservasi->update($data); return back()->with('success','Status pembayaran berhasil diperbarui.'); }
 public function destroy(Reservasi $reservasi): RedirectResponse { $this->authorizeOwner($reservasi); $reservasi->delete(); return back()->with('success','Reservasi berhasil dihapus.'); }
 private function formData(Reservasi $item): array { return ['item'=>$item,'lapangans'=>Lapangan::where('status','tersedia')->orderBy('nama_lapangan')->get(),'pelanggans'=>Pelanggan::orderBy('nama')->get()]; }
 private function validated(Request $r): array { $rules=['lapangan_id'=>['required','exists:lapangans,id'],'tanggal'=>['required','date','after_or_equal:today'],'jam_mulai'=>['required','date_format:H:i'],'jam_selesai'=>['required','date_format:H:i','after:jam_mulai'],'dp_amount'=>['required','numeric','min:50000'],'catatan'=>['nullable','max:500']]; if(auth()->user()->role==='admin'){$rules['pelanggan_id']=['required','exists:pelanggans,id'];$rules['status_reservasi']=['required',Rule::in(['menunggu','dikonfirmasi','selesai','dibatalkan'])];$rules['status_pembayaran']=['required',Rule::in(['sebagian','lunas'])];} return $r->validate($rules); }
 private function save(array $data,?Reservasi $item=null): void { DB::transaction(function()use($data,$item){$pelangganId=auth()->user()->role==='admin'?$data['pelanggan_id']:auth()->user()->pelanggan?->id; abort_unless($pelangganId,422,'Profil pelanggan belum tersedia.'); $lapangan=Lapangan::whereKey($data['lapangan_id'])->where('status','tersedia')->lockForUpdate()->firstOrFail(); $bentrok=Reservasi::where('lapangan_id',$data['lapangan_id'])->whereDate('tanggal',$data['tanggal'])->when($item,fn($q)=>$q->whereKeyNot($item->id))->whereNotIn('status_reservasi',['dibatalkan'])->where('jam_mulai','<',$data['jam_selesai'])->where('jam_selesai','>',$data['jam_mulai'])->lockForUpdate()->exists(); if($bentrok)throw ValidationException::withMessages(['jam_mulai'=>'Jadwal bentrok. Lapangan sudah dipesan pada rentang waktu tersebut.']); $menit=Carbon::createFromFormat('H:i',$data['jam_mulai'])->diffInMinutes(Carbon::createFromFormat('H:i',$data['jam_selesai'])); $durasi=(int)ceil($menit/60); $payload=['pelanggan_id'=>$pelangganId,'lapangan_id'=>$data['lapangan_id'],'tanggal'=>$data['tanggal'],'jam_mulai'=>$data['jam_mulai'],'jam_selesai'=>$data['jam_selesai'],'durasi'=>$durasi,'harga_per_jam'=>$lapangan->harga_per_jam,'total_harga'=>$durasi*$lapangan->harga_per_jam,'dp_amount'=>$data['dp_amount'],'status_reservasi'=>auth()->user()->role==='admin'?$data['status_reservasi']:($item?->status_reservasi??'menunggu'),'status_pembayaran'=>auth()->user()->role==='admin'?$data['status_pembayaran']:'sebagian','catatan'=>$data['catatan']??null]; if(!$item){$payload+=['kode_reservasi'=>'RSV-'.now()->format('Ymd').'-'.strtoupper(str()->random(6))]; Reservasi::create($payload);}else{$item->update($payload);} },3); }
 private function authorizeOwner(Reservasi $r): void { if(auth()->user()->role==='pelanggan')abort_unless($r->pelanggan_id===auth()->user()->pelanggan?->id,403); }
}
