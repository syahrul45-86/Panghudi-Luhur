<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bendahara extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan plural dari nama model
    protected $table = 'bendaharas'; // Nama tabel di database

    // Tentukan kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'tanggal',
        'keterangan',
        'saldo_awal',
        'pemasukan',
        'pengeluaran',
        'saldo_akhir'
    ];

    // Jika Anda ingin menambahkan relasi, contoh:
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
