<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Perpustakaan Digital</title>

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Figtree', sans-serif;
            background: #f6efe7;
            color: #3b2a1a;
        }

        .ap-header {
            width: 100%;
            background: linear-gradient(135deg, #3b2a1a, #6f5846);
            border-bottom: 3px solid #e9cfa9;
        }

        .ap-navbar {
            max-width: 1500px;
            margin: auto;
            padding: 12px 35px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .ap-logo {
            color: #fff;
            font-size: 23px;
            font-weight: 800;
            text-decoration: none;
            white-space: nowrap;
        }

        .ap-logo:hover {
            color: #e9cfa9;
        }

        .ap-menu {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 3px;
        }

        .ap-menu a {
            display: inline-block;
            padding: 10px 11px;
            color: #f5eadd;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.2s;
            white-space: nowrap;
        }

        .ap-menu a:hover {
            background: rgba(255,255,255,0.13);
            color: #fff;
        }

        .ap-menu a.aktif {
            background: rgba(255,255,255,0.17);
            color: #fff;
        }

        .ap-user {
            display: flex;
            align-items: center;
            gap: 12px;
            white-space: nowrap;
            font-size: 13px;
        }

        .ap-user .nama {
            color: #fff;
            font-weight: 700;
        }

        .ap-peran {
            background: #ead9c7;
            color: #493526;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .ap-user a {
            color: #f5eadd;
            text-decoration: none;
            font-weight: 600;
        }

        .ap-user a:hover {
            color: #fff;
            text-decoration: underline;
        }

        .ap-logout {
            background: #f5eadd;
            color: #493526;
            padding: 9px 15px;
            border: none;
            border-radius: 7px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }

        .ap-logout:hover {
            background: #e9cfa9;
        }

        .ap-judul {
            max-width: 1280px;
            margin: auto;
            padding: 24px 32px 0;
        }

        .ap-judul h2 {
            font-size: 24px;
            font-weight: 700;
            color: #3b2a1a;
        }

        .ap-main {
            min-height: 65vh;
        }

        .ap-footer {
            background: #4a382b;
            color: #e9dccb;
            text-align: center;
            padding: 18px;
            font-size: 13px;
            margin-top: auto;
        }

        /* RESPONSIVE */
        @media (max-width: 1100px) {
            .ap-navbar {
                flex-wrap: wrap;
                justify-content: center;
                padding: 15px 20px;
            }

            .ap-menu {
                justify-content: center;
            }

            .ap-user {
                justify-content: center;
                flex-wrap: wrap;
            }
        }

        @media (max-width: 640px) {
            .ap-navbar {
                padding: 15px;
                gap: 12px;
            }

            .ap-logo {
                width: 100%;
                text-align: center;
            }

            .ap-menu {
                width: 100%;
            }

            .ap-menu a {
                padding: 8px;
                font-size: 12px;
            }

            .ap-user {
                width: 100%;
                gap: 10px;
            }

            .ap-judul {
                padding: 20px 18px 0;
            }
        }
    </style>
</head>

<body class="antialiased">

    <header class="ap-header">
        <div class="ap-navbar">

            <a href="{{ route('home') }}" class="ap-logo">
                📚 Perpustakaan
            </a>

            <nav class="ap-menu">

                <a href="{{ route('home') }}"
                   class="{{ request()->routeIs('home') ? 'aktif' : '' }}">
                    Beranda
                </a>

                @role('admin')
                    <a href="{{ route('admin.dashboard') }}"
                       class="{{ request()->routeIs('admin.dashboard') ? 'aktif' : '' }}">
                        Dashboard Admin
                    </a>
                @endrole

                @role('petugas')
                    <a href="{{ route('petugas.dashboard') }}"
                       class="{{ request()->routeIs('petugas.dashboard') ? 'aktif' : '' }}">
                        Dashboard Petugas
                    </a>
                @endrole

                @role('siswa')
                    <a href="{{ route('siswa.dashboard') }}"
                       class="{{ request()->routeIs('siswa.dashboard', 'dashboard') ? 'aktif' : '' }}">
                        Dashboard
                    </a>
                @endrole

                @can('lihat daftar buku')
                    <a href="{{ route('components.buku.index') }}"
                       class="{{ request()->routeIs('components.buku.*') ? 'aktif' : '' }}">
                        Daftar Buku
                    </a>
                @endcan

                @can('kelola data buku')
                    <a href="{{ route('kelola.buku') }}"
                       class="{{ request()->routeIs('kelola.buku') ? 'aktif' : '' }}">
                        Kelola Buku
                    </a>
                @endcan

                @can('kelola data pengguna')
                    <a href="{{ route('admin.pengguna.index') }}"
                       class="{{ request()->routeIs('admin.pengguna.*') ? 'aktif' : '' }}">
                        Pengguna
                    </a>
                @endcan

                @can('kelola peminjaman')
                    <a href="{{ route('peminjaman.index') }}"
                       class="{{ request()->routeIs('peminjaman.index') ? 'aktif' : '' }}">
                        Peminjaman
                    </a>
                @endcan

                @can('kelola pengembalian')
                    <a href="{{ route('pengembalian.index') }}"
                       class="{{ request()->routeIs('pengembalian.index') ? 'aktif' : '' }}">
                        Pengembalian
                    </a>
                @endcan

                @can('lihat laporan perpustakaan')
                    <a href="{{ route('laporan.index') }}"
                       class="{{ request()->routeIs('laporan.index') ? 'aktif' : '' }}">
                        Laporan
                    </a>
                @endcan

                @can('mengajukan peminjaman buku')
                    <a href="{{ route('peminjaman.form-ajukan') }}"
                       class="{{ request()->routeIs('peminjaman.form-ajukan') ? 'aktif' : '' }}">
                        Ajukan Pinjam
                    </a>
                @endcan

                @can('melihat riwayat peminjaman sendiri')
                    <a href="{{ route('riwayat.index') }}"
                       class="{{ request()->routeIs('riwayat.*') ? 'aktif' : '' }}">
                        Riwayat
                    </a>
                @endcan

            </nav>

            @auth
                <div class="ap-user">

                    <span class="nama">
                        {{ auth()->user()->name }}
                    </span>

                    <span class="ap-peran">
                        {{ auth()->user()->getRoleNames()->first() ?: 'Pengguna' }}
                    </span>

                    @can('lihat profil sendiri')
                        <a href="{{ route('profile.edit') }}">
                            Profil
                        </a>
                    @endcan

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="ap-logout">
                            Keluar
                        </button>
                    </form>

                </div>
            @endauth

            @guest
                <div class="ap-user">
                    <a href="{{ route('login') }}">Masuk</a>
                    <a href="{{ route('register') }}">Daftar</a>
                </div>
            @endguest

        </div>
    </header>

    @isset($header)
        <div class="ap-judul">
            {{ $header }}
        </div>
    @endisset

    <main class="ap-main">
        {{ $slot }}
    </main>

    <footer class="ap-footer">
        © 2026 Perpustakaan Digital. All Rights Reserved.
    </footer>

</body>
</html>