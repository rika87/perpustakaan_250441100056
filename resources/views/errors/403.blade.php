@extends('layouts.perpustakaan')

@section('title', 'Akses Ditolak')

@section('content')

<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<section class="page-header">
    <div class="container">
        <h1>403 - AKSES DITOLAK</h1>
        <p>Akun kamu tidak memiliki hak akses untuk membuka halaman atau data ini.</p>
    </div>
</section>

<section class="book-section">
    <div class="container">
        <div class="bk-card">
            <a class="bk-btn" href="{{ url('/') }}">Kembali ke Beranda</a>
        </div>
    </div>
</section>

@endsection