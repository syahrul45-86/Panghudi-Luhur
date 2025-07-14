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
            // Memberikan nilai default untuk kolom 'saldo_akhir'
            $table->decimal('saldo_akhir', 15, 2)->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('bendaharas', function (Blueprint $table) {
            // Jika rollback, kembalikan kolom 'saldo_akhir' ke nullable
            $table->decimal('saldo_akhir', 15, 2)->nullable()->change();
        });
    }
};
