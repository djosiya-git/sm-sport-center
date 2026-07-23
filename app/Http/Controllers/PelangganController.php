<?php
namespace App\Http\Controllers;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
class PelangganController extends Controller {
 public function index(Request $request): View { $data=Pelanggan::when($request->q,fn($q,$v)=>$q->where('nama','like',"%$v%")->orWhere('kode_pelanggan','like',"%$v%")->orWhere('no_telepon','like',"%$v%"))->latest()->paginate(10)->withQueryString(); return view('pelanggan.index',['data'=>$data]); }
 public function create(): View { return view('pelanggan.form',['item'=>new Pelanggan]); }
 public function store(Request $request): RedirectResponse { $data=$this->validated($request); DB::transaction(function()use($data){$u=User::create(['name'=>$data['nama'],'email'=>$data['email'],'password'=>$data['password'],'role'=>'pelanggan']); Pelanggan::create(['user_id'=>$u->id,'kode_pelanggan'=>$this->kode(),'nama'=>$data['nama'],'no_telepon'=>$data['no_telepon'],'alamat'=>$data['alamat']??null]);}); return redirect()->route('pelanggan.index')->with('success','Pelanggan berhasil ditambahkan.'); }
 public function edit(Pelanggan $pelanggan): View { $pelanggan->load('user'); return view('pelanggan.form',['item'=>$pelanggan]); }
 public function update(Request $request,Pelanggan $pelanggan): RedirectResponse { $data=$this->validated($request,$pelanggan); DB::transaction(function()use($data,$pelanggan){$pelanggan->update(['nama'=>$data['nama'],'no_telepon'=>$data['no_telepon'],'alamat'=>$data['alamat']??null]); $u=['name'=>$data['nama'],'email'=>$data['email']]; if(!empty($data['password']))$u['password']=$data['password']; $pelanggan->user?->update($u);}); return redirect()->route('pelanggan.index')->with('success','Pelanggan berhasil diperbarui.'); }
 public function destroy(Pelanggan $pelanggan): RedirectResponse { if($pelanggan->reservasis()->exists()) return back()->with('error','Pelanggan tidak dapat dihapus karena memiliki reservasi.'); $pelanggan->user?->delete(); return back()->with('success','Pelanggan berhasil dihapus.'); }
 private function validated(Request $r,?Pelanggan $p=null): array { return $r->validate(['nama'=>['required','max:100'],'email'=>['required','email',Rule::unique('user')->ignore($p?->user_id)],'password'=>[$p?'nullable':'required','min:8'],'no_telepon'=>['required','max:20'],'alamat'=>['nullable','max:500']]); }
 private function kode(): string { return 'PLG-'.str_pad((string)((Pelanggan::max('id')??0)+1),4,'0',STR_PAD_LEFT); }
}
