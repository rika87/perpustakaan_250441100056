@php
    $user = auth()->user();
    $jam = now('Asia/Jakarta')->hour;
    $salam = $jam < 11 ? 'Selamat pagi' : ($jam < 15 ? 'Selamat siang' : ($jam < 18 ? 'Selamat sore' : 'Selamat malam'));
    $tanggal = \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y');

    $ikon = [
        'total'    => 'M4 6h16M4 12h16M4 18h16',
        'dokumen'  => 'M7 3h7l5 5v13H7zM14 3v5h5M10 13h6M10 17h6',
        'buku'     => 'M12 6.5C10.5 5.3 8.5 4.7 6 4.7v13c2.5 0 4.5.6 6 1.8 1.5-1.2 3.5-1.8 6-1.8v-13c-2.5 0-4.5.6-6 1.8zM12 6.5v13',
        'cek'      => 'M5 13l4 4L19 7',
        'pengguna' => 'M12 12a4 4 0 100-8 4 4 0 000 8zM4 20c0-4 4-6 8-6s8 2 8 6',
    ];

    $stats = $stats ?? [];
    $judulStat = $judulStat ?? 'Ringkasan';
    $cta = $cta ?? null;
    $kolom = count($stats) === 3 ? 'lg:grid-cols-3' : 'lg:grid-cols-4';

    $terakhir = \Illuminate\Support\Facades\DB::table('peminjamans')
        ->join('bukus', 'bukus.id', '=', 'peminjamans.buku_id')
        ->where('peminjamans.user_id', $user->id)
        ->orderByDesc('peminjamans.id')
        ->limit(5)
        ->get(['bukus.judul', 'peminjamans.tanggal_pinjam', 'peminjamans.status']);
@endphp

<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

        <div class="md-hero">
            <div class="md-kiri">
                <div class="md-avatar">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</div>
                <div>
                    <h3>{{ $salam }}, {{ $user->name }}!</h3>
                    <div class="md-meta">
                        <span class="md-badge">{{ $user->getRoleNames()->first() ?: 'pengguna' }}</span>
                        <span>{{ $tanggal }}</span>
                    </div>
                </div>
            </div>
            @if($cta)
                <a href="{{ route($cta[1]) }}" class="md-cta">{{ $cta[0] }}</a>
            @endif
        </div>

        <div>
            <p class="md-judul">{{ $judulStat }}</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 {{ $kolom }} gap-4">
                @foreach($stats as $s)
                    <div class="md-stat {{ $s[2] }}">
                        <div class="chip">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $ikon[$s[3]] }}"/></svg>
                        </div>
                        <div class="nilai">{{ $s[1] }}</div>
                        <div class="label">{{ $s[0] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        @if($terakhir->isNotEmpty())
            <div>
                <p class="md-judul">Peminjaman Terakhir</p>
                <div class="md-tabel-bungkus">
                    <table class="md-tabel">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($terakhir as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->judul }}</td>
                                    <td>{{ $p->tanggal_pinjam }}</td>
                                    <td><span class="md-status st-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</div>