<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bendaharas', function (Blueprint $table) {
            $table->date('tanggal')->nullable()->change();
            $table->decimal('saldo_awal', 15, 2)->after('keterangan');
            $table->decimal('saldo_akhir', 15, 2)->after('pengeluaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bendaharas', function (Blueprint $table) {
            $table->dropColumn(['saldo_awal', 'saldo_akhir']);
        });
    }
};
