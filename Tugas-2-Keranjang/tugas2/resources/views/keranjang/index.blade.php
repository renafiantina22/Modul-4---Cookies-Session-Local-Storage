
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header>
        <h2>Keranjang Belanja</h2>
        <a href="{{ route('barang.index') }}">Kembali ke Katalog</a>
    </header>

    <main class="container">
        @if ($items->isEmpty())
            <div class="card">
                <h3>Keranjang masih kosong</h3>
                <p>Silakan pilih barang dari katalog.</p>
                <a class="button" href="{{ route('barang.index') }}">
                    Lihat Barang
                </a>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->nama_barang }}</td>
                            <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('keranjang.kurang', $item->id) }}"
                                      method="POST">
                                    @csrf
                                    <button type="submit">−</button>
                                </form>

                                {{ $item->jumlah }}

                                <form action="{{ route('keranjang.tambahJumlah', $item->id) }}"
                                      method="POST">
                                    @csrf
                                    <button type="submit"
                                        {{ $item->jumlah >= $item->stok ? 'disabled' : '' }}>+</button>
                                </form>
                            </td>
                            <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('keranjang.hapus', $item->id) }}"
                                      method="POST">
                                    @csrf
                                    <button type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total">
                Total: Rp{{ number_format($total, 0, ',', '.') }}
            </div>

            <form action="{{ route('keranjang.kosongkan') }}" method="POST">
                @csrf
                <button type="submit">Kosongkan Keranjang</button>
            </form>
        @endif
    </main>
</body>
</html>
