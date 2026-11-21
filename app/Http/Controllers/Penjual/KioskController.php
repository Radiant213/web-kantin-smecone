<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Kiosk;
use App\Models\KioskApplication;
use Illuminate\Http\Request;

class KioskController extends Controller
{
    /**
     * Tampilkan halaman utama manajemen kios & menu untuk penjual.
     */
    public function index()
    {
        $user = auth()->user();
        $kiosk = Kiosk::with(['kantin', 'menus'])->where('user_id', $user->id)->first();
        $pendingApplication = KioskApplication::with('kiosk.kantin')->where('user_id', $user->id)->where('status', 'pending')->first();
        $availableKiosks = Kiosk::with('kantin')->whereNull('user_id')->get();

        return view('penjual.kiosk.index', compact('kiosk', 'pendingApplication', 'availableKiosks'));
    }

    public function apply(Request $request)
    {
        $request->validate([
            'kiosk_id' => 'required|exists:kiosks,id',
            'reason' => 'nullable|string|max:500'
        ]);

        // Check if user already has a pending application
        if (auth()->user()->kioskApplications()->where('status', 'pending')->exists()) {
            return redirect()->route('penjual.kiosk.index')->with('error', 'Anda sudah memiliki pengajuan kios yang sedang diproses.');
        }

        // Check if user already owns a kiosk
        if (Kiosk::where('user_id', auth()->id())->exists()) {
            return redirect()->route('penjual.kiosk.index')->with('error', 'Anda sudah memiliki kios.');
        }

        KioskApplication::create([
            'user_id' => auth()->id(),
            'kiosk_id' => $request->kiosk_id,
            'reason' => $request->reason,
        ]);

        return redirect()->route('penjual.kiosk.index')->with('success', 'Pengajuan kepemilikan kios berhasil dikirim dan sedang menunggu persetujuan admin.');
    }

    public function updateDetails(Request $request)
    {
        $kiosk = Kiosk::where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('kiosks', 'public');
            $kiosk->update([
                'description' => $request->description,
                'image' => $path
            ]);
        } else {
            $kiosk->update([
                'description' => $request->description
            ]);
        }

        return redirect()->route('penjual.kiosk.index')->with('success', 'Informasi kios berhasil diperbarui!');
    }
}
