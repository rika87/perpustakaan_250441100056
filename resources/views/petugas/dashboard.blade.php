<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-[#493526]">
            Dashboard Petugas
        </h2>
    </x-slot>

    <div class="min-h-screen bg-[#f5eee5] py-8">
        <div class="max-w-7xl mx-auto px-6 sm:px-6 lg:px-8">

            <div class="bg-white p-7 rounded-xl shadow-sm mb-7">
                <h3 class="text-xl font-bold text-gray-800">
                    Selamat datang, {{ auth()->user()->name }}!
                </h3>

                <p class="mt-2 text-gray-500">
                    Berikut ringkasan aktivitas pelayanan perpustakaan.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">

                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <p class="text-sm text-gray-500">
                        Menunggu Persetujuan
                    </p>

                    <p class="mt-3 text-4xl font-bold text-yellow-500">
                        {{ $diajukan }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <p class="text-sm text-gray-500">
                        Sedang Dipinjam
                    </p>

                    <p class="mt-3 text-4xl font-bold text-blue-600">
                        {{ $dipinjam }}
                    </p>
                </div>

            </div>

            <div>
                <h3 class="text-xl font-bold text-[#493526] mb-4">
                    Menu Petugas
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    @can('kelola data buku')
                        <a href="{{ route('kelola.buku') }}"
                            class="bg-white p-6 rounded-xl shadow-sm block hover:shadow-md hover:-translate-y-1 transition duration-200">
                            <h4 class="text-lg font-bold text-gray-800">
                                Kelola Buku
                            </h4>

                            <p class="mt-2 text-sm text-gray-500">
                                Tambah, ubah, dan kelola koleksi buku perpustakaan.
                            </p>
                        </a>
                    @endcan

                    @can('kelola peminjaman')
                        <a href="{{ route('peminjaman.index') }}"
                            class="bg-white p-6 rounded-xl shadow-sm block hover:shadow-md hover:-translate-y-1 transition duration-200">
                            <h4 class="text-lg font-bold text-gray-800">
                                Peminjaman
                            </h4>

                            <p class="mt-2 text-sm text-gray-500">
                                Periksa dan proses pengajuan peminjaman buku.
                            </p>
                        </a>
                    @endcan

                    @can('kelola pengembalian')
                        <a href="{{ route('pengembalian.index') }}"
                            class="bg-white p-6 rounded-xl shadow-sm block hover:shadow-md hover:-translate-y-1 transition duration-200">
                            <h4 class="text-lg font-bold text-gray-800">
                                Pengembalian
                            </h4>

                            <p class="mt-2 text-sm text-gray-500">
                                Kelola proses pengembalian buku dari siswa.
                            </p>
                        </a>
                    @endcan

                    @can('lihat laporan perpustakaan')
                        <a href="{{ route('laporan.index') }}"
                            class="bg-white p-6 rounded-xl shadow-sm block hover:shadow-md hover:-translate-y-1 transition duration-200">
                            <h4 class="text-lg font-bold text-gray-800">
                                Laporan Perpustakaan
                            </h4>

                            <p class="mt-2 text-sm text-gray-500">
                                Lihat laporan aktivitas perpustakaan.
                            </p>
                        </a>
                    @endcan

                </div>
            </div>

        </div>
    </div>
</x-app-layout>