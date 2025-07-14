<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Barryvdh\DomPDF\Facade\Pdf;

class PengumumanAnggotaController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::latest()->paginate(10); // ambil data pengumuman terbaru dengan pagination
        return view('frontend..pengumuman-anggota.index', compact('pengumuman'));
    }

public function cetak($id)
{
    $pengumuman = Pengumuman::findOrFail($id);
 $pdf = PDF::loadView('frontend..pengumuman-anggota.cetak',compact('pengumuman'));

    return $pdf->stream('pengumuman_'.$pengumuman->id.'.pdf');
}
}
