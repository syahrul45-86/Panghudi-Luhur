<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanArisan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'tanggal_id', 'sudah_bayar'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function tanggal()
    {
        return $this->belongsTo(ArisanTanggal::class, 'tanggal_id');
    }
}

