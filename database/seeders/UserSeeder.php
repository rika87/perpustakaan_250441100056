<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Soal 5 (c): password admin diambil dari .env, bukan lagi "password"
        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'username' => 'admin',
                'name'     => 'Administrator',
                'password' => Hash::make(env('ADMIN_PASSWORD', Str::random(32))),
            ]
        );
        $admin->syncRoles('admin');

        $petugas = User::firstOrCreate(
            ['email' => 'petugas@gmail.com'],
            ['username' => 'petugas', 'name' => 'Petugas Perpustakaan', 'password' => Hash::make('password')]
        );
        $petugas->syncRoles('petugas');

        $siswa = User::firstOrCreate(
            ['email' => 'siswa@gmail.com'],
            ['username' => 'siswa', 'name' => 'Siswa Satu', 'password' => Hash::make('password')]
        );
        $siswa->syncRoles('siswa');

        $siswa2 = User::firstOrCreate(
            ['email' => 'siswa2@gmail.com'],
            ['username' => 'siswa2', 'name' => 'Siswa Dua', 'password' => Hash::make('password')]
        );
        $siswa2->syncRoles('siswa');

        $this->isiRiwayat($siswa, ['dikembalikan', 'dipinjam']);
        $this->isiRiwayat($siswa2, ['dipinjam']);
    }

    private function isiRiwayat(User $user, array $daftarStatus): void
    {
        $idBuku = Buku::orderBy('id')->pluck('id');

        if ($idBuku->isEmpty() || DB::table('peminjamans')->where('user_id', $user->id)->exists()) {
            return;
        }

        $anggota = $user->anggotaProfil();

        foreach ($daftarStatus as $i => $status) {
            DB::table('peminjamans')->insert([
                'anggota_id'      => $anggota->id,
                'buku_id'         => $idBuku[$i % $idBuku->count()],
                'user_id'         => $user->id,
                'status'          => $status,
                'tanggal_pinjam'  => now()->subDays(10 - $i)->toDateString(),
                'tanggal_kembali' => $status === 'dikembalikan' ? now()->subDays(3)->toDateString() : null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}