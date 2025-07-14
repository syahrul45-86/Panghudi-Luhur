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
        Schema::table('arisan_tahuns', function (Blueprint $table) {
            $table->integer('tahun')->unique()->after('id'); // Tambahkan kolom tahun
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arisan_tahuns', function (Blueprint $table) {
            //
        });
    }
};
