<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan | Toko Online</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a href="{{ route('products.index') }}" class="brand">
                Toko Online
            </a>

            <nav class="main-nav">
                <a href="{{ route('products.index') }}">Katalog</a>
                <a href="{{ route('cart.index') }}">Keranjang</a>
                <a href="{{ route('orders.index') }}">Riwayat Pesanan</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="page-intro">
            <p class="eyebrow">INFORMASI TRANSAKSI</p>
            <h1>Detail Pesanan</h1>
            <p>Informasi lengkap mengenai pesanan yang telah dibuat.</p>
        </section>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <section class="order-info-grid">
            <div class="order-info-card">
                <span class="info-label">Nomor Pesanan</span>
                <strong>{{ $order->id_order }}</strong>
            </div>

            <div class="order-info-card">
                <span class="info-label">Tanggal Pesanan</span>
                <strong>
                    {{ $order->tanggal_order->format('d-m-Y H:i') }}
                </strong>
            </div>

            <div class="order-info-card order-address-card">
                <span class="info-label">Alamat Pengiriman</span>
                <strong>{{ $order->alamat_pengiriman }}</strong>
            </div>
        </section>

        <section class="orders-card detail-card">
            <div class="orders-heading">
                <div>
                    <h2>Barang yang Dibeli</h2>
                    <p>Rincian barang dalam pesanan ini.</p>
                </div>
            </div>

            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($order->details as $detail)
                            <tr>
                                <td>
                                    <strong>
                                        {{ $detail->product->nama_barang }}
                                    </strong>
                                </td>

                                <td>
                                    Rp {{ number_format(
                                        (float) $detail->harga_satuan,
                                        0, ',', '.'
                                    ) }}
                                </td>

                                <td>{{ $detail->jumlah_beli }}</td>

                                <td class="table-price">
                                    Rp {{ number_format(
                                        (float) (
                                            $detail->harga_satuan *
                                            $detail->jumlah_beli
                                        ),
                                        0, ',', '.'
                                    ) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="order-total">
                <span>Total Pembayaran</span>
                <strong>
                    Rp {{ number_format(
                        (float) $order->total_harga,
                        0, ',', '.'
                    ) }}
                </strong>
            </div>
        </section>

        <div class="detail-actions">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                Kembali ke Riwayat
            </a>

            <a href="{{ route('products.index') }}" class="btn btn-primary">
                Lanjut Belanja
            </a>
        </div>
    </main>

    <footer class="site-footer">
        <p>&copy; {{ date('Y') }} Toko Online. Semua hak dilindungi.</p>
    </footer>
</body>
</html>
```