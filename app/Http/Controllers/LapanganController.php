<?php
namespace App\Http\Controllers;
use App\Models\Lapangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
class LapanganController extends Controller {
 public function index(Request $request): View { $data=Lapangan::when($request->q,fn($q,$v)=>$q->where('nama_lapangan','like',"%$v%")->orWhere('kode_lapangan','like',"%$v%"))->orderBy('nama_lapangan')->paginate(10)->withQueryString(); return view('lapangan.index',['data'=>$data]); }
 public function create(): View { return view('lapangan.form',['item'=>new Lapangan]); }
 public function store(Request $request): RedirectResponse { Lapangan::create($this->validated($request)); return redirect()->route('lapangan.index')->with('success','Lapangan berhasil ditambahkan.'); }
 public function edit(Lapangan $lapangan): View { return view('lapangan.form',['item'=>$lapangan]); }
 public function update(Request $request,Lapangan $lapangan): RedirectResponse { $lapangan->update($this->validated($request,$lapangan)); return redirect()->route('lapangan.index')->with('success','Lapangan berhasil diperbarui.'); }
 public function destroy(Lapangan $lapangan): RedirectResponse { if($lapangan->reservasis()->exists()) return back()->with('error','Lapangan tidak dapat dihapus karena sudah memiliki reservasi.'); $lapangan->delete(); return back()->with('success','Lapangan berhasil dihapus.'); }
 private function validated(Request $r,?Lapangan $item=null): array { return $r->validate(['kode_lapangan'=>['required','max:20',Rule::unique('lapangans')->ignore($item)],'nama_lapangan'=>['required','max:100'],'jenis'=>['required',Rule::in(['futsal','badminton'])],'harga_per_jam'=>['required','numeric','min:0'],'status'=>['required',Rule::in(['tersedia','perawatan','nonaktif'])],'keterangan'=>['nullable','max:500']]); }
}
