@extends('layouts.perpustakaan')

@section('title', 'DETAIL PEMINJAMAN')

@section('content')

<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<section class="page-header">
    <div class="container">
        <h1>DETAIL PEMINJAMAN</h1>
        <p>Rincian satu peminjaman.</p>
    </div>
</section>

<section class="book-section">
    <div class="container">

        @include('partials.pesan')

        <div class="bk-card">
            <p>Peminjam: <strong>{{ $p->nama_pengguna ?? '-' }}</strong></p>
            <p>Buku: <strong>{{ $p->judul_buku }}</strong></p>
            <p>Status: <strong>{{ $p->status ?? '-' }}</strong></p>
            <p>Tanggal kembali: <strong>{{ $p->tanggal_kembali ?? '-' }}</strong></p>
            <a class="bk-btn bk-btn-batal" href="{{ route('riwayat.index') }}">Kembali</a>
        </div>

    </div>
</section>

@endsection