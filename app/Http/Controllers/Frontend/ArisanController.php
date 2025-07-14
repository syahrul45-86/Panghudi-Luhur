<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArisanController extends Controller
{
    public function index()
    {
        return view('frontend.instructor-dashboard.spin_arisan.index');
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

