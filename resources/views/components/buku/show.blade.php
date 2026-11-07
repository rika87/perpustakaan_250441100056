@extends('layouts.perpustakaan')

@section('title', 'Detail Buku')

@section('content')

<style>
    .dt-wrap{max-width:820px;margin:0 auto}
    .dt-kartu{background:#fff;border:1px solid #ead9c7;border-radius:16px;overflow:hidden;box-shadow:0 6px 24px rgba(74,56,43,.08)}
    .dt-atas{background:linear-gradient(135deg,#4a382b,#6f5846);color:#fff;padding:32px}
    .dt-kategori{display:inline-block;background:#e9cfa9;color:#4a382b;border-radius:99px;padding:4px 14px;font-size:13px;font-weight:600}
    .dt-atas h1{margin:14px 0 6px;font-size:28px;line-height:1.25}
    .dt-atas p{margin:0;color:#ead9c7;font-size:14px}
    .dt-isi{padding:28px 32px}
    .dt-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:14px}
    .dt-item{background:#f6efe7;border-radius:12px;padding:14px 16px}
    .dt-item span{display:block;font-size:12px;color:#6f5846;text-transform:uppercase;letter-spacing:.04em}
    .dt-item strong{display:block;margin-top:4px;font-size:17px;color:#3b2d22}
    .dt-aksi{display:flex;gap:10px;flex-wrap:wrap;margin-top:24px}
    .dt-btn{display:inline-block;padding:10px 20px;border-radius:10px;text-decoration:none;font-size:14px;font-weight:600}
    .dt-btn-utama{background:#6f5846;color:#fff}
    .dt-btn-utama:hover{background:#4a382b}
    .dt-btn-garis{border:1px solid #6f5846;color:#6f5846;background:#fff}
    .dt-btn-garis:hover{background:#f6efe7}
    .dt-kosong{text-align:center;background:#fff;border:1px solid #ead9c7;border-radius:16px;padding:48px 24px}
    .dt-kosong h1{margin:10px 0 6px}
    @media(max-width:600px){.dt-grid{grid-template-columns:1fr}.dt-atas,.dt-isi{padding:22px}}
</style>

<div class="dt-wrap">

@if ($buku)

    <div class="dt-kartu">
        <div class="dt-atas">
            <span class="dt-kategori">{{ $buku->kategori->nama }}</span>
            <h1>{{ $buku->judul }}</h1>
            <p>Informasi lengkap mengenai buku yang dipilih dari koleksi perpustakaan.</p>
        </div>

        <div class="dt-isi">
            <div class="dt-grid">
                <div class="dt-item">
                    <span>Penulis</span>
                    <strong>{{ $buku->penulis }}</strong>
                </div>
                <div class="dt-item">
                    <span>Tahun Terbit</span>
                    <strong>{{ $buku->tahun_terbit }}</strong>
                </div>
                <div class="dt-item">
                    <span>Kategori</span>
                    <strong>{{ $buku->kategori->nama }}</strong>
                </div>
                <div class="dt-item">
                    <span>ID Buku</span>
                    <strong>{{ $buku->id }}</strong>
                </div>
            </div>

            <div class="dt-aksi">
                <a href="{{ route('components.buku.index') }}" class="dt-btn dt-btn-garis">Kembali ke Daftar Buku</a>
                @can('mengajukan peminjaman buku')
                    <a href="{{ route('peminjaman.form-ajukan') }}" class="dt-btn dt-btn-utama">Ajukan Peminjaman</a>
                @endcan
            </div>
        </div>
    </div>

@else

    <div class="dt-kosong">
        <div style="font-size:40px">🔍</div>
        <h1>Buku Tidak Ditemukan</h1>
        <p>Maaf, data buku yang kamu cari tidak tersedia.</p>
        <a href="{{ route('components.buku.index') }}" class="dt-btn dt-btn-utama">Kembali ke Daftar Buku</a>
    </div>

@endif

</div>

@endsection
