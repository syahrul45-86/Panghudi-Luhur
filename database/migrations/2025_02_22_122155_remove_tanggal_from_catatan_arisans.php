<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menghapus kolom 'tanggal'.
     */
    public function up()
    {
        Schema::table('catatan_arisans', function (Blueprint $table) {
            $table->dropColumn('tanggal'); // Menghapus kolom tanggal
        });
    }

    /**
     * Rollback migrasi untuk menambahkan kembali kolom 'tanggal' jika dibutuhkan.
     */
    public function down()
    {
        Schema::table('catatan_arisans', function (Blueprint $table) {
            $table->date('tanggal')->nullable();
        });
    }
};
