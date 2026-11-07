<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();  
// mmriksa
        $request->session()->regenerate();
// perbarui
        $user = Auth::user();
// dt bhsl lgn


        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('petugas')) {
            return redirect()->route('petugas.dashboard');
        }

        if ($user->hasRole('siswa')) {
            return redirect()->route('siswa.dashboard');
        }

        return redirect('/');
    }
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        // Untuk mengeluarkan pengguna dari akun (logout).

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
