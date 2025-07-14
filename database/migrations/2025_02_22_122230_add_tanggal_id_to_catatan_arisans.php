<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambahkan kolom 'tanggal_id'.
     */
    public function up()
    {
        Schema::table('catatan_arisans', function (Blueprint $table) {
            $table->foreignId('tanggal_id')->constrained('arisan_tanggals')->onDelete('cascade');
        });
    }

    /**
     * Rollback migrasi untuk menghapus kolom 'tanggal_id' jika dibutuhkan.
     */
    public function down()
    {
        Schema::table('catatan_arisans', function (Blueprint $table) {
            $table->dropForeign(['tanggal_id']);
            $table->dropColumn('tanggal_id');
        });
    }
};
