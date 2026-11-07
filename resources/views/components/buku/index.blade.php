@extends('layouts.perpustakaan')

@section('title', 'Daftar Buku')

@section('content')

<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css">

<section class="page-header">
    <div class="container">

        <h1>DAFTAR BUKU</h1>

        <p>
            Temukan koleksi buku yang tersedia di perpustakaan ini.
    Pilih berbagai buku menarik untuk menemani belajar dan menambah wawasanmu.
        </p>

    </div>
</section>

<section class="book-section">
    <div class="container">

        <div id="alert-area"></div>

        @can('kelola data buku')
        <div class="bk-card">
            <h3 id="judul-form">Tambah Buku</h3>

            <form id="form-buku" class="bk-form" novalidate>
                <input type="hidden" id="buku-id">

                <div class="bk-field">
                    <label for="buku-kategori_id">Kategori</label>
                    <select id="buku-kategori_id" class="bk-input">
                        <option value="">-- Pilih kategori --</option>
                    </select>
                    <small class="bk-error" id="err-kategori_id"></small>
                </div>

                <div class="bk-field">
                    <label for="buku-judul">Judul</label>
                    <input type="text" id="buku-judul" class="bk-input" placeholder="Judul buku">
                    <small class="bk-error" id="err-judul"></small>
                </div>

                <div class="bk-field">
                    <label for="buku-penulis">Penulis</label>
                    <input type="text" id="buku-penulis" class="bk-input" placeholder="Nama penulis">
                    <small class="bk-error" id="err-penulis"></small>
                </div>

                <div class="bk-field">
                    <label for="buku-tahun_terbit">Tahun terbit</label>
                    <input type="number" id="buku-tahun_terbit" class="bk-input" placeholder="Contoh: 2024">
                    <small class="bk-error" id="err-tahun_terbit"></small>
                </div>

                <div class="bk-actions">
                    <button type="submit" id="btn-simpan" class="bk-btn">Simpan</button>
                    <button type="button" id="btn-batal" class="bk-btn bk-btn-batal">Batal</button>
                </div>
            </form>
        </div>
        @endcan

        <div class="bk-card">
            <table class="bk-table">
                <thead>
                    <tr>
                        <th style="width:60px">No</th>
                        <th>Kategori</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th style="width:120px">Tahun Terbit</th>
                        <th style="width:230px">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody-buku">
                    <tr><td colspan="6" class="bk-center">Memuat data...</td></tr>
                </tbody>
            </table>

            <div class="bk-nav">
                <button type="button" id="btn-prev" class="bk-btn bk-btn-batal">&laquo; Sebelumnya</button>
                <button type="button" id="btn-next" class="bk-btn bk-btn-batal">Berikutnya &raquo;</button>
                <span id="info-halaman"></span>
            </div>
        </div>

        @if (session('status'))
            <div class="bk-alert bk-success" role="alert">{{ session('status') }}</div>
        @endif

        <div class="bk-card">
            <h3>Buku Terbaru (dirender Blade)</h3>
            <table class="bk-table">
                <thead>
                    <tr>
                        <th style="width:60px">No</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th style="width:120px">Tahun</th>
                        <th style="width:220px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bukuServer as $i => $b)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            {{-- RENTAN (Soal 1): <td>{!! $b->judul !!}</td> --}}
                            <td>{{ $b->judul }}</td>
                            <td>{{ $b->penulis }}</td>
                            <td>{{ $b->tahun_terbit }}</td>
                            <td>
                                <a class="bk-btn bk-btn-detail" href="{{ route('components.buku.show', $b->id) }}">Detail</a>

                                <form action="{{ route('buku.destroy', $b->id) }}" method="POST"
                                      style="display:inline"
                                      onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bk-btn bk-btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</section>

<script>
    window.BISA_KELOLA = @json(auth()->user()?->can('kelola data buku') ?? false);
</script>
<script src="{{ asset('js/buku-client.js') }}"></script>

@endsection