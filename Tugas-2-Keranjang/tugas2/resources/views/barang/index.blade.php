
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Alat Tulis</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header>
        <h2>Toko Alat Tulis</h2>
        <a href="{{ route('keranjang.index') }}">
            Keranjang ({{ $jumlahKeranjang }})
        </a>
    </header>

    <main class="container">
        <h1>Daftar Barang</h1>
        <p class="subtitle">Pilih barang yang ingin dimasukkan ke keranjang.</p>

        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <div class="product-grid">
            @foreach ($barangs as $barang)
                <div class="card">
                    <h3>{{ $barang->nama_barang }}</h3>

                    <p class="price">
                        Rp{{ number_format($barang->harga, 0, ',', '.') }}
                    </p>

                    <p class="stock">Stok: {{ $barang->stok }}</p>

                    @if ($barang->stok > 0)
                        <form action="{{ route('keranjang.tambah', $barang->id) }}"
                              method="POST">
                            @csrf
                            <button type="submit">Tambah ke Keranjang</button>
                        </form>
                    @else
                        <button type="button" disabled>Stok Habis</button>
                    @endif
                </div>
            @endforeach
        </div>
    </main>
</body>
</html>
