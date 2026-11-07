<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Perpustakaan Digital')</title>

@vite(['resources/css/app.css', 'resources/css/perpustakaan.css'])

<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <header class="header">
        <div class="container navbar">

            <a href="{{ route('home') }}" class="logo">
                Perpustakaan
            </a>

            <nav class="nav-menu">
                <a href="{{ route('home') }}">Beranda</a>

<!-- Untuk menampilkan menu jika pengguna sudah login. -->

                @auth
                    @can('lihat daftar buku')
                        <a href="{{ route('components.buku.index') }}">Daftar Buku</a>
                    @endcan

                    @can('akses dashboard admin')
                        <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                    @endcan
                    @can('akses dashboard petugas')
                        <a href="{{ route('petugas.dashboard') }}">Dashboard Petugas</a>
                    @endcan
                    @role('siswa')
                        <a href="{{ route('siswa.dashboard') }}">Dashboard</a>
                    @endrole

                    @can('kelola-buku')
                        <a href="{{ route('kelola.buku') }}">Kelola Buku</a>
                    @endcan
                    @can('kelola data pengguna')
                        <a href="{{ route('admin.pengguna.index') }}">Pengguna</a>
                    @endcan
                    @can('kelola peminjaman')
                        <a href="{{ route('peminjaman.index') }}">Peminjaman</a>
                    @endcan
                    @can('kelola pengembalian')
                        <a href="{{ route('pengembalian.index') }}">Pengembalian</a>
                    @endcan
                    @can('lihat laporan perpustakaan')
                        <a href="{{ route('laporan.index') }}">Laporan</a>
                    @endcan
                    @can('mengajukan peminjaman buku')
                        <a href="{{ route('peminjaman.form-ajukan') }}">Ajukan Pinjam</a>
                    @endcan
                    @can('melihat riwayat peminjaman sendiri')
                        <a href="{{ route('riwayat.index') }}">Riwayat</a>
                    @endcan
                    @can('lihat profil sendiri')
                        <a href="{{ route('profile.edit') }}">Profil</a>
                    @endcan

                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button type="submit" class="bk-btn bk-btn-batal">Keluar ({{ auth()->user()->name }})</button>
                    </form>
                @endauth

<!-- untuk menampilkan menu masuk -->
 
                @guest
                    <a href="{{ route('login') }}">Masuk</a>
                    <a href="{{ route('register') }}">Daftar</a>
                @endguest
            </nav>

        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <center>
            <p>© 2026 Perpustakaan Digital</p>
            </center>
        </div>
    </footer>

</body>
</html>