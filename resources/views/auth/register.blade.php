@extends('auth.auth')

@section('judul', 'Buat Akun Baru')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label for="name">Nama</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
        @error('name') <span class="gs-error">{{ $message }}</span> @enderror

        <label for="username">Username</label>
        <input id="username" type="text" name="username" value="{{ old('username') }}" required autocomplete="username">
        @error('username') <span class="gs-error">{{ $message }}</span> @enderror

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
        @error('email') <span class="gs-error">{{ $message }}</span> @enderror

        <label for="password">Kata Sandi</label>
        <input id="password" type="password" name="password" required autocomplete="new-password">
        @error('password') <span class="gs-error">{{ $message }}</span> @enderror

        <label for="password_confirmation">Ulangi Kata Sandi</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
        @error('password_confirmation') <span class="gs-error">{{ $message }}</span> @enderror

        <button type="submit" class="gs-tombol">Daftar</button>
    </form>

    <p class="gs-bawah">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
@endsection