<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class AdminUserController extends Controller
{

        public function __construct()
    {
        // Middleware bisa ditambahkan di sini jika perlu
    }
    public function index(): View
    {
        // Ambil semua pengguna
        $users = User::all(); // atau gunakan query lain sesuai kebutuhan

        // Kirim data pengguna ke view
        return view('admin.create_anggota.index', compact('users'));
    }


    public function create(): View
    {
        return view('admin.create_anggota.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'type' => ['required', 'in:anggota,bendahara']
        ]);

        // Menentukan role dan status persetujuan
        $role = $request->type === 'anggota' ? 'anggota' : 'bendahara';
        $approveStatus = $role === 'anggota' ? 'approved' : 'pending';

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'approve_status' => $approveStatus
        ]);

        // Redirect berdasarkan peran
        return redirect()->route('admin.users.index')->with('success', 'User berhasil didaftarkan');
    }

    // Penghapusan pengguna
    public function destroy($id): RedirectResponse
    {


        // Hapus user dari database
        $user = User::find($id);

        if (!$user) {
            return back()->with('error', 'Pengguna tidak ditemukan');
        }

        // Lanjutkan untuk menghapus user jika ditemukan
        if ($user->delete()) {
            return redirect()->route('admin.users.index')->with('success', 'Anggota berhasil dihapus');
        } else {
            return back()->with('error', 'Gagal menghapus anggota, coba lagi');
        }

    }
}
