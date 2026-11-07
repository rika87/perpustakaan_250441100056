@extends('layouts.perpustakaan')

@section('title', 'DATA PENGEMBALIAN')

@section('content')

<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<section class="page-header">
    <div class="container">
        <h1>DATA PENGEMBALIAN</h1>
        <p>Catat buku yang sudah dikembalikan.</p>
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
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Status</th>
                        <th>Tanggal Kembali</th>
                        <th style="width:160px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $p->nama_pengguna ?? '-' }}</td>
                            <td>{{ $p->judul_buku }}</td>
                            <td>{{ $p->status ?? '-' }}</td>
                            <td>{{ $p->tanggal_kembali ?? '-' }}</td>
                            <td>
                                @if (($p->status ?? '') === 'dipinjam')
                                    @can('mencatat pengembalian buku')
                                        <form method="POST" action="{{ route('pengembalian.catat', $p->id) }}" style="display:inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bk-btn">Catat Kembali</button>
                                        </form>
                                    @endcan
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="bk-center">Belum ada data pengembalian.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</section>

@endsection