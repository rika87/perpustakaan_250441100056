<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function index()
    {
        $bukuServer = Buku::orderByDesc('id')->take(10)->get();

        return view('components.buku.index', [
            'bukuServer' => $bukuServer
        ]);
    }

    // Soal 3: halaman tambah buku, hanya untuk yang lolos Gate kelola-buku
    public function create()
    {
        return $this->index();
    }

    public function cari(Request $request)
    {
        $judul = $request->query('judul');

        $hasil = DB::select(
            'SELECT id, judul, penulis, tahun_terbit FROM bukus WHERE judul = ?',
            [$judul]
        );

        return response()->json($hasil);
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);

        return view('components.buku.show', [
            'buku' => $buku
        ]);
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return back()->with('status', 'Buku berhasil dihapus.');
    }
}