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

        foreach ($cart as $key => $cartItem) {
            $menuId = is_array($cartItem) ? ($cartItem['menu_id'] ?? null) : $key;
            $qty = is_array($cartItem) ? ($cartItem['quantity'] ?? 1) : $cartItem;
            $unitPrice = is_array($cartItem) && isset($cartItem['price']) ? (int)$cartItem['price'] : null;
            $notes = is_array($cartItem) ? ($cartItem['notes'] ?? null) : null;

            $menu = Menu::with('kiosk.kantin')->find($menuId);
            if ($menu) {
                $finalPrice = $unitPrice ?? $menu->price;
                $subtotal = $finalPrice * $qty;
                $items[] = [
                    'key' => (string)$key,
                    'menu' => $menu,
                    'quantity' => $qty,
                    'price' => $finalPrice,
                    'notes' => $notes,
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
            'quantity' => 'nullable|integer|min:1',
            'custom_price' => 'nullable|integer|min:1000',
            'notes' => 'nullable|string|max:500',
        ]);

        $menu = Menu::findOrFail($request->menu_id);
        $qty = (int)($request->quantity ?? 1);
        $customPrice = $request->filled('custom_price') ? (int)$request->custom_price : $menu->price;
        $notes = $request->filled('notes') ? trim($request->notes) : null;

        $cart = session()->get('cart', []);
        
        // Generate unique key based on menu id, price, and customization notes
        $hash = substr(md5($customPrice . '_' . ($notes ?? '')), 0, 8);
        $cartKey = 'item_' . $menu->id . '_' . $hash;

        if (isset($cart[$cartKey]) && is_array($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $qty;
        } else {
            $cart[$cartKey] = [
                'key' => $cartKey,
                'menu_id' => $menu->id,
                'quantity' => $qty,
                'price' => $customPrice,
                'notes' => $notes,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Menu berhasil ditambahkan ke baki pesanan!');
    }

    public function remove($key)
    {
        $cart = session()->get('cart', []);
        unset($cart[$key]);
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
        foreach ($cart as $key => $cartItem) {
            $menuId = is_array($cartItem) ? ($cartItem['menu_id'] ?? null) : $key;
            $qty = is_array($cartItem) ? ($cartItem['quantity'] ?? 1) : $cartItem;
            $unitPrice = is_array($cartItem) && isset($cartItem['price']) ? (int)$cartItem['price'] : null;
            $itemNotes = is_array($cartItem) ? ($cartItem['notes'] ?? null) : null;

            $menu = Menu::find($menuId);
            if ($menu) {
                $price = $unitPrice ?? $menu->price;
                $kioskId = $menu->kiosk_id;
                if (!isset($kioskOrders[$kioskId])) {
                    $kioskOrders[$kioskId] = [];
                }
                $kioskOrders[$kioskId][] = [
                    'menu' => $menu,
                    'quantity' => $qty,
                    'price' => $price,
                    'notes' => $itemNotes,
                ];
            }
        }

        $midtransService = new MidtransService();
        $createdOrders = [];

        foreach ($kioskOrders as $kioskId => $items) {
            $totalPrice = 0;
            foreach ($items as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
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
                    'price' => $item['price'],
                    'notes' => $item['notes'],
                ]);
            }

            // Reload fresh relationships for Midtrans API payload
            $order->load(['items.menu', 'user']);

            // Request Midtrans Snap Token
            $snapToken = $midtransService->createSnapToken($order);
            if ($snapToken) {
                $order->update(['snap_token' => $snapToken]);
                $order->snap_token = $snapToken;
            }

            $createdOrders[] = $order;
        }

        session()->forget('cart');

        // Pass created order and snap token to checkout page
        $firstOrder = $createdOrders[0] ?? null;
        if ($firstOrder) {
            return redirect()->route('orders.index', ['pay_order_id' => $firstOrder->id])
                ->with('success', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran QRIS.');
        }

        return redirect()->route('orders.index')
            ->with('success', 'Pesanan berhasil dibuat!');
    }
}
