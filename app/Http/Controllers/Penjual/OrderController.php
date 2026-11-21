<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Kiosk;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Tampilkan daftar pesanan yang masuk ke kios milik penjual dengan statistik & filter informatif.
     */
    public function index(Request $request)
    {
        $kiosk = Kiosk::where('user_id', auth()->id())->first();

        // Jika belum punya kios, arahkan ke halaman kelola kios
        if (!$kiosk) {
            return redirect()->route('penjual.kiosk.index')->with('error', 'Anda harus memiliki kios terlebih dahulu untuk melihat pesanan masuk.');
        }

        $today = now()->today();

        // ── Statistik Pesanan Kios Real-time ──
        $stats = [
            'total_all' => Order::where('kiosk_id', $kiosk->id)->count(),
            'total_today' => Order::where('kiosk_id', $kiosk->id)->whereDate('created_at', $today)->count(),
            'unpaid' => Order::where('kiosk_id', $kiosk->id)->where('payment_status', 'pending')->count(),
            'waiting' => Order::where('kiosk_id', $kiosk->id)->where('status', 'pending')->where('payment_status', 'paid')->count(),
            'cooking' => Order::where('kiosk_id', $kiosk->id)->where('status', 'processing')->count(),
            'completed' => Order::where('kiosk_id', $kiosk->id)->where('status', 'completed')->count(),
            'completed_today' => Order::where('kiosk_id', $kiosk->id)->where('status', 'completed')->whereDate('created_at', $today)->count(),
        ];

        // ── Query Pesanan dengan Filter ──
        $query = Order::with('user', 'items.menu')
            ->where('kiosk_id', $kiosk->id);

        // Preset filter dari card klik
        $preset = $request->input('preset', 'all');

        if ($preset === 'unpaid') {
            $query->where('payment_status', 'pending');
        } elseif ($preset === 'waiting') {
            $query->where('status', 'pending')->where('payment_status', 'paid');
        } elseif ($preset === 'cooking') {
            $query->where('status', 'processing');
        } elseif ($preset === 'completed_today') {
            $query->where('status', 'completed')->whereDate('created_at', $today);
        } elseif ($preset === 'today') {
            $query->whereDate('created_at', $today);
        }

        // Filter tanggal spesifik
        if ($request->filled('date') && $preset === 'all') {
            if ($request->date === 'today') {
                $query->whereDate('created_at', $today);
            } else {
                $query->whereDate('created_at', $request->date);
            }
        }

        // Filter status pembayaran manual
        if ($request->filled('payment_status') && $request->payment_status !== 'all') {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter status pesanan manual
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Pencarian kode pesanan atau nama pembeli
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('penjual.orders.index', compact('orders', 'kiosk', 'stats', 'preset'));
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
