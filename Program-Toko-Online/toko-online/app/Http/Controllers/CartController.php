<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $products = Product::whereIn('id_barang', array_keys($cart))->get();

        $items = $products->map(function ($product) use ($cart) {
            $jumlah = $cart[$product->id_barang];

            return [
                'product' => $product,
                'jumlah' => $jumlah,
                'subtotal' => $product->harga * $jumlah,
            ];
        });

        $total = $items->sum('subtotal');

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->stok < 1) {
            return back()->with('error', 'Stok barang habis.');
        }

        $cart = session('cart', []);
        $jumlahSekarang = $cart[$id] ?? 0;

        if ($jumlahSekarang >= $product->stok) {
            return back()->with('error', 'Jumlah barang sudah mencapai stok.');
        }

        $cart[$id] = $jumlahSekarang + 1;
        session(['cart' => $cart]);

        return back()->with('success', 'Barang berhasil dimasukkan ke keranjang.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($id);
        $jumlah = (int) $request->jumlah;

        if ($jumlah > $product->stok) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
        }

        $cart = session('cart', []);
        $cart[$id] = $jumlah;
        session(['cart' => $cart]);

        return back()->with('success', 'Jumlah barang diperbarui.');
    }

    public function remove(string $id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        return back()->with('success', 'Barang dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => ['required', 'string', 'max:5000'],
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        try {
            $order = DB::transaction(function () use ($cart, $request) {
                $products = [];

                foreach ($cart as $id => $jumlah) {
                    $product = Product::where('id_barang', $id)
                        ->lockForUpdate()
                        ->firstOrFail();

                    $jumlah = (int) $jumlah;

                    if ($jumlah < 1 || $jumlah > $product->stok) {
                        throw new \RuntimeException(
                            'Stok ' . $product->nama_barang . ' tidak mencukupi.'
                        );
                    }

                    $products[] = [
                        'product' => $product,
                        'jumlah' => $jumlah,
                    ];
                }

                $total = 0;

                foreach ($products as $item) {
                    $total += $item['product']->harga * $item['jumlah'];
                }

                $order = Order::create([
                    'id_order' => 'ORD' . strtoupper(Str::random(12)),
                    'id_user' => auth()->user()->id_user,
                    'tanggal_order' => now(),
                    'total_harga' => $total,
                    'alamat_pengiriman' => $request->alamat_pengiriman,
                ]);

                foreach ($products as $item) {
                    $product = $item['product'];
                    $jumlah = $item['jumlah'];

                    OrderDetail::create([
                        'id_order' => $order->id_order,
                        'id_barang' => $product->id_barang,
                        'harga_satuan' => $product->harga,
                        'jumlah_beli' => $jumlah,
                    ]);

                    $product->decrement('stok', $jumlah);
                }

                return $order;
            });
        } catch (\RuntimeException $e) {
            return redirect()->route('cart.index')
                ->with('error', $e->getMessage());
        }

        $request->session()->forget('cart');

        return redirect()->route('orders.show', $order->id_order)
            ->with('success', 'Checkout berhasil! Pesanan berhasil disimpan.');
    }

}
