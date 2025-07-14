<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpinController extends Controller
{
    // Menampilkan halaman utama spin
        public function index()
    {
        return view('admin.spin_arisan.index');
    }

    public function spin(Request $request)
    {
        $validated = $request->validate([
            'names' => 'required|array|min:2',
            'names.*' => 'string',
        ]);

        // Pilih nama secara acak
        $winner = $validated['names'][array_rand($validated['names'])];

        return back()->with([
            'winner' => $winner,
            'names' => $validated['names'],
        ]);
    }

}
