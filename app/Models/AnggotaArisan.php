<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaArisan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',  // Tambahkan ini
        'tahun_id', // Tambahkan ini juga
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tahun()
    {
        return $this->belongsTo(ArisanTahun::class, 'tahun_id');
    }
}
