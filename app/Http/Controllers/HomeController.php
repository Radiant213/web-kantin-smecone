<?php

namespace App\Http\Controllers;

use App\Models\Kantin;

class HomeController extends Controller
{
    public function index()
    {
        $kantins = Kantin::withCount('kiosks')->get();
        return view('home', compact('kantins'));
    }
}
