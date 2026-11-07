<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            // pemilik peminjaman = akun yang sedang login (dipakai untuk "riwayat milik sendiri")
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // alur: diajukan -> dipinjam -> dikembalikan
            $table->string('status', 20)->default('dipinjam');
        });

        // data lama: yang sudah punya tanggal_kembali dianggap sudah dikembalikan
        DB::table('peminjamans')->whereNotNull('tanggal_kembali')->update(['status' => 'dikembalikan']);
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn('status');
        });
    }
};