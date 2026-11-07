@extends('layouts.perpustakaan')

@section('title', 'RIWAYAT PEMINJAMAN SAYA')

@section('content')

<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<section class="page-header">
    <div class="container">
        <h1>RIWAYAT PEMINJAMAN SAYA</h1>
        <p>Hanya menampilkan peminjaman milik akunmu sendiri.</p>
    </div>
</section>

<section class="book-section">
    <div class="container">

        @include('partials.pesan')

        <div class="bk-card">
            <table class="bk-table">
                <thead>
                    <tr>
                        <th style="width:60px">No</th>
                        <th>Buku</th>
                        <th>Status</th>
                        <th>Tanggal Kembali</th>
                        <th style="width:100px">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $p->judul_buku }}</td>
                            <td>{{ $p->status ?? '-' }}</td>
                            <td>{{ $p->tanggal_kembali ?? '-' }}</td>
                            <td><a class="bk-btn bk-btn-detail" href="{{ route('riwayat.show', $p->id) }}">Lihat</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="bk-center">Belum ada riwayat peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</section>

@endsection