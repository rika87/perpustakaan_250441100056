<?php
//Fungsinya mengatur bentuk data buku yang dikirim API sebagai JSON.”//
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

//men//
class BukuResource extends JsonResource
{
    public function toArray(Request $request): array
    //menampilkan atribut yang di tampilkan oleh Api//

    {
        return [
            'id'                => $this->id,
            'kategori'          => $this->kategori?->nama,
            'judul'             => $this->judul,
            'penulis'           => $this->penulis,
            'tahun'             => $this->tahun_terbit,
            'jumlah_peminjaman' => $this->whenCounted('peminjamans'),
        ];
    }
}





//“Halaman meminta data ke API lewat Fetch, API mengambil dari 
// database dan merapikannya dengan Resource, lalu JavaScript menampilkannya di tabel.”//