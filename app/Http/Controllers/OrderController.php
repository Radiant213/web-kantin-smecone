<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->with(['kiosk.kantin', 'items.menu'])
            ->latest()
            ->paginate(10);

        // Auto-generate Midtrans Snap Token for unpaid orders if missing
        $midtransService = new MidtransService();
        foreach ($orders as $order) {
            if ($order->payment_status === 'unpaid' && empty($order->snap_token)) {
                $order->loadMissing(['items.menu', 'user']);
                $token = $midtransService->createSnapToken($order);
                if ($token) {
                    $order->update(['snap_token' => $token]);
                    $order->snap_token = $token;
                }
            }
        }

        return view('orders.index', compact('orders'));
    }
}
