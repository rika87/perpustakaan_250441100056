@extends('auth.auth')
@section('judul', 'Masuk ke Akun')

@section('content')
    @if (session('status'))
        <div class="gs-info">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
        @error('email') <span class="gs-error">{{ $message }}</span> @enderror

        <label for="password">Kata Sandi</label>
        <input id="password" type="password" name="password" required autocomplete="current-password">
        @error('password') <span class="gs-error">{{ $message }}</span> @enderror

        <div class="gs-baris">
            <label for="remember_me">
                <input id="remember_me" type="checkbox" name="remember">
                Ingat saya
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Lupa kata sandi?</a>
            @endif
        </div>

        <button type="submit" class="gs-tombol">Masuk</button>
    </form>

    <p class="gs-bawah">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
@endsection