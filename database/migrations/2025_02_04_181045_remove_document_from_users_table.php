<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDocumentFromUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Menghapus kolom 'document' dari tabel 'users'
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('document');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Jika perlu rollback, kolom 'document' bisa ditambahkan kembali
        Schema::table('users', function (Blueprint $table) {
            $table->string('document')->nullable(); // Atau tipe data yang sesuai dengan kolom 'document'
        });
    }
}
