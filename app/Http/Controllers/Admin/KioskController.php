<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kantin;
use App\Models\Kiosk;
use App\Models\User;
use Illuminate\Http\Request;

class KioskController extends Controller
{
    public function index()
    {
        $kiosks = Kiosk::with(['kantin', 'user'])->latest()->paginate(10);
        return view('admin.kiosks.index', compact('kiosks'));
    }

    public function create()
    {
        $kantins = Kantin::all();
        $penjuals = User::where('role', 'penjual')->get();
        return view('admin.kiosks.create', compact('kantins', 'penjuals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kantin_id' => 'required|exists:kantins,id',
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('kantin_id', 'user_id', 'name', 'description');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('kiosks', 'public');
        }

        Kiosk::create($data);

        return redirect()->route('admin.kiosks.index')->with('success', 'Kios berhasil ditambahkan!');
    }

    public function edit(Kiosk $kiosk)
    {
        $kantins = Kantin::all();
        $penjuals = User::where('role', 'penjual')->get();
        return view('admin.kiosks.edit', compact('kiosk', 'kantins', 'penjuals'));
    }

    public function update(Request $request, Kiosk $kiosk)
    {
        $request->validate([
            'kantin_id' => 'required|exists:kantins,id',
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('kantin_id', 'user_id', 'name', 'description');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('kiosks', 'public');
        }

        $kiosk->update($data);

        return redirect()->route('admin.kiosks.index')->with('success', 'Kios berhasil diperbarui!');
    }

    public function destroy(Kiosk $kiosk)
    {
        $kiosk->delete();
        return redirect()->route('admin.kiosks.index')->with('success', 'Kios berhasil dihapus!');
    }
}
