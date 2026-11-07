<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'anggota_id',
        'buku_id',
        'user_id',
        'status',
        'tanggal_pinjam',
        'tanggal_kembali',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getJudulBukuAttribute(): ?string
    {
        return $this->buku?->judul;
    }

    public function getNamaPenggunaAttribute(): ?string
    {
        return $this->user?->name ?? $this->anggota?->nama;
    }
}