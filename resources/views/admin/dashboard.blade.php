<x-app-layout>
    {{-- Header Halaman --}}
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-[#493526]">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="min-h-screen bg-[#f5eee5] py-8">
        <div class="max-w-7xl mx-auto px-6 sm:px-6 lg:px-8">

            {{-- Selamat Datang --}}
            <div class="bg-white p-7 rounded-xl shadow-sm mb-7">
                <h3 class="text-xl font-bold text-gray-800">
                    Selamat datang, {{ auth()->user()->name }}!
                </h3>

                <p class="mt-2 text-gray-500">
                    Berikut ringkasan informasi perpustakaan digital.
                </p>

                @can('kelola data pengguna')
                    <div class="mt-4 p-3 bg-green-50 text-green-700 rounded-lg text-sm">
                        <i class="bi bi-check-circle me-1"></i>
                        Anda memiliki hak akses untuk
                        <strong>mengelola data pengguna</strong>.
                    </div>
                @endcan
            </div>

            {{-- Statistik Perpustakaan --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">

                {{-- Total Buku --}}
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <p class="text-sm text-gray-500">
                        Total Buku
                    </p>

                    <p class="mt-3 text-4xl font-bold text-blue-600">
                        {{ $totalBuku }}
                    </p>
                </div>

                {{-- Total Pengguna --}}
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <p class="text-sm text-gray-500">
                        Total Pengguna
                    </p>

                    <p class="mt-3 text-4xl font-bold text-green-600">
                        {{ $totalPengguna }}
                    </p>
                </div>

                {{-- Total Peminjaman --}}
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <p class="text-sm text-gray-500">
                        Total Peminjaman
                    </p>

                    <p class="mt-3 text-4xl font-bold text-yellow-500">
                        {{ $totalPeminjaman }}
                    </p>
                </div>

            </div>

            {{-- Menu Admin --}}
            <div>
                <h3 class="text-xl font-bold text-[#493526] mb-4">
                    Menu Administrasi
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                    {{-- Kelola Buku --}}
                    @can('kelola data buku')
                        <a href="{{ route('kelola.buku') }}"
                            class="bg-white p-6 rounded-xl shadow-sm block hover:shadow-md hover:-translate-y-1 transition duration-200">
                            <h4 class="text-lg font-bold text-gray-800">
                                Kelola Buku
                            </h4>

                            <p class="mt-2 text-sm text-gray-500">
                                Tambah, ubah, dan hapus data koleksi buku perpustakaan.
                            </p>
                        </a>
                    @endcan

                    {{-- Pengguna dan Role --}}
                    @can('kelola data pengguna')
                        <a href="{{ route('admin.pengguna.index') }}"
                            class="bg-white p-6 rounded-xl shadow-sm block hover:shadow-md hover:-translate-y-1 transition duration-200">
                            <h4 class="text-lg font-bold text-gray-800">
                                Pengguna dan Role
                            </h4>

                            <p class="mt-2 text-sm text-gray-500">
                                Kelola akun pengguna dan hak akses berdasarkan role.
                            </p>
                        </a>
                    @endcan

                    {{-- Peminjaman --}}
                    @can('kelola peminjaman')
                        <a href="{{ route('peminjaman.index') }}"
                            class="bg-white p-6 rounded-xl shadow-sm block hover:shadow-md hover:-translate-y-1 transition duration-200">
                            <h4 class="text-lg font-bold text-gray-800">
                                Peminjaman
                            </h4>

                            <p class="mt-2 text-sm text-gray-500">
                                Periksa dan kelola pengajuan peminjaman buku.
                            </p>
                        </a>
                    @endcan

                    {{-- Pengembalian --}}
                    @can('kelola pengembalian')
                        <a href="{{ route('pengembalian.index') }}"
                            class="bg-white p-6 rounded-xl shadow-sm block hover:shadow-md hover:-translate-y-1 transition duration-200">
                            <h4 class="text-lg font-bold text-gray-800">
                                Pengembalian
                            </h4>

                            <p class="mt-2 text-sm text-gray-500">
                                Kelola proses pengembalian buku perpustakaan.
                            </p>
                        </a>
                    @endcan

                    {{-- Laporan --}}
                    @can('lihat laporan perpustakaan')
                        <a href="{{ route('laporan.index') }}"
                            class="bg-white p-6 rounded-xl shadow-sm block hover:shadow-md hover:-translate-y-1 transition duration-200">
                            <h4 class="text-lg font-bold text-gray-800">
                                Laporan Perpustakaan
                            </h4>

                            <p class="mt-2 text-sm text-gray-500">
                                Lihat dan pantau laporan aktivitas perpustakaan.
                            </p>
                        </a>
                    @endcan

                </div>
            </div>

        </div>
    </div>
</x-app-layout>