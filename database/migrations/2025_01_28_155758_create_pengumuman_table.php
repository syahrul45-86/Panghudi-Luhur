<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('alamat');
            $table->string('nomor_surat');
            $table->string('perihal');
            $table->string('kepada');
            $table->text('deskripsi');
            $table->string('hari');
            $table->time('waktu');
            $table->string('tempat');
            $table->string('acara');
            $table->string('gambar')->nullable();
            $table->string('ttd_ketua')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
    }
};
