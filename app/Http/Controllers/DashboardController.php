<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard');
    }

    public function admin(): View
    {
        return view('admin.dashboard', [
            'totalBuku'       => Buku::count(),
            'totalPengguna'   => User::count(),
            'totalPeminjaman' => DB::table('peminjamans')->count(),
        ]);
    }

    public function petugas(): View
    {
        return view('petugas.dashboard', [
            'diajukan' => DB::table('peminjamans')->where('status', 'diajukan')->count(),
            'dipinjam' => DB::table('peminjamans')->where('status', 'dipinjam')->count(),
        ]);
    }

    public function siswa(): View
    {
        $milik = fn () => DB::table('peminjamans')->where('user_id', auth()->id());

        return view('siswa.dashboard', [
            'jumlahRiwayat' => $milik()->count(),
            'diajukan'      => $milik()->where('status', 'diajukan')->count(),
            'dipinjam'      => $milik()->where('status', 'dipinjam')->count(),
            'dikembalikan'  => $milik()->where('status', 'dikembalikan')->count(),
            'terakhir'      => DB::table('peminjamans')
                ->join('bukus', 'bukus.id', '=', 'peminjamans.buku_id')
                ->where('peminjamans.user_id', auth()->id())
                ->orderByDesc('peminjamans.id')
                ->limit(3)
                ->get(['bukus.judul', 'peminjamans.tanggal_pinjam', 'peminjamans.status']),
        ]);
    }}