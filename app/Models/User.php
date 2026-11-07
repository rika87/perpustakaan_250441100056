<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'user_id');
    }

    // Profil anggota milik akun ini (tabel anggotas dari Modul 2).
    // Dibuat otomatis bila belum ada, dicocokkan lewat email.
    public function anggotaProfil(): Anggota
    {
        return Anggota::firstOrCreate(
            ['email' => $this->email],
            ['nama' => $this->name, 'no_telepon' => '-']
        );
    }
}