<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
 public function up(): void {
  Schema::table('reservasi',function(Blueprint $t){
   $t->decimal('dp_amount',12,2)->default(50000)->after('total_harga');
  });
 }

 public function down(): void {
  Schema::table('reservasi',function(Blueprint $t){
   $t->dropColumn('dp_amount');
  });
 }
};
