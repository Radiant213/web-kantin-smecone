<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Kiosk;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Tampilkan daftar pesanan yang masuk ke kios milik penjual.
     */
    public function index()
    {
        $kiosk = Kiosk::where('user_id', auth()->id())->first();

        // Jika belum punya kios, arahkan ke profil untuk pengajuan
        if (!$kiosk) {
            return redirect()->route('profile.edit')->with('error', 'Anda harus memiliki kios terlebih dahulu untuk melihat pesanan masuk.');
        }

        // Ambil pesanan yang masuk ke kios ini, urutkan dari yang terbaru
        $orders = Order::with('user', 'items.menu')
            ->where('kiosk_id', $kiosk->id)
            ->latest()
            ->paginate(10);

        return view('penjual.orders.index', compact('orders', 'kiosk'));
    }

    /**
     * Memperbarui status pesanan.
     */
    public function updateStatus(Request $request, Order $order)
    {
        // Pastikan pesanan ini milik kios penjual
        $kiosk = Kiosk::where('user_id', auth()->id())->first();
        if (!$kiosk || $order->kiosk_id !== $kiosk->id) {
            abort(403, 'Unauthorized access to this order.');
        }

        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        \App\Events\OrderStatusUpdated::dispatch($order);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
