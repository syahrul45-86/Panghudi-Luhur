<?php

namespace App\Http\Controllers;

use App\Models\ArisanTahun;
use App\Models\AnggotaArisan;
use App\Models\CatatanArisan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ArisanTanggal;



class ArisanInput extends Controller
{
    public function index()
    {
        $tahuns = ArisanTahun::with('tanggal')->get();
        return view('frontend.instructor-dashboard.catatan_arisan.index', compact('tahuns'));
    }

       // Halaman Tambah Tahun dan Tanggal
       public function create()
       {
           // Ambil semua tahun untuk dropdown di form tambah tanggal
           $tahuns = ArisanTahun::all();

           // Return view dengan data tahun
           return view('frontend.instructor-dashboard.catatan_arisan.create-tahun', compact('tahuns'));
       }

    public function storeTahun(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|unique:arisan_tahuns,tahun'
        ]);

        ArisanTahun::create(['tahun' => $request->tahun]);

        // Simpan pesan ke dalam session
        notyf()->success('Data Berhasil Ditambah!');
        return redirect()->route('instructor.arisan.index');
    }

    public function storeTanggal(Request $request)
    {
        $request->validate([
            'tahun_id' => 'required|exists:arisan_tahuns,id',
            'tanggal' => 'required|date'
        ]);
        ArisanTanggal::create(['tahun_id' => $request->tahun_id, 'tanggal' => $request->tanggal]);
        notyf()->success('Data Berhasil Ditambah!');
        return redirect()->back();
    }


    public function showTahun(Request $request)
{
    $tahun = ArisanTahun::with('tanggal')->findOrFail($request->tahun_id);
   $anggota = User::whereIn('id', function ($query) use ($tahun) {
    $query->select('user_id')
          ->from('anggota_arisans')
          ->where('tahun_id', $tahun->id);
})->get();

$users = User::all(); // Kirim semua user ke view untuk dropdown
 // Mengambil semua anggota dari tabel users

   return view('frontend.instructor-dashboard.catatan_arisan.show-tahun', compact('tahun', 'anggota', 'users'));

}




// public function toggleChecklist(Request $request)
// {
//     $catatan = CatatanArisan::where('user_id', $request->user_id)
//                             ->where('tanggal_id', $request->tanggal_id)
//                             ->first();

//     if ($catatan) {
//         $catatan->delete();
//         notyf()->success('Checklist berhasil dihapus!');
//     } else {
//         CatatanArisan::create([
//             'user_id' => $request->user_id,  // Menggunakan user_id
//             'tanggal_id' => $request->tanggal_id,
//             'sudah_bayar' => true
//         ]);
//         notyf()->success('Pembayaran successfully!');
//     }

//     return redirect()->back();
// }

public function toggleChecklist(Request $request)
{
    $catatan = CatatanArisan::where('user_id', $request->user_id)
                            ->where('tanggal_id', $request->tanggal_id)
                            ->first();

    if ($catatan) {
        $catatan->delete();
        return response()->json(['status' => 'success', 'message' => 'Checklist berhasil dihapus!']);
    } else {
        CatatanArisan::create([
            'user_id' => $request->user_id,
            'tanggal_id' => $request->tanggal_id,
            'sudah_bayar' => true
        ]);
        return response()->json(['status' => 'success', 'message' => 'Pembayaran berhasil dicatat!']);
    }
}

public function deleteTanggal($id)
{
    $tanggal = ArisanTanggal::find($id);

    if (!$tanggal) {
        notyf()->error('Tanggal tidak ditemukan!');
        return redirect()->back();
    }

    $tanggal->delete();
    notyf()->success('Tanggal berhasil dihapus!');
    return redirect()->back();
}

// ✅ Tambah anggota ke arisan
public function addAnggota(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'tahun_id' => 'required|exists:arisan_tahuns,id',
    ]);

    // Cek apakah sudah jadi anggota
    $sudahAda = AnggotaArisan::where('user_id', $request->user_id)
                              ->where('tahun_id', $request->tahun_id)
                              ->exists();

    if ($sudahAda) {
        return back()->with('error', 'Anggota sudah terdaftar dalam arisan ini.');
    }

    AnggotaArisan::create([
        'user_id' => $request->user_id,
        'tahun_id' => $request->tahun_id,
    ]);

    return back()->with('success', 'Anggota berhasil ditambahkan ke arisan.');
}

// ✅ Hapus anggota dari arisan
public function removeAnggota(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'tahun_id' => 'required|exists:arisan_tahuns,id',
    ]);

    // Hapus dari daftar anggota
    AnggotaArisan::where('user_id', $request->user_id)
        ->where('tahun_id', $request->tahun_id)
        ->delete();

    // Opsional: Hapus checklist juga jika ada
    CatatanArisan::where('user_id', $request->user_id)
        ->whereIn('tanggal_id', ArisanTanggal::where('tahun_id', $request->tahun_id)->pluck('id'))
        ->delete();

    return back()->with('success', 'Anggota berhasil dihapus dari arisan.');
}


}



