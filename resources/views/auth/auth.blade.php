<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('judul', 'Perpustakaan Digital')</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Figtree', system-ui, sans-serif;
            background: #f6efe7;
            color: #3b2a1a;
        }
        a { text-decoration: none; color: inherit; }

        .gs-header {
            text-align: center;
            color: #fff;
            padding: 38px 16px 32px;
            border-bottom: 3px solid #e9cfa9;
            background:
                radial-gradient(circle at 80% 0%, rgba(233, 207, 169, 0.3), transparent 50%),
                linear-gradient(135deg, #3b2a1a, #6f5846);
        }
        .gs-header h1 { font-size: 30px; font-weight: 700; letter-spacing: 0.5px; }
        .gs-header p { margin-top: 6px; font-size: 14px; color: #f0e2d0; }

        .gs-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 max(16px, calc((100vw - 1100px) / 2));
            background: #fff;
            border-bottom: 1px solid #ead9c7;
            box-shadow: 0 2px 8px rgba(74, 56, 43, 0.06);
        }
        .gs-nav a {
            display: inline-block;
            padding: 14px;
            font-size: 14px;
            font-weight: 600;
            color: #6f5846;
            border-bottom: 3px solid transparent;
        }
        .gs-nav a:hover { color: #3b2a1a; }
        .gs-nav a.aktif { color: #3b2a1a; border-bottom-color: #6f5846; }

        .gs-main { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px 16px; }
        .gs-kartu {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border: 1px solid #ead9c7;
            border-radius: 20px;
            padding: 32px 30px;
            box-shadow: 0 20px 40px -16px rgba(74, 56, 43, 0.25);
        }
        .gs-judul { margin-bottom: 20px; font-size: 22px; font-weight: 700; }

        .gs-kartu label { display: block; margin: 14px 0 6px; font-size: 14px; font-weight: 600; color: #4a382b; }
        .gs-kartu input[type="text"],
        .gs-kartu input[type="email"],
        .gs-kartu input[type="password"] {
            width: 100%;
            padding: 11px 14px;
            font: inherit;
            font-size: 15px;
            border: 1px solid #dcc9b6;
            border-radius: 10px;
            background: #fffdfb;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .gs-kartu input:focus { border-color: #6f5846; box-shadow: 0 0 0 3px rgba(111, 88, 70, 0.22); }

        .gs-error { display: block; margin-top: 5px; font-size: 13px; color: #b42318; }
        .gs-info { margin-bottom: 14px; padding: 10px 14px; border-radius: 10px; font-size: 14px; background: #d1f0d8; color: #0f5132; }

        .gs-baris { display: flex; align-items: center; justify-content: space-between; margin-top: 16px; font-size: 14px; }
        .gs-baris label { display: flex; align-items: center; gap: 8px; margin: 0; font-weight: 500; }
        .gs-baris input[type="checkbox"] { accent-color: #6f5846; width: 16px; height: 16px; }
        .gs-baris a { color: #6f5846; text-decoration: underline; }

        .gs-tombol {
            width: 100%;
            margin-top: 22px;
            padding: 12px;
            font: inherit;
            font-weight: 700;
            font-size: 15px;
            color: #fff;
            background: linear-gradient(135deg, #6f5846, #4a382b);
            border: 0;
            border-radius: 12px;
            cursor: pointer;
            transition: transform 0.15s, filter 0.15s;
        }
        .gs-tombol:hover { transform: translateY(-1px); filter: brightness(1.12); }

        .gs-bawah { margin-top: 18px; text-align: center; font-size: 14px; color: #7a6757; }
        .gs-bawah a { color: #6f5846; font-weight: 700; }

        .gs-footer { text-align: center; padding: 18px; font-size: 13px; color: #e9dccb; background: #4a382b; }
    </style>
</head>
<body>

    <header class="gs-header">
        <h1>Perpustakaan Digital</h1>
        <p>Sistem Informasi Perpustakaan</p>
    </header>

    <nav class="gs-nav">
        <a href="{{ route('home') }}">Beranda</a>
        <div>
            <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'aktif' : '' }}">Masuk</a>
            <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'aktif' : '' }}">Daftar</a>
        </div>
    </nav>

    <main class="gs-main">
        <div class="gs-kartu">
            <h2 class="gs-judul">@yield('judul')</h2>
            @yield('content')
        </div>
    </main>

    <footer class="gs-footer">© 2026 Perpustakaan Digital</footer>

</body>
</html>