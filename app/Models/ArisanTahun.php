<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArisanTahun extends Model
{
    use HasFactory;
    protected $fillable = ['tahun'];

    public function tanggal()
    {
        return $this->hasMany(ArisanTanggal::class, 'tahun_id');
    }
}
