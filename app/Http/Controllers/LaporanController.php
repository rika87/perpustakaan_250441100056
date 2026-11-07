<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(): View
    {
        $ringkasan = [
            'Total buku'        => Buku::count(),
            'Total peminjaman'  => DB::table('peminjamans')->count(),
            'Diajukan'          => DB::table('peminjamans')->where('status', 'diajukan')->count(),
            'Sedang dipinjam'   => DB::table('peminjamans')->where('status', 'dipinjam')->count(),
            'Sudah dikembalikan' => DB::table('peminjamans')->where('status', 'dikembalikan')->count(),
        ];

        $perKategori = DB::table('kategoris')
            ->leftJoin('bukus', 'bukus.kategori_id', '=', 'kategoris.id')
            ->select('kategoris.nama', DB::raw('count(bukus.id) as jumlah_buku'))
            ->groupBy('kategoris.id', 'kategoris.nama')
            ->orderBy('kategoris.nama')
            ->get();

        $terbanyak = DB::table('bukus')
            ->leftJoin('peminjamans', 'peminjamans.buku_id', '=', 'bukus.id')
            ->select('bukus.judul', DB::raw('count(peminjamans.id) as jumlah'))
            ->groupBy('bukus.id', 'bukus.judul')
            ->orderByDesc('jumlah')
            ->limit(10)
            ->get();

        return view('laporan.index', compact('ringkasan', 'perKategori', 'terbanyak'));
    }
}