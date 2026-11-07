<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function index()
    {
        // Soal 1 (A1): data buku terbaru dirender langsung oleh Blade
        $bukuServer = Buku::orderByDesc('id')->take(10)->get();

        return view('components.buku.index', [
            'bukuServer' => $bukuServer
        ]);
    }

    // Soal 1 (A2): RENTAN SQL injection, $judul digabung ke string SQL
    public function cari(Request $request)
    {
        $judul = $request->query('judul');

        $hasil = DB::select(
            "SELECT id, judul, penulis, tahun_terbit FROM bukus WHERE judul = '$judul'"
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
}