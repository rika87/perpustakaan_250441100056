@extends('layouts.perpustakaan')

@section('title', 'Beranda')

@section('content')

<section class="hero">
    <div class="container hero-content">

        <div class="hero-text">
            <span class="badge">PERPUSTAKAAN DIGITAL</span>

            <h1>
                Temukan Buku Favoritmu
            </h1>

            <p>
                Jelajahi berbagai koleksi buku untuk menambah
                pengetahuan dan mendukung proses belajar.
            </p>

            <a href="{{ route('components.buku.index') }}" class="btn">
                Lihat Daftar Buku 
            </a>
        </div>

        <div class="hero-icon">
            <img src="/foto/buku.jpg" alt=" foto buku" width="100"  >
        </div>

    </div>
</section>

<section class="home-section">
    <div class="container">

        <div class="section-heading">
            
            <h2>Perpustakaan untuk Semua</h2>
            <p>
                Temukan berbagai buku yang dapat membantu
                perjalanan belajar kamu.
            </p>
        </div>

        <div class="feature-grid">

            <div class="feature-card">
                <div class="feature-icon"><img src="/foto/buku.jpg" alt="buku" height="100" width="200"></div>
                <h3>Jelajahi Kategori</h3>
                <p>
                    Temukan
                     ribuan koleksi buku mulai dari sains, sastra, hingga pengembangan diri.
                </p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon"><img src="/foto/foto4.jpg" alt="buku" height="100" width="200"></div>
                <h3>Asah Wawasan</h3>
                <p>
                     Jadikan membaca sebagai kebiasaan untuk memperluas cakrawala berpikir Anda
                </p>
            </div>
            

        

            <div class="feature-card">
                <div class="feature-icon"><img src="/foto/buku3.jpg" alt="buku" height="100" width="200"></div>
                <h3>Tambah Pengetahuan</h3>
                <p>
                    Gunakan koleksi buku sebagai sumber
                    untuk belajar dan berkembang.
                </p>
            </div>

        </div>

    </div>
</section>

@endsection