
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan | Toko Online</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a href="{{ route('products.index') }}" class="brand">
                <span class="brand-title">Toko Online</span>
                <span class="brand-tagline">Riwayat transaksi kamu</span>
            </a>

            <nav class="main-nav">
                <a href="{{ route('products.index') }}" class="nav-link">Katalog</a>
                <a href="{{ route('cart.index') }}" class="nav-link">Keranjang</a>
                <a href="{{ route('orders.index') }}" class="nav-link">Riwayat Pesanan</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="page-intro">
            <h1>Riwayat Pesanan</h1>
            <p>Daftar transaksi yang pernah kamu lakukan.</p>
        </section>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($orders->isEmpty())
            <section class="empty-state">
                <h2>Belum ada pesanan</h2>
                <p>Pesanan yang sudah berhasil checkout akan muncul di sini.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    Mulai Belanja
                </a>
            </section>
        @else
            <section class="orders-card">
                <div class="orders-heading">
                    <h2>Daftar Transaksi</h2>
                    <span>{{ $orders->count() }} pesanan</span>
                </div>

                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nomor Pesanan</th>
                                <th>Tanggal</th>
                                <th>Total Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        <strong>{{ $order->id_order }}</strong>
                                    </td>
                                    <td>
                                        {{ $order->tanggal_order->format('d-m-Y H:i') }}
                                    </td>
                                    <td class="table-price">
                                        Rp {{ number_format((float) $order->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('orders.show', $order->id_order) }}"
                                            class="btn btn-primary btn-small"
                                        >
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    </main>

    <footer class="site-footer">
        <p>&copy; {{ date('Y') }} Toko Online</p>
    </footer>
</body>
</html>
