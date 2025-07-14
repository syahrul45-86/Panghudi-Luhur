<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('dendas', function (Blueprint $table) {
            $table->timestamp('tanggal')->default(now())->change(); // Default ke waktu sekarang
        });
    }

    public function down()
    {
        Schema::table('dendas', function (Blueprint $table) {
            $table->date('tanggal')->nullable(false)->change();
        });
    }
};
