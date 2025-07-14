<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('bendaharas', function (Blueprint $table) {
            // Menjadikan kolom 'keterangan' nullable
            $table->string('keterangan')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('bendaharas', function (Blueprint $table) {
            // Jika rollback, kembalikan kolom 'keterangan' menjadi tidak nullable
            $table->string('keterangan')->nullable(false)->change();
        });
    }
};
