<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $menuId => $qty) {
            $menu = Menu::with('kiosk.kantin')->find($menuId);
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

        return back()->with('success', 'Menu berhasil ditambahkan ke baki pesanan!');
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
        $request->validate([
            'pickup_session' => 'required|in:istirahat_1,istirahat_2',
            'notes' => 'nullable|string|max:500',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang pesanan masih kosong!');
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

        $midtransService = new MidtransService();
        $createdOrders = [];

        foreach ($kioskOrders as $kioskId => $items) {
            $totalPrice = 0;
            foreach ($items as $item) {
                $totalPrice += $item['menu']->price * $item['quantity'];
            }

            // Generate clean school order code
            $randomDigits = str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
            $orderCode = 'SMC-' . date('md') . '-' . $randomDigits;

            $order = $request->user()->orders()->create([
                'order_code' => $orderCode,
                'kiosk_id' => $kioskId,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'pickup_session' => $request->pickup_session,
                'notes' => $request->notes,
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'menu_id' => $item['menu']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['menu']->price,
                ]);
            }

            // Request Midtrans Snap Token
            $snapToken = $midtransService->createSnapToken($order);
            if ($snapToken) {
                $order->update(['snap_token' => $snapToken]);
            }

            $createdOrders[] = $order;
        }

        session()->forget('cart');

        // Pass created order and snap token to checkout page
        $firstOrder = $createdOrders[0] ?? null;
        if ($firstOrder && $firstOrder->snap_token) {
            return redirect()->route('orders.index', ['pay_order_id' => $firstOrder->id])
                ->with('success', 'Pesanan dibuat! Silakan selesaikan pembayaran QRIS.');
        }

        return redirect()->route('orders.index')
            ->with('success', 'Pesanan berhasil dibuat!');
    }
}
