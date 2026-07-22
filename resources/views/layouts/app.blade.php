<!doctype html>
<html lang="id">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width,initial-scale=1">
 <title>@yield('title','SM Sport Center')</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
 <style>
  :root{--ink:#172033;--muted:#64748b;--line:#dbe4ef;--field:#16a34a;--court:#f97316;--ocean:#2563eb;--danger:#ef4444}
  body{background:#eef3f8;color:var(--ink);font-family:Inter,system-ui,-apple-system,"Segoe UI",sans-serif}
  .app-shell{min-height:100vh}
  .sidebar{min-height:100vh;background:#101827;color:white;position:relative;overflow:hidden}
  .sidebar:before{content:"";position:absolute;inset:auto -45px -70px auto;width:180px;height:180px;border:28px solid rgba(34,197,94,.16);border-radius:50%}
  .brand-mark{width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,var(--field),var(--ocean));display:grid;place-items:center;font-weight:800;color:white;box-shadow:0 10px 30px rgba(37,99,235,.25)}
  .sidebar a{color:#d7dee9;text-decoration:none;display:flex;align-items:center;gap:.7rem;padding:.82rem 1rem;border-radius:.7rem;font-weight:600;position:relative}
  .sidebar a:hover,.sidebar a.active{background:rgba(255,255,255,.1);color:white}
  .sidebar a.active:before{content:"";width:4px;height:22px;border-radius:99px;background:var(--court);position:absolute;left:.35rem}
  .nav-dot{width:9px;height:9px;border-radius:50%;background:#94a3b8}
  .sidebar a:hover .nav-dot,.sidebar a.active .nav-dot{background:var(--court)}
  .user-panel{background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.1);border-radius:.9rem;padding:1rem;position:relative}
  main{background:radial-gradient(circle at 15% 0,rgba(22,163,74,.12),transparent 34%),radial-gradient(circle at 85% 12%,rgba(249,115,22,.12),transparent 28%),#eef3f8}
  .page-title{font-weight:800;letter-spacing:0}
  .card{border:1px solid rgba(148,163,184,.22);border-radius:.9rem;box-shadow:0 18px 45px rgba(15,23,42,.08)}
  .metric-card{position:relative;overflow:hidden;min-height:120px}
  .metric-card:after{content:"";position:absolute;right:-22px;bottom:-34px;width:110px;height:110px;border-radius:50%;border:18px solid rgba(37,99,235,.08)}
  .metric-label{color:var(--muted);font-size:.78rem;text-transform:uppercase;font-weight:800;letter-spacing:.08em}
  .metric-value{font-size:2rem;font-weight:850;margin:0}
  .btn{border-radius:.7rem;font-weight:700}
  .btn-primary{background:linear-gradient(135deg,var(--field),var(--ocean));border:0;box-shadow:0 10px 20px rgba(37,99,235,.2)}
  .btn-outline-secondary{border-color:#cbd5e1;color:#334155;background:white}
  .form-control,.form-select{border-radius:.7rem;border-color:#cbd5e1}
  .table{--bs-table-bg:transparent}
  .table thead th{white-space:nowrap;color:#475569;font-size:.78rem;text-transform:uppercase;letter-spacing:.04em;background:#f8fafc}
  .badge{border-radius:.55rem}
  @media (max-width:991.98px){.sidebar{min-height:auto}.sidebar:before{display:none}main{min-height:100vh}}
 </style>
</head>
<body>
@php
 $adminPendingReservations=auth()->user()->role==='admin' ? \App\Models\Reservasi::where('status_reservasi','menunggu')->count() : 0;
@endphp
<nav class="navbar navbar-dark d-lg-none" style="background:#101827">
 <div class="container-fluid">
  <span class="navbar-brand fw-bold">SM Sport Center</span>
 </div>
</nav>
<div class="container-fluid app-shell">
 <div class="row">
  <aside class="col-lg-2 sidebar p-3">
   <div class="d-flex align-items-center gap-3 mb-4">
    <div class="brand-mark">SM</div>
    <div>
     <h4 class="text-white mb-0">Sport Center</h4>
     <div class="text-white-50 small">Court booking</div>
    </div>
   </div>
   <nav class="d-grid gap-1">
    <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="nav-dot"></span>Dashboard</a>
    <a class="{{ request()->routeIs('reservasi.*') ? 'active' : '' }}" href="{{ route('reservasi.index') }}">
     <span class="nav-dot"></span>Reservasi
     @if($adminPendingReservations>0)<span class="badge text-bg-warning ms-auto">{{ $adminPendingReservations }}</span>@endif
    </a>
    @if(auth()->user()->role==='admin')
     <a class="{{ request()->routeIs('lapangan.*') ? 'active' : '' }}" href="{{ route('lapangan.index') }}"><span class="nav-dot"></span>Lapangan</a>
     <a class="{{ request()->routeIs('pelanggan.*') ? 'active' : '' }}" href="{{ route('pelanggan.index') }}"><span class="nav-dot"></span>Pelanggan</a>
     <a class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}" href="{{ route('laporan.index') }}"><span class="nav-dot"></span>Laporan</a>
    @endif
   </nav>
   <hr class="border-secondary">
   <div class="user-panel">
    <div class="text-light small mb-2">{{ auth()->user()->name }}</div>
    <span class="badge text-bg-secondary mb-3">{{ ucfirst(auth()->user()->role) }}</span>
    <form method="post" action="{{ route('logout') }}">
     @csrf
     <button class="btn btn-outline-light btn-sm w-100">Logout</button>
    </form>
   </div>
  </aside>
  <main class="col-lg-10 p-4">
   @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
   @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
   @if($adminPendingReservations>0)
    <div class="alert alert-warning d-flex flex-wrap justify-content-between align-items-center gap-2">
     <div><strong>{{ $adminPendingReservations }} reservasi baru</strong> masih menunggu konfirmasi admin.</div>
     <a class="btn btn-sm btn-warning" href="{{ route('reservasi.index',['status_reservasi'=>'menunggu']) }}">Lihat Reservasi</a>
    </div>
   @endif
   @yield('content')
  </main>
 </div>
</div>
</body>
</html>
