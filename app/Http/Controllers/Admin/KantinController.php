<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kantin;
use Illuminate\Http\Request;

class KantinController extends Controller
{
    public function index()
    {
        $kantins = Kantin::withCount('kiosks')->latest()->paginate(10);
        return view('admin.kantins.index', compact('kantins'));
    }

    public function create()
    {
        return view('admin.kantins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'description');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('kantins', 'public');
        }

        Kantin::create($data);

        return redirect()->route('admin.kantins.index')->with('success', 'Kantin berhasil ditambahkan!');
    }

    public function edit(Kantin $kantin)
    {
        return view('admin.kantins.edit', compact('kantin'));
    }

    public function update(Request $request, Kantin $kantin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'description');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('kantins', 'public');
        }

        $kantin->update($data);

        return redirect()->route('admin.kantins.index')->with('success', 'Kantin berhasil diperbarui!');
    }

    public function destroy(Kantin $kantin)
    {
        $kantin->delete();
        return redirect()->route('admin.kantins.index')->with('success', 'Kantin berhasil dihapus!');
    }
}
