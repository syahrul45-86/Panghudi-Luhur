<?php

namespace App\Http\Controllers;

use App\Models\Bendahara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class BendaharaController extends Controller
{
    public function index()
    {
        $bendaharas = Bendahara::all();
        return view('frontend.instructor-dashboard.course.index', compact('bendaharas'));
    }

    public function create()
    {
        // Ambil saldo awal terakhir dari tabel
        $saldo_awal = Bendahara::latest()->value('saldo_awal');

        // Jika saldo awal belum diisi, tampilkan form untuk input saldo awal
        if ($saldo_awal === null) {
            return view('frontend.instructor-dashboard.course.create', ['saldo_awal' => null]);
        }

        // Jika saldo awal sudah diisi, tampilkan form untuk input keuangan
        return view('frontend.instructor-dashboard.course.create', ['saldo_awal' => $saldo_awal]);
    }


public function editSaldoAwal()
{
    // Ambil saldo awal dari baris pertama di tabel bendaharas
    $saldo_awal = DB::table('bendaharas')->orderBy('id', 'asc')->value('saldo_awal');

    return view('frontend.instructor-dashboard.course.edit_saldo_awal', compact('saldo_awal'));
}

public function storeSaldoAwal(Request $request)
{
    $request->validate([
        'saldo_awal' => 'required|numeric|min:0',
    ]);

    Bendahara::create([
        'saldo_awal' => $request->saldo_awal,
        'saldo_akhir' => $request->saldo_awal,
        'tanggal' => now(),
        'keterangan' => 'Saldo Awal',
        'pemasukan' => 0,
        'pengeluaran' => 0,
    ]);

    // Flash pesan ke dalam session
    notyf()->success('Saldo Berhasil ditambah!');

    return redirect()->route('instructor.bendahara.index');
}


    public function storeKeuangan(Request $request)
{
    // Validasi input
    $request->validate([
        'tanggal' => 'required|date',
        'keterangan' => 'required|string|max:255',
        'pemasukan' => 'nullable|numeric|min:0',
        'pengeluaran' => 'nullable|numeric|min:0',
    ]);

    // Ambil saldo awal dari data pertama (jika ada)
    $saldo_awal = Bendahara::latest()->value('saldo_akhir') ?? 0; // Ambil saldo akhir terakhir

    // Hitung saldo akhir berdasarkan pemasukan dan pengeluaran
    $pemasukan = $request->pemasukan ?? 0;
    $pengeluaran = $request->pengeluaran ?? 0;
    $saldo_akhir = $saldo_awal + $pemasukan - $pengeluaran;

    // Simpan data keuangan
    Bendahara::create([
        'tanggal' => $request->tanggal,
        'keterangan' => $request->keterangan,
        'pemasukan' => $pemasukan,
        'pengeluaran' => $pengeluaran,
        'saldo_awal' => $saldo_awal,  // saldo awal adalah saldo terakhir
        'saldo_akhir' => $saldo_akhir,   // saldo akhir yang dihitung
    ]);
    notyf()->success('Data Keuangan berhasil ditambahkan!!');

    return redirect()->route('instructor.bendahara.index');
}


    public function update(Request $request, $id)
    {
        $bendahara = Bendahara::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'pemasukan' => 'nullable|numeric',
            'pengeluaran' => 'nullable|numeric',
        ]);

        // Ambil data yang ada
        $saldo_awal = $bendahara->saldo_awal;
        $pemasukan = $request->input('pemasukan') ?? 0;
        $pengeluaran = $request->input('pengeluaran') ?? 0;

        // Hitung saldo akhir
        $saldo_akhir = $saldo_awal + $pemasukan - $pengeluaran;

        // Update data bendahara
        $bendahara->update([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'saldo_akhir' => $saldo_akhir,
        ]);

        notyf()->success('Data berhasil diperbarui!!');
        return redirect()->route('instructor.bendahara.index')->with('success', '');
    }

    public function updateSaldoAwal(Request $request)
    {
        $request->validate([
            'saldo_awal' => 'required|numeric|min:0',
        ]);

        // Ambil data transaksi yang sudah ada, diurutkan berdasarkan tanggal/id
        $bendaharas = Bendahara::orderBy('tanggal', 'asc')->get();

        if ($bendaharas->isNotEmpty()) {
            $saldo_sebelumnya = $request->saldo_awal; // Saldo awal yang baru diinput
            foreach ($bendaharas as $bendahara) {
                // Hitung saldo akhir baru: saldo sebelumnya + pemasukan - pengeluaran
                $bendahara->saldo_awal = $saldo_sebelumnya;
                $bendahara->saldo_akhir = $saldo_sebelumnya + $bendahara->pemasukan - $bendahara->pengeluaran;

                // Update saldo sebelumnya untuk baris berikutnya
                $saldo_sebelumnya = $bendahara->saldo_akhir;

                $bendahara->save();
            }
        }
        notyf()->success('Saldo awal berhasil diperbarui dan saldo akhir telah disesuaikan.!!');
        return redirect()->route('instructor.bendahara.index');
    }






    public function edit($id)
    {
        $bendahara = Bendahara::findOrFail($id);
        
        return view('frontend.instructor-dashboard.course.edit', compact('bendahara'));
    }


    public function destroy($id)
    {
        $bendahara = Bendahara::findOrFail($id);
        $bendahara->delete();
        notyf()->success('Data Berhasil Dihapus.!!');
        return redirect()->route('instructor.bendahara.index');
    }
}
