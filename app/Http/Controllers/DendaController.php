<?php
namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DendaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        // Query untuk mendapatkan data denda dengan relasi anggota dan filter berdasarkan nama
        $dendas = Denda::with('anggota')
            ->when($search, function($query) use ($search) {
                return $query->whereHas('anggota', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            })
            ->get();

            return view('frontend.instructor-dashboard.denda.index', compact('dendas'));
    }

    public function search(Request $request)
{
    $query = $request->input('search');

    // Ambil data berdasarkan nama anggota
    $dendas = Denda::whereHas('anggota', function($q) use ($query) {
        $q->where('name', 'LIKE', "%$query%");
    })->get();

    // Return HTML yang akan dimasukkan ke dalam tabel
    $html = '';
    foreach ($dendas as $key => $denda) {
        $html .= '
            <tr>
                <td>' . ($key + 1) . '</td>
                <td>' . $denda->anggota->name . '</td>
                <td>' . date('d-m-Y', strtotime($denda->tanggal)) . '</td>
                <td>' . $denda->keterangan . '</td>
                <td>Rp ' . number_format($denda->jumlah, 2) . '</td>
                <td>
                    <span class="badge ' . ($denda->status == 'lunas' ? 'bg-success' : 'bg-danger') . '">
                        ' . ucfirst(str_replace('_', ' ', $denda->status)) . '
                    </span>
                </td>
                <td>
                    <a href="' . route('instructor.denda.edit', $denda->id) . '" class="btn btn-warning">Edit</a>
                    <form action="' . route('instructor.denda.destroy', $denda->id) . '" method="POST" style="display:inline-block;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger" onclick="return confirm(\'Yakin hapus denda ini?\')">Hapus</button>
                    </form>
                </td>
            </tr>';
    }

    return response()->json($html);
}



    public function create()
    {
        $anggota = User::where('role', 'anggota')->get();
        return view('frontend.instructor-dashboard.denda.create', compact('anggota'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'keterangan' => 'nullable|string',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'status' => 'required|in:belum_lunas,lunas', // Tambahkan validasi status
        ]);

        Denda::create([
            'user_id' => $request->user_id,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal ?? now(),
            'status' => $request->status, // Simpan status
        ]);
        notyf()->success('Denda Berhasil Ditambahkan.!!');
        return redirect()->route('instructor.denda.index');
    }

// Fungsi untuk menampilkan form edit denda anggota
public function edit($id)
{
    $denda = Denda::findOrFail($id); // Ambil data denda berdasarkan ID
    $anggota = User::all(); // Ambil semua data anggota
    notyf()->success('Data Berhasil Diupdate.!!');
    return view('frontend.instructor-dashboard.denda.edit', compact('denda', 'anggota'));
}

// Fungsi untuk mengupdate data denda anggota
public function update(Request $request, $id)
{
    // Validasi data input
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'tanggal' => 'required|date',
        'keterangan' => 'nullable|string',
        'jumlah' => 'required|numeric',
        'status' => 'required|in:belum_lunas,lunas',
    ]);



    // Cari data denda berdasarkan ID
    $denda = Denda::findOrFail($id);

     // Jika status berubah menjadi "lunas", maka hapus datanya
     if ($request->status == 'lunas') {
        $denda->delete();
        notyf()->success('Denda Sudah Lunas dan otomatis terhapus.!!');
        return redirect()->route('instructor.denda.index');
    }
    // Update data denda
    $denda->user_id = $request->user_id;
    $denda->tanggal = $request->tanggal;
    $denda->keterangan = $request->keterangan;
    $denda->jumlah = $request->jumlah;
    $denda->status = $request->status;

    // Simpan perubahan
    $denda->save();

    // Redirect ke halaman sebelumnya dengan pesan sukses
    notyf()->success('Denda berhasil diupdate.!!');
    return redirect()->route('instructor.denda.index');
}


    public function destroy($id) {
        $denda =Denda::findOrFail($id);
        $denda ->delete();
        notyf()->success('Denda berhasil dihapus.!!');
        return redirect()->route('instructor.denda.index')->with('success', 'Data berhasil dihapus!');
    }


        public function printUnpaid()
    {
        // Ambil data denda yang belum lunas
        $dendas = Denda::with('anggota')->where('status', 'belum_lunas')->get();

        // Buat PDF
        $pdf = PDF::loadView('frontend.instructor-dashboard.denda.pdf', compact('dendas'));

        // Unduh PDF
        notyf()->success('Data Berhasil Didownload.!!');
        return $pdf->download('denda_belum_lunas.pdf');
    }
}
