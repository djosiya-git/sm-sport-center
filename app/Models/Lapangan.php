<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Lapangan extends Model {
 use HasFactory;
 protected $fillable=['kode_lapangan','nama_lapangan','jenis','harga_per_jam','status','keterangan'];
 protected function casts(): array { return ['harga_per_jam'=>'decimal:2']; }
 public function reservasis(): HasMany { return $this->hasMany(Reservasi::class); }
}
