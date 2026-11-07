<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    private function daftar(): Builder
    {
        return DB::table('peminjamans')
            ->join('bukus', 'bukus.id', '=', 'peminjamans.buku_id')
            ->leftJoin('users', 'users.id', '=', 'peminjamans.user_id')
            ->leftJoin('anggotas', 'anggotas.id', '=', 'peminjamans.anggota_id')
            ->select(
                'peminjamans.*',
                'bukus.judul as judul_buku',
                DB::raw('COALESCE(users.name, anggotas.nama) as nama_pengguna')
            );
    }

    public function index(): View
    {
        return view('peminjaman.index', [
            'data' => $this->daftar()->orderByDesc('peminjamans.id')->get(),
        ]);
    }

    public function formAjukan(): View
    {
        return view('peminjaman.ajukan', [
            'buku' => Buku::orderBy('judul')->get(['id', 'judul']),
        ]);
    }

    public function ajukan(Request $request): RedirectResponse
    {
        $data = $request->validate(
            ['buku_id' => ['required', 'integer', 'exists:bukus,id']],
            [
                'buku_id.required' => 'Pilih buku yang ingin dipinjam.',
                'buku_id.integer'  => 'Buku yang dipilih tidak valid.',
                'buku_id.exists'   => 'Buku yang dipilih tidak ditemukan.',
            ]
        );
        // Autentikasi
        // Untuk mengambil data pengguna yang sedang login.
        $user = $request->user();

        $sudahAda = DB::table('peminjamans')
            ->where('user_id', $user->id)
            ->where('buku_id', $data['buku_id'])
            ->whereIn('status', ['diajukan', 'dipinjam'])
            ->exists();

        if ($sudahAda) {
            return back()->with('galat', 'Buku ini masih dalam pengajuan atau sedang kamu pinjam.');
        }

        DB::table('peminjamans')->insert([
            'anggota_id'     => $user->anggotaProfil()->id,
            'buku_id'        => $data['buku_id'],
            'user_id'        => $user->id,
            'status'         => 'diajukan',
            'tanggal_pinjam' => now()->toDateString(),
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return redirect()->route('riwayat.index')
            ->with('status', 'Pengajuan peminjaman berhasil dikirim.');
    }

    public function proses(string $id): RedirectResponse
    {
        $berubah = DB::table('peminjamans')
            ->where('id', $id)
            ->where('status', 'diajukan')
            ->update([
                'status'         => 'dipinjam',
                'tanggal_pinjam' => now()->toDateString(),
                'updated_at'     => now(),
            ]);

        if ($berubah === 0) {
            return back()->with('galat', 'Peminjaman tidak ditemukan atau sudah diproses.');
        }

        return back()->with('status', 'Peminjaman disetujui.');
    }

    public function tolak(string $id): RedirectResponse
    {
        $berubah = DB::table('peminjamans')
            ->where('id', $id)
            ->where('status', 'diajukan')
            ->update([
                'status'     => 'ditolak',
                'updated_at' => now(),
            ]);

        if ($berubah === 0) {
            return back()->with('galat', 'Peminjaman tidak ditemukan atau sudah diproses.');
        }

        return back()->with('galat', 'Peminjaman ditolak.');
    }

    public function pengembalian(): View
    {
        return view('pengembalian.index', [
            'data' => $this->daftar()
                ->whereIn('peminjamans.status', ['dipinjam', 'dikembalikan'])
                ->orderByDesc('peminjamans.id')
                ->get(),
        ]);
    }

    public function catatKembali(string $id): RedirectResponse
    {
        $berubah = DB::table('peminjamans')
            ->where('id', $id)
            ->where('status', 'dipinjam')
            ->update([
                'status'          => 'dikembalikan',
                'tanggal_kembali' => now()->toDateString(),
                'updated_at'      => now(),
            ]);

        if ($berubah === 0) {
            return back()->with('galat', 'Data tidak ditemukan atau buku sudah dikembalikan.');
        }

        return back()->with('status', 'Pengembalian buku dicatat.');
    }

    // Riwayat MILIK SENDIRI: selalu difilter dengan id akun yang sedang login
    public function riwayat(): View
    {
        return view('riwayat.index', [
            'data' => $this->daftar()
                ->where('peminjamans.user_id', auth()->id())
                ->orderByDesc('peminjamans.id')
                ->get(),
        ]);
    }

    // Soal 4: IDOR ditutup dengan Policy
    public function show(string $id): View
    {
        $p = Peminjaman::findOrFail($id);

        Gate::authorize('view', $p);

        return view('riwayat.show', ['p' => $p]);
    }
}