<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Reservasi extends Model {
 use HasFactory;
 protected $fillable=['kode_reservasi','pelanggan_id','lapangan_id','tanggal','jam_mulai','jam_selesai','durasi','harga_per_jam','total_harga','dp_amount','status_reservasi','status_pembayaran','catatan'];
 protected function casts(): array { return ['tanggal'=>'date','harga_per_jam'=>'decimal:2','total_harga'=>'decimal:2','dp_amount'=>'decimal:2']; }
 public function pelanggan(): BelongsTo { return $this->belongsTo(Pelanggan::class); }
 public function lapangan(): BelongsTo { return $this->belongsTo(Lapangan::class); }
}
