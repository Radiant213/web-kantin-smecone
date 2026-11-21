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
        $query = trim($request->input('q', ''));

        if ($query === '') {
            return redirect()->route('admin.dashboard');
        }

        $kantins = Kantin::where('name', 'like', "%{$query}%")->limit(10)->get();
        $kiosks = Kiosk::with('kantin')->where('name', 'like', "%{$query}%")->limit(10)->get();
        $users = User::where('name', 'like', "%{$query}%")->orWhere('email', 'like', "%{$query}%")->limit(10)->get();

        return view('admin.search.index', compact('query', 'kantins', 'kiosks', 'users'));
    }
}
