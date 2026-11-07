

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="dash-hero">
                <h3>{{ $salam }}, {{ auth()->user()->name }}!</h3>
                <p>Login sebagai {{ auth()->user()->getRoleNames()->join(', ') ?: '-' }}.</p>
            </div>

            <div>
                <p class="dash-judul mb-3">Ringkasan Peminjaman</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="dash-stat s-total">
                        <div class="ikon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </div>
                        <div><div class="angka">{{ $jumlahRiwayat }}</div><div class="label">Total Peminjaman</div></div>
                    </div>
                    <div class="dash-stat s-ajuan">
                        <div class="ikon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M7 3h7l5 5v13H7z"/><path d="M14 3v5h5M10 13h6M10 17h6"/></svg>
                        </div>
                        <div><div class="angka">{{ $diajukan }}</div><div class="label">Menunggu Persetujuan</div></div>
                    </div>
                    <div class="dash-stat s-pinjam">
                        <div class="ikon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 6.5C10.5 5.3 8.5 4.7 6 4.7v13c2.5 0 4.5.6 6 1.8 1.5-1.2 3.5-1.8 6-1.8v-13c-2.5 0-4.5.6-6 1.8zM12 6.5v13"/></svg>
                        </div>
                        <div><div class="angka">{{ $dipinjam }}</div><div class="label">Sedang Dipinjam</div></div>
                    </div>
                    <div class="dash-stat s-kembali">
                        <div class="ikon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div><div class="angka">{{ $dikembalikan }}</div><div class="label">Sudah Dikembalikan</div></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>