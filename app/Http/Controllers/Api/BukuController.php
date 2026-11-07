<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Http\Resources\BukuResource;
use App\Models\Buku;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // GET /api/buku?cari=&kategori=&tahun=&page=
    public function index(Request $request): JsonResponse
    {
        $buku = Buku::with('kategori')              
            ->withCount('peminjamans')              
            ->when($request->filled('cari'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('judul', 'like', '%' . $request->cari . '%')
                      ->orWhere('penulis', 'like', '%' . $request->cari . '%');
                });
            })
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori_id', $request->kategori))
            ->when($request->filled('tahun'), fn ($q) => $q->where('tahun_terbit', $request->tahun))
            ->latest()                             
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();                    

        return response()->json([
            'message' => 'Daftar buku berhasil diambil',

            'data'    => BukuResource::collection($buku->items())->resolve(),
            'meta'    => [
                'current_page' => $buku->currentPage(),
                'per_page'     => $buku->perPage(),
                'total'        => $buku->total(),
                'last_page'    => $buku->lastPage(),
                'from'         => $buku->firstItem(),
                'to'           => $buku->lastItem(),
            ],
            'links'   => [
                'first' => $buku->url(1),
                'last'  => $buku->url($buku->lastPage()),
                'prev'  => $buku->previousPageUrl(),
                'next'  => $buku->nextPageUrl(),
            ],
        ], 200);
    }

    // POST /api/buku
    public function store(Request $request): JsonResponse
    {
        $form = new StoreBukuRequest();
        
        $data = $request->validate($form->rules(), $form->messages(), $form->attributes());

        $buku = Buku::create($data);
        $buku->load('kategori');

        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'data'    => $buku,
        ], 201);
    }

    // GET /api/buku/{id}
    public function show(string $id): JsonResponse
    {
        $buku = Buku::find($id);

        if (! $buku) {
            return $this->notFound();
        }

        $buku->load(['kategori', 'peminjamans']);

        return response()->json([
            'message' => 'Detail buku berhasil diambil',
            'data'    => $buku,
        ], 200);
    }

    // PUT /api/buku/{id}
    public function update(Request $request, string $id): JsonResponse
    {
        $form = new UpdateBukuRequest();
       
        $data = $request->validate($form->rules(), $form->messages(), $form->attributes());

        $buku = Buku::find($id);

        if (! $buku) {
            return $this->notFound();
        }

        $buku->update($data);

        return response()->json([
            'message' => 'Buku berhasil diperbarui',
            'data'    => $buku->fresh('kategori'),
        ], 200);
    }

    // DELETE /api/buku/{id}
    public function destroy(string $id): JsonResponse
    {
        $buku = Buku::find($id);

        if (! $buku) {
            return $this->notFound();
        }

        $buku->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus',
        ], 200);
    }

    private function notFound(): JsonResponse
    {
        return response()->json(['message' => 'not found'], 404);
    }
}