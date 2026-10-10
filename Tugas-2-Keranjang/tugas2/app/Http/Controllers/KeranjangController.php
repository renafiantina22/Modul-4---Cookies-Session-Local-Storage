<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        $keranjang = session('keranjang', []);
        $jumlahKeranjang = array_sum($keranjang);

        return view('barang.index', compact(
            'barangs',
            'jumlahKeranjang'
        ));
    }

    public function tambah(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $keranjang = session('keranjang', []);

        $jumlahSaatIni = $keranjang[$id] ?? 0;

        if ($jumlahSaatIni < $barang->stok) {
            $keranjang[$id] = $jumlahSaatIni + 1;
            $request->session()->put('keranjang', $keranjang);
        }

        return redirect()->route('barang.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function indexKeranjang()
    {
        $keranjang = session('keranjang', []);
        $barangs = Barang::whereIn('id', array_keys($keranjang))->get();

        $items = $barangs->map(function ($barang) use ($keranjang) {
            $barang->jumlah = $keranjang[$barang->id];
            $barang->subtotal = $barang->harga * $barang->jumlah;

            return $barang;
        });

        $total = $items->sum('subtotal');

        return view('keranjang.index', compact('items', 'total'));
    }

 
    public function tambahJumlah($id)
    {
        $barang = Barang::findOrFail($id);
        $keranjang = session('keranjang', []);
        $jumlah = $keranjang[$id] ?? 0;

        if ($jumlah < $barang->stok) {
            $keranjang[$id] = $jumlah + 1;
            session(['keranjang' => $keranjang]);
        }

        return redirect()->route('keranjang.index');
    }

    public function kurangJumlah($id)
    {
        $keranjang = session('keranjang', []);

        if (isset($keranjang[$id])) {
            $keranjang[$id]--;

            if ($keranjang[$id] <= 0) {
                unset($keranjang[$id]);
            }

            session(['keranjang' => $keranjang]);
        }

        return redirect()->route('keranjang.index');
    }

    public function hapus($id)
    {
        $keranjang = session('keranjang', []);

        unset($keranjang[$id]);

        session(['keranjang' => $keranjang]);

        return redirect()->route('keranjang.index');
    }

    public function kosongkan()
    {
        session()->forget('keranjang');

        return redirect()->route('keranjang.index');
    }
    
}
