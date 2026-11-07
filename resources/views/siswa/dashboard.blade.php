<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-[#493526]">
            Dashboard Siswa
        </h2>
    </x-slot>

    <div class="min-h-screen bg-[#f5eee5] py-8">
        <div class="max-w-7xl mx-auto px-6 sm:px-6 lg:px-8">

            <div class="bg-white p-7 rounded-xl shadow-sm mb-7">
                <h3 class="text-xl font-bold text-gray-800">
                    Selamat datang, {{ auth()->user()->name }}!
                </h3>

                <p class="mt-2 text-gray-500">
                    Berikut ringkasan peminjaman bukumu.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-7">

                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <p class="text-sm text-gray-500">
                        Total Peminjaman
                    </p>
                    <p class="mt-3 text-4xl font-bold text-gray-900">
                        {{ $jumlahRiwayat }}
                    </p>
                </div>

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

                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <p class="text-sm text-gray-500">
                        Sudah Dikembalikan
                    </p>
                    <p class="mt-3 text-4xl font-bold text-green-600">
                        {{ $dikembalikan }}
                    </p>
                </div>

            </div>

            <div>
                <h3 class="text-xl font-bold text-[#493526] mb-4">
                    Menu Siswa
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    @can('lihat daftar buku')
                        <a href="{{ route('components.buku.index') }}"
                            class="bg-white p-6 rounded-xl shadow-sm block hover:shadow-md hover:-translate-y-1 transition duration-200">
                            <h4 class="font-bold text-gray-800 text-lg">
                                Daftar Buku
                            </h4>
                            <p class="mt-2 text-sm text-gray-500">
                                Lihat koleksi buku perpustakaan.
                            </p>
                        </a>
                    @endcan

                    @can('mengajukan peminjaman buku')
                        <a href="{{ route('peminjaman.form-ajukan') }}"
                            class="bg-white p-6 rounded-xl shadow-sm block hover:shadow-md hover:-translate-y-1 transition duration-200">
                            <h4 class="font-bold text-gray-800 text-lg">
                                Ajukan Peminjaman
                            </h4>
                            <p class="mt-2 text-sm text-gray-500">
                                Ajukan peminjaman buku yang kamu butuhkan.
                            </p>
                        </a>
                    @endcan

                    @can('melihat riwayat peminjaman sendiri')
                        <a href="{{ route('riwayat.index') }}"
                            class="bg-white p-6 rounded-xl shadow-sm block hover:shadow-md hover:-translate-y-1 transition duration-200">
                            <h4 class="font-bold text-gray-800 text-lg">
                                Riwayat Saya
                            </h4>
                            <p class="mt-2 text-sm text-gray-500">
                                Pantau status peminjamanmu.
                            </p>
                        </a>
                    @endcan

                    @can('lihat profil sendiri')
                        <a href="{{ route('profile.edit') }}"
                            class="bg-white p-6 rounded-xl shadow-sm block hover:shadow-md hover:-translate-y-1 transition duration-200">
                            <h4 class="font-bold text-gray-800 text-lg">
                                Profil Saya
                            </h4>
                            <p class="mt-2 text-sm text-gray-500">
                                Lihat dan ubah data akunmu.
                            </p>
                        </a>
                    @endcan

                </div>
            </div>

        </div>
    </div>
</x-app-layout>