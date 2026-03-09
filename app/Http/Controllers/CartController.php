<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $menuId => $qty) {
            $menu = Menu::with('kiosk')->find($menuId);
            if ($menu) {
                $subtotal = $menu->price * $qty;
                $items[] = [
                    'menu' => $menu,
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
            }
        }

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        $menuId = $request->menu_id;
        $qty = $request->quantity ?? 1;

        if (isset($cart[$menuId])) {
            $cart[$menuId] += $qty;
        } else {
            $cart[$menuId] = $qty;
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Item ditambahkan ke keranjang!');
    }

    public function remove($menuId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$menuId]);
        session()->put('cart', $cart);

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong!');
        }

        // Group items by kiosk
        $kioskOrders = [];
        foreach ($cart as $menuId => $qty) {
            $menu = Menu::find($menuId);
            if ($menu) {
                $kioskId = $menu->kiosk_id;
                if (!isset($kioskOrders[$kioskId])) {
                    $kioskOrders[$kioskId] = [];
                }
                $kioskOrders[$kioskId][] = [
                    'menu' => $menu,
                    'quantity' => $qty,
                ];
            }
        }

        // Create orders per kiosk
        foreach ($kioskOrders as $kioskId => $items) {
            $totalPrice = 0;
            foreach ($items as $item) {
                $totalPrice += $item['menu']->price * $item['quantity'];
            }

            $order = $request->user()->orders()->create([
                'kiosk_id' => $kioskId,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'menu_id' => $item['menu']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['menu']->price,
                ]);
            }

            // Broadcast real-time order notification (WebSocket)
            \App\Events\OrderMasuk::dispatch($order);

            // Send Web Push Notification (Background)
            $kioskOwnerId = $order->kiosk->user_id;
            try {
                $pushService = new \App\Services\WebPushService();
                $pushService->sendToUser($kioskOwnerId, [
                    'title' => '🔔 Pesanan Baru!',
                    'body' => 'Subtotal: Rp ' . number_format($order->total_price, 0, ',', '.'),
                    'url' => route('penjual.orders.index'),
                    'tag' => 'order-' . $order->id,
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('WebPush Error: ' . $e->getMessage());
            }
        }

        session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat!');
    }
}
