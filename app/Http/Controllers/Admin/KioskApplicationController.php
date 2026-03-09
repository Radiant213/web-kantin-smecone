<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KioskApplication;
use App\Models\Kiosk;
use Illuminate\Http\Request;

class KioskApplicationController extends Controller
{
    public function index()
    {
        $applications = KioskApplication::with(['user', 'kiosk'])->latest()->paginate(10);
        return view('admin.kiosk_applications.index', compact('applications'));
    }

    public function approve(KioskApplication $application)
    {
        if ($application->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $kiosk = $application->kiosk;

        // Ensure kiosk doesn't already have an owner
        if ($kiosk->user_id !== null) {
            $application->update(['status' => 'rejected', 'reason' => 'Kios sudah memiliki pemilik.']);
            return back()->with('error', 'Kios ini sudah dimiliki oleh penjual lain. Pengajuan otomatis ditolak.');
        }

        // Update Kiosk Owner
        $kiosk->update(['user_id' => $application->user_id]);

        // Mark Application as Approved
        $application->update(['status' => 'approved']);

        return back()->with('success', 'Pengajuan kepemilikan kios disetujui!');
    }

    public function reject(Request $request, KioskApplication $application)
    {
        if ($application->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $application->update([
            'status' => 'rejected',
            'reason' => $request->reason
        ]);

        return back()->with('success', 'Pengajuan kepemilikan kios ditolak.');
    }
}
