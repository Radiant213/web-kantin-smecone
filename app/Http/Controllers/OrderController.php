<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->with(['kiosk', 'items.menu'])
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }
}
