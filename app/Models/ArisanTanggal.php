<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArisanTanggal extends Model
{
    use HasFactory;
    protected $fillable = ['tahun_id', 'tanggal'];

    public function tahun()
    {
        return $this->belongsTo(ArisanTahun::class, 'tahun_id');
    }
}
