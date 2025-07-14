<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class CardController extends Controller
{
    use FileUpload;
    public function index() : View
    {
        $cards = Card::all();
        return view('admin.sections.card.index', compact('cards'));
    }

    public function create() : view
    {
        return view('admin.sections.card.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'whatsapp' => 'required|string',
        'instagram' => 'nullable|url',
        'tiktok' => 'nullable|url',
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $path = $request->file('image')->store('cards', 'public');

    Card::create([
        'name' => $request->name,
        'whatsapp' => $request->whatsapp,
        'instagram' => $request->instagram,
        'tiktok' => $request->tiktok,
        'image' => $path,
    ]);

    notyf()->success('Card berhasil ditambahkan!');
    return redirect()->route('admin.cards-sections.index');
}
public function edit($id)
{
    $card = Card::findOrFail($id); // Cari data berdasarkan ID
    return view('admin.sections.card.edit', compact('card')); // Tampilkan view edit
}

// Fungsi untuk mengupdate data
public function update(Request $request, $id)
{

    $card = Card::findOrFail($id); // Cari data berdasarkan ID
     // Tampilkan view edit
    // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'whatsapp' => 'required|url',
        'instagram' => 'required|url',
        'tiktok' => 'required|url',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Jika ada file gambar baru, upload dan ganti gambar lama
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('cards', 'public');

        // Hapus gambar lama jika ada
        if ($card->image && file_exists(storage_path('app/public/' . $card->image))) {
            unlink(storage_path('app/public/' . $card->image));
        }

        $card->image = $imagePath;
    }

    // Update data lainnya
    $card->update([
        'name' => $request->name,
        'whatsapp' => $request->whatsapp,
        'instagram' => $request->instagram,
        'tiktok' => $request->tiktok,
    ]);

    notyf()->success('Card berhasil diperbarui!');
    return redirect()->route('admin.cards-sections.index');
}

// Fungsi untuk menghapus data
public function destroy($id) 
{
    $card = Card::findOrFail($id); // Cari data berdasarkan ID

    // Hapus gambar jika ada
    if ($card->image && file_exists(storage_path('app/public/' . $card->image))) {
        unlink(storage_path('app/public/' . $card->image));
    }

    $card->delete(); // Hapus data dari database

    notyf()->success('Card berhasil dihapus!');
    return redirect()->route('admin.cards-sections.index');
}
}
