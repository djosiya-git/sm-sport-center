<?php
namespace App\Http\Controllers;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
class AuthController extends Controller {
 public function showLogin(): View { return view('auth.login'); }
 public function showRegister(): View { return view('auth.register'); }
 public function login(Request $request): RedirectResponse {
  $credentials=$request->validate(['email'=>['required','email'],'password'=>['required']]);
  if (!Auth::attempt($credentials,$request->boolean('remember'))) return back()->withErrors(['email'=>'Email atau password salah.'])->onlyInput('email');
  $request->session()->regenerate(); return redirect()->intended(route('dashboard'));
 }
 public function register(Request $request): RedirectResponse {
  $data=$request->validate([
   'name'=>['required','string','max:255'],
   'email'=>['required','email','max:255','unique:user,email'],
   'password'=>['required','confirmed',Password::min(8)],
   'no_telepon'=>['required','string','max:20'],
   'alamat'=>['nullable','string','max:500'],
  ]);
  $user=DB::transaction(function()use($data){
   $user=User::create(['name'=>$data['name'],'email'=>$data['email'],'password'=>$data['password'],'role'=>'pelanggan']);
   $nextNumber=(Pelanggan::lockForUpdate()->max('id')??0)+1;
   Pelanggan::create([
    'user_id'=>$user->id,
    'kode_pelanggan'=>'PLG-'.str_pad((string)$nextNumber,4,'0',STR_PAD_LEFT),
    'nama'=>$data['name'],
    'no_telepon'=>$data['no_telepon'],
    'alamat'=>$data['alamat']??null,
   ]);
   return $user;
  });
  Auth::login($user);
  $request->session()->regenerate();
  return redirect()->route('dashboard')->with('success','Registrasi berhasil. Selamat datang di SM Sport Center.');
 }
 public function logout(Request $request): RedirectResponse { Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); return redirect()->route('login'); }
}
