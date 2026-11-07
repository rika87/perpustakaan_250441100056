@extends('layouts.perpustakaan')

@section('title', 'DATA PEMINJAMAN')

@section('content')
<style>
    .bk-table th:last-child { width: 300px !important; }
    .bk-table td:last-child { white-space: nowrap; }
    .bk-table td:last-child form,
    .bk-table td:last-child a {
        display: inline-block;
        margin-right: 6px;
        vertical-align: middle;
    }
</style>

<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<section class="page-header">
    <div class="container">
        <h1>DATA PEMINJAMAN</h1>
        <p>Setujui pengajuan peminjaman yang masuk.</p>
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
                            <td>
                                @if (($p->status ?? '') === 'diajukan')
                                    @can('memproses persetujuan peminjaman')
                                        <form method="POST" action="{{ route('peminjaman.proses', $p->id) }}" style="display:inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bk-btn">Setujui</button>
                                        </form>

                                            <form method="POST" action="{{ route('peminjaman.tolak', $p->id) }}" style="display:inline" onsubmit="return confirm('Yakin menolak pengajuan ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bk-btn bk-btn-hapus">Tolak</button>
                                        </form>
                                    @endcan
                                @else
                                    -
                                @endif
                                <a class="bk-btn bk-btn-detail" href="{{ route('riwayat.show', $p->id) }}">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="bk-center">Belum ada data peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</section>

@endsection