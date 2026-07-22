<!doctype html>
<html lang="id">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width,initial-scale=1">
 <title>Login - SM Sport Center</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
 <style>
  body{min-height:100vh;background:linear-gradient(135deg,#10231b,#123a50 58%,#7c2d12);font-family:Inter,system-ui,-apple-system,"Segoe UI",sans-serif;color:#172033;overflow-x:hidden}
  .login-shell{min-height:100vh;position:relative}
  .login-shell:before,.login-shell:after{content:"";position:absolute;border-radius:50%;border:34px solid rgba(255,255,255,.1)}
  .login-shell:before{width:260px;height:260px;left:-80px;top:12%}
  .login-shell:after{width:360px;height:360px;right:-120px;bottom:-100px}
  .brand-panel{color:white;position:relative;z-index:1}
  .brand-mark{width:58px;height:58px;border-radius:14px;background:linear-gradient(135deg,#22c55e,#2563eb);display:grid;place-items:center;font-weight:900;box-shadow:0 18px 45px rgba(37,99,235,.3)}
  .login-card{border:0;border-radius:1rem;box-shadow:0 28px 70px rgba(0,0,0,.28);position:relative;z-index:1}
  .form-control{border-radius:.75rem;border-color:#cbd5e1;padding:.75rem .9rem}
  .btn-primary{border:0;border-radius:.75rem;background:linear-gradient(135deg,#16a34a,#2563eb);font-weight:800;padding:.78rem}
  .demo-box{background:#f8fafc;border:1px dashed #cbd5e1;border-radius:.8rem;padding:.85rem}
 </style>
</head>
<body>
 <div class="container login-shell d-flex align-items-center py-5">
  <div class="row align-items-center justify-content-center g-4 w-100">
   <div class="col-lg-6 brand-panel">
    <div class="d-flex align-items-center gap-3 mb-4">
     <div class="brand-mark">SM</div>
     <div>
      <div class="text-white-50 fw-semibold">Court Reservation System</div>
      <h1 class="fw-bold mb-0">SM Sport Center</h1>
     </div>
    </div>
    <p class="lead text-white-50 mb-0">Kelola jadwal futsal dan badminton dengan cepat, jelas, dan siap dipantau harian.</p>
   </div>
   <div class="col-lg-5">
    <div class="card login-card p-4">
     <h2 class="fw-bold mb-1">Masuk</h2>
     <p class="text-muted">Gunakan akun admin atau pelanggan.</p>
     <form method="post" action="{{ route('login.process') }}">
      @csrf
      <div class="mb-3">
       <label class="form-label fw-semibold">Email</label>
       <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
       @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
       <label class="form-label fw-semibold">Password</label>
       <input type="password" name="password" class="form-control" required>
      </div>
      <div class="form-check mb-3">
       <input class="form-check-input" type="checkbox" name="remember" id="remember">
       <label class="form-check-label" for="remember">Ingat saya</label>
      </div>
      <button class="btn btn-primary w-100">Login</button>
     </form>
     <div class="demo-box small text-muted mt-4">
      <strong class="text-dark">Akun demo</strong><br>
      Admin: admin@smsport.test / admin12345<br>
      Pelanggan: pelanggan@smsport.test / pelanggan123
     </div>
    </div>
   </div>
  </div>
 </div>
</body>
</html>
