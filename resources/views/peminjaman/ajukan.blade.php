@extends('layouts.perpustakaan')

@section('title', 'AJUKAN PEMINJAMAN')

@section('content')

<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<section class="page-header">
    <div class="container">
        <h1>AJUKAN PEMINJAMAN</h1>
        <p>Pilih buku yang ingin kamu pinjam.</p>
    </div>
</section>

<section class="book-section">
    <div class="container">

        @include('partials.pesan')

        <div class="bk-card">
            <form method="POST" action="{{ route('peminjaman.ajukan') }}" class="bk-form">
                @csrf
                <div class="bk-field">
                    <label for="buku_id">Buku</label>
                    <select name="buku_id" id="buku_id" class="bk-input">
                        <option value="">-- Pilih buku --</option>
                        @foreach ($buku as $b)
                            <option value="{{ $b->id }}" @selected(old('buku_id') == $b->id)>{{ $b->judul }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="bk-actions">
                    <button type="submit" class="bk-btn">Ajukan</button>
                </div>
            </form>
        </div>

    </div>
</section>

@endsection