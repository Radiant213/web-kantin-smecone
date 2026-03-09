<?php

namespace App\Http\Controllers;

use App\Models\Kantin;

class KantinController extends Controller
{
    public function show(Kantin $kantin)
    {
        $kantin->load(['kiosks.user']);
        return view('kantin.show', compact('kantin'));
    }
}
