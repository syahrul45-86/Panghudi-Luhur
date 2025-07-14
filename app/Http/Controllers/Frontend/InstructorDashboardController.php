<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\OrderItem;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Bendahara;

class InstructorDashboardController extends Controller
{
    function index() : View {

         // Ambil data bendahara (misalnya)
    $bendaharas = Bendahara::all();

    return view('frontend.instructor-dashboard.index', compact('bendaharas'));
}
}
