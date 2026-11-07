@extends('layouts.perpustakaan')

@section('title', 'KELOLA PENGGUNA DAN ROLE')

@section('content')

<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<section class="page-header">
    <div class="container">
        <h1>KELOLA PENGGUNA DAN ROLE</h1>
        <p>Hanya admin yang dapat mengelola akun dan role pengguna.</p>
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
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th style="width:330px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengguna as $i => $u)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->roles->pluck('name')->join(', ') ?: '-' }}</td>
                            <td>
                                @can('kelola role pengguna')
                                    <form method="POST" action="{{ route('admin.pengguna.role', $u) }}" style="display:inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" class="bk-input" style="width:auto">
                                            @foreach ($daftarRole as $r)
                                                <option value="{{ $r }}" @selected($u->hasRole($r))>{{ $r }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="bk-btn bk-btn-ubah">Simpan Role</button>
                                    </form>
                                @endcan
                                @can('kelola data pengguna')
                                    <form method="POST" action="{{ route('admin.pengguna.destroy', $u) }}" style="display:inline"
                                          onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bk-btn bk-btn-hapus">Hapus</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="bk-center">Belum ada pengguna.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</section>

@endsection