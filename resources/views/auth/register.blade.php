<!doctype html>
<html lang="id">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width,initial-scale=1">
 <title>Register - SM Sport Center</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
 <style>
  body{min-height:100vh;background:linear-gradient(135deg,#10231b,#123a50 58%,#7c2d12);font-family:Inter,system-ui,-apple-system,"Segoe UI",sans-serif;color:#172033;overflow-x:hidden}
  .register-shell{min-height:100vh;position:relative}
  .register-shell:before,.register-shell:after{content:"";position:absolute;border-radius:50%;border:34px solid rgba(255,255,255,.1)}
  .register-shell:before{width:260px;height:260px;left:-80px;top:12%}
  .register-shell:after{width:360px;height:360px;right:-120px;bottom:-100px}
  .brand-panel{color:white;position:relative;z-index:1}
  .brand-mark{width:58px;height:58px;border-radius:14px;background:linear-gradient(135deg,#22c55e,#2563eb);display:grid;place-items:center;font-weight:900;box-shadow:0 18px 45px rgba(37,99,235,.3)}
  .register-card{border:0;border-radius:1rem;box-shadow:0 28px 70px rgba(0,0,0,.28);position:relative;z-index:1}
  .form-control{border-radius:.75rem;border-color:#cbd5e1;padding:.75rem .9rem}
  .btn-primary{border:0;border-radius:.75rem;background:linear-gradient(135deg,#16a34a,#2563eb);font-weight:800;padding:.78rem}
 </style>
</head>
<body>
 <div class="container register-shell d-flex align-items-center py-5">
  <div class="row align-items-center justify-content-center g-4 w-100">
   <div class="col-lg-5 brand-panel">
    <div class="d-flex align-items-center gap-3 mb-4">
     <div class="brand-mark">SM</div>
     <div>
      <div class="text-white-50 fw-semibold">Member Registration</div>
      <h1 class="fw-bold mb-0">Buat Akun</h1>
     </div>
    </div>
    <p class="lead text-white-50 mb-0">Daftar sebagai pelanggan untuk reservasi lapangan futsal dan badminton.</p>
   </div>
   <div class="col-lg-6">
    <div class="card register-card p-4">
     <h2 class="fw-bold mb-1">Daftar Pelanggan</h2>
     <p class="text-muted">Akun akan otomatis masuk setelah registrasi berhasil.</p>
     <form method="post" action="{{ route('register.process') }}">
      @csrf
      <div class="row">
       <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
       </div>
       <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">No. Telepon</label>
        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" class="form-control @error('no_telepon') is-invalid @enderror" required>
        @error('no_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
       </div>
      </div>
      <div class="mb-3">
       <label class="form-label fw-semibold">Email</label>
       <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
       @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="row">
       <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Password</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
       </div>
       <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
       </div>
      </div>
      <div class="mb-3">
       <label class="form-label fw-semibold">Alamat</label>
       <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
      </div>
      <button class="btn btn-primary w-100">Daftar</button>
     </form>
     <div class="text-center small mt-3">
      Sudah punya akun?
      <a class="fw-bold text-decoration-none" href="{{ route('login') }}">Login</a>
     </div>
    </div>
   </div>
  </div>
 </div>
</body>
</html>
