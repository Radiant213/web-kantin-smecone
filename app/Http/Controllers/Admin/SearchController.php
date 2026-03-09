<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kantin;
use App\Models\Kiosk;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return back()->with('error', 'Masukkan kata kunci pencarian.');
        }

        $kantins = Kantin::where('name', 'like', "%{$query}%")->limit(5)->get();
        $kiosks = Kiosk::where('name', 'like', "%{$query}%")->limit(5)->get();
        $users = User::where('name', 'like', "%{$query}%")->orWhere('email', 'like', "%{$query}%")->limit(5)->get();

        return view('admin.search.index', compact('query', 'kantins', 'kiosks', 'users'));
    }
}
