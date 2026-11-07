@extends('layouts.perpustakaan')

@section('title', 'LAPORAN PERPUSTAKAAN')

@section('content')

<link rel="stylesheet" href="css/style.css">

<section class="page-header">
    <div class="container">
        <h1>LAPORAN PERPUSTAKAAN</h1>
        <p>Ringkasan data perpustakaan.</p>
    </div>
</section>

<section class="book-section">
    <div class="container">

        @include('partials.pesan')

        <div class="bk-card">
            <h3>Ringkasan</h3>
            @foreach ($ringkasan as $label => $nilai)
                <p>{{ $label }}: <strong>{{ $nilai }}</strong></p>
            @endforeach
        </div>

        <div class="bk-card">
            <h3>Jumlah Buku per Kategori</h3>
            <table class="bk-table">
                <thead><tr><th>Kategori</th><th style="width:140px">Jumlah Buku</th></tr></thead>
                <tbody>
                    @forelse ($perKategori as $k)
                        <tr><td>{{ $k->nama }}</td><td>{{ $k->jumlah_buku }}</td></tr>
                    @empty
                        <tr><td colspan="2" class="bk-center">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bk-card">
            <h3>Buku Paling Sering Dipinjam</h3>
            <table class="bk-table">
                <thead><tr><th>Judul</th><th style="width:140px">Dipinjam</th></tr></thead>
                <tbody>
                    @forelse ($terbanyak as $b)
                        <tr><td>{{ $b->judul }}</td><td>{{ $b->jumlah }}</td></tr>
                    @empty
                        <tr><td colspan="2" class="bk-center">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</section>

@endsection