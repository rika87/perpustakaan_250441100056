<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PenggunaController extends Controller
{
    public function index(): View
    {
        return view('admin.pengguna.index', [
            'pengguna' => User::with('roles')->orderBy('name')->get(),
            'daftarRole' => ['admin', 'petugas', 'siswa'],
        ]);
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(['admin', 'petugas', 'siswa'])],
        ]);

        if ($user->id === auth()->id()) {
            return back()->with('galat', 'Anda tidak dapat mengubah role akun Anda sendiri.');
        }

        $user->syncRoles($data['role']);

        return back()->with('status', "Role {$user->name} diubah menjadi {$data['role']}.");
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('galat', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $nama = $user->name;
        $user->delete();

        return back()->with('status', "Akun {$nama} dihapus.");
    }
}