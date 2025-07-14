<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Card;
use Illuminate\Contracts\View\View;

class IDAnggotacontroller extends Controller
{
    //
    public function index(): View
    {

        $cards = Card::all();
        return view('frontend.pages.card', compact('cards'));
    }

};
