<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    use HasFactory;

    protected $table = 'dendas'; // Sesuaikan dengan nama tabel

    protected $fillable = [
        'user_id',
        'keterangan',
        'jumlah',
        'tanggal',
        'status',
    ];

    // Relasi ke User (anggota)
    public function anggota()
    {
        return $this->belongsTo(User::class, 'user_id'); // Sesuaikan dengan foreign key
    }
}

