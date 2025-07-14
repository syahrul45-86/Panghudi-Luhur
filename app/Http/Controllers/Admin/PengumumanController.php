<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengumuman; // Menggunakan model Pengumuman
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Denda;

class PengumumanController extends Controller
{
    public function index() {
        $pengumumans = Pengumuman::all();  // Mengambil semua data Pengumuman
        return view('admin.pengumuman.index', compact('pengumumans'));
    }

    public function create() {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomor_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'kepada' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'hari' => 'required|string|max:255',
            'waktu' => 'required|date_format:H:i',
            'tempat' => 'required|string|max:255',
            'acara' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
            'ttd_ketua' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        // Simpan data pengumuman
        $pengumuman = new Pengumuman();
        $pengumuman->fill($request->except('gambar', 'ttd_ketua'));

        // Proses upload gambar (opsional)
        if ($request->hasFile('gambar')) {
            $fileName = uniqid() . '_' . $request->file('gambar')->getClientOriginalName(); // Membuat nama file unik
            $filePath = $request->file('gambar')->storeAs('uploads', $fileName, 'public'); // Simpan di storage
            $pengumuman->gambar = $filePath; // Simpan path ke database
        }

        // Proses upload tanda tangan ketua (opsional)
        if ($request->hasFile('ttd_ketua')) {
            $fileName = uniqid() . '_' . $request->file('ttd_ketua')->getClientOriginalName(); // Membuat nama file unik
            $filePath = $request->file('ttd_ketua')->storeAs('uploads', $fileName, 'public'); // Simpan di storage
            $pengumuman->ttd_ketua = $filePath; // Simpan path ke database
        }

        $pengumuman->save();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil disimpan!');
    }





    public function show($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.pengumuman.show', compact('pengumuman'));
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomor_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'kepada' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'hari' => 'required|string|max:255',
           'waktu' => 'required',
            'tempat' => 'required|string|max:255',
            'acara' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
            'ttd_ketua' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->fill($request->except('gambar', 'ttd_ketua'));

        if ($request->hasFile('gambar')) {
            $gambarFile = $request->file('gambar');
            $fileName = uniqid() . '_' . $gambarFile->getClientOriginalName();
            $filePath = $gambarFile->storeAs('uploads', $fileName, 'public');
            $pengumuman->gambar = $filePath;
        }

        if ($request->hasFile('ttd_ketua')) {
            $ttdFile = $request->file('ttd_ketua');
            $fileName = uniqid() . '_' . $ttdFile->getClientOriginalName();
            $filePath = $ttdFile->storeAs('uploads', $fileName, 'public');
            $pengumuman->ttd_ketua = $filePath;
        }

        $pengumuman->save();

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui!');
    }


    public function destroy($id)
    {
        Pengumuman::findOrFail($id)->delete();
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus!');
    }

    public function printUnpaid()
    {
        $dendas = Denda::with('anggota')->where('status', 'belum_lunas')->get();

        $pdf = PDF::loadView('frontend.instructor-dashboard.denda.pdf', compact('dendas'));

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="denda_belum_lunas.pdf"',
        ]);
    }

public function cetakPDF($id)
{
    // Ambil satu data pengumuman berdasarkan ID
    $pengumuman = Pengumuman::findOrFail($id);

    // Generate PDF dari view
    $pdf = PDF::loadView('admin.pengumuman.template', compact('pengumuman'));

    // Kembalikan file PDF sebagai response ke browser
    return response($pdf->output(), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="undangan_' . $pengumuman->id . '.pdf"',
    ]);
}
}
