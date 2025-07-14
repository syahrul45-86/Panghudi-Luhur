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
            Schema::create('arisan_tanggals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tahun_id')->constrained('arisan_tahuns')->onDelete('cascade');
                $table->date('tanggal');
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('arisan_tanggals');
        }
    };

