<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari nama model (misalnya jika tabelnya bernama 'pengumuman')
    protected $table = 'pengumuman';

    // Tentukan kolom yang bisa diisi massal
    protected $fillable = [
        'judul',
        'alamat',
        'nomor_surat',
        'perihal',
        'kepada',
        'deskripsi',
        'hari',
        'waktu',
        'tempat',
        'acara',
        'gambar',
        'ttd_ketua',
    ];

    public $timestamps = true;

    public function getGambarUrlAttribute()
    {
        // Mengembalikan URL gambar yang disimpan di public/uploads
        return url('uploads/' . $this->gambar); // Mengakses gambar langsung dari public/uploads
    }
}
