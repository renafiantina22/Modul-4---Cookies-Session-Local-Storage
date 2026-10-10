<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('id_user', auth()->user()->id_user)
            ->orderByDesc('tanggal_order')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show(string $id)
    {
        $order = Order::with('details.product')
            ->where('id_order', $id)
            ->where('id_user', auth()->user()->id_user)
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }
}
