<?php

namespace App\Http\Controllers;

use App\Models\Kiosk;

class KioskController extends Controller
{
    public function show(Kiosk $kiosk)
    {
        $kiosk->load(['kantin', 'user', 'menus']);
        return view('kiosk.show', compact('kiosk'));
    }
}
