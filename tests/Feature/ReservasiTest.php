<?php
namespace Tests\Feature;

use App\Models\Lapangan;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservasiTest extends TestCase
{
    use RefreshDatabase;

    public function test_reservasi_valid_tersimpan(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pelanggan = Pelanggan::create([
            'kode_pelanggan' => 'PLG-0001',
            'nama' => 'Budi Santoso',
            'no_telepon' => '081234567890',
        ]);
        $lapangan = Lapangan::create([
            'kode_lapangan' => 'FUT-01',
            'nama_lapangan' => 'Lapangan Futsal 1',
            'jenis' => 'futsal',
            'harga_per_jam' => 150000,
            'status' => 'tersedia',
        ]);

        $this->actingAs($admin)->post('/reservasi', [
            'pelanggan_id' => $pelanggan->id,
            'lapangan_id' => $lapangan->id,
            'tanggal' => today()->addDay()->toDateString(),
            'jam_mulai' => '10:00',
            'jam_selesai' => '12:00',
            'dp_amount' => 50000,
            'status_reservasi' => 'menunggu',
            'status_pembayaran' => 'sebagian',
        ])->assertRedirect('/reservasi');

        $this->assertDatabaseHas('reservasi', [
            'pelanggan_id' => $pelanggan->id,
            'lapangan_id' => $lapangan->id,
            'jam_mulai' => '10:00',
            'jam_selesai' => '12:00',
            'dp_amount' => 50000,
        ]);
    }

    public function test_reservasi_bentrok_ditolak(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pelanggan = Pelanggan::create([
            'kode_pelanggan' => 'PLG-0001',
            'nama' => 'Budi Santoso',
            'no_telepon' => '081234567890',
        ]);
        $lapangan = Lapangan::create([
            'kode_lapangan' => 'FUT-01',
            'nama_lapangan' => 'Lapangan Futsal 1',
            'jenis' => 'futsal',
            'harga_per_jam' => 150000,
            'status' => 'tersedia',
        ]);
        $tanggal = today()->addDay()->toDateString();

        $payload = [
            'pelanggan_id' => $pelanggan->id,
            'lapangan_id' => $lapangan->id,
            'tanggal' => $tanggal,
            'jam_mulai' => '10:00',
            'jam_selesai' => '12:00',
            'dp_amount' => 50000,
            'status_reservasi' => 'menunggu',
            'status_pembayaran' => 'sebagian',
        ];

        $this->actingAs($admin)->post('/reservasi', $payload);

        $payload['jam_mulai'] = '11:00';
        $payload['jam_selesai'] = '13:00';

        $this->actingAs($admin)->post('/reservasi', $payload)
            ->assertSessionHasErrors('jam_mulai');

        $this->assertDatabaseCount('reservasi', 1);
    }
}
