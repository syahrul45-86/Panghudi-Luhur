<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom sementara
            $table->string('role_temp')->nullable();
        });

        // Update data role lama ke role baru
        DB::table('users')->update([
            'role_temp' => DB::raw("CASE
                WHEN role = 'instructor' THEN 'bendahara'
                WHEN role = 'students' THEN 'anggota'
                ELSE 'anggota' -- Jika ada nilai lain, jadikan default 'anggota'
            END")
        ]);

        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom role lama
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            // Buat ulang kolom role dengan ENUM baru
            $table->enum('role', ['bendahara', 'anggota'])->after('role_temp');
        });

        // Pindahkan data dari role_temp ke role
        DB::table('users')->update([
            'role' => DB::raw('role_temp')
        ]);

        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom sementara
            $table->dropColumn('role_temp');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom role lama kembali
            $table->enum('role', ['instructor', 'students'])->nullable();
        });

        // Kembalikan data role lama
        DB::table('users')->update([
            'role' => DB::raw("CASE
                WHEN role = 'bendahara' THEN 'instructor'
                WHEN role = 'anggota' THEN 'students'
                ELSE 'students'
            END")
        ]);
    }
};

