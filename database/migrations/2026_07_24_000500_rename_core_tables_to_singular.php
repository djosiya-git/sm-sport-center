<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
 public function up(): void {
  if (Schema::hasTable('users') && !Schema::hasTable('user')) Schema::rename('users','user');
  if (Schema::hasTable('lapangans') && !Schema::hasTable('lapangan')) Schema::rename('lapangans','lapangan');
  if (Schema::hasTable('pelanggans') && !Schema::hasTable('pelanggan')) Schema::rename('pelanggans','pelanggan');
  if (Schema::hasTable('reservasis') && !Schema::hasTable('reservasi')) Schema::rename('reservasis','reservasi');
 }

 public function down(): void {
  if (Schema::hasTable('reservasi') && !Schema::hasTable('reservasis')) Schema::rename('reservasi','reservasis');
  if (Schema::hasTable('pelanggan') && !Schema::hasTable('pelanggans')) Schema::rename('pelanggan','pelanggans');
  if (Schema::hasTable('lapangan') && !Schema::hasTable('lapangans')) Schema::rename('lapangan','lapangans');
  if (Schema::hasTable('user') && !Schema::hasTable('users')) Schema::rename('user','users');
 }
};
