<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void {Schema::create('pelanggan',function(Blueprint $t){$t->id();$t->foreignId('user_id')->nullable()->unique()->constrained('user')->nullOnDelete();$t->string('kode_pelanggan',20)->unique();$t->string('nama',100);$t->string('no_telepon',20);$t->text('alamat')->nullable();$t->timestamps();$t->index('nama');});} public function down(): void {Schema::dropIfExists('pelanggan');} };
