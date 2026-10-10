
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang Belanja | Toko Online</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a href="{{ route('products.index') }}" class="brand">
                <span class="brand-title">Toko Online</span>
                <span class="brand-tagline">Keranjang belanja kamu</span>
            </a>

            <nav class="main-nav">
                <a href="{{ route('products.index') }}" class="nav-link">
                    Katalog
                </a>
                <a href="{{ route('orders.index') }}" class="nav-link">
                    Riwayat Pesanan
                </a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="page-intro">
            <h1>Keranjang Belanja</h1>
            <p>Periksa barang dan jumlah pesananmu sebelum checkout.</p>
        </section>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if ($items->isEmpty())
            <section class="empty-state">
                <h2>Keranjang masih kosong</h2>
                <p>Yuk, pilih barang yang kamu butuhkan.</p>
                <a href="{{ route('products.index') }}"
                   class="btn btn-primary">
                    Kembali ke Katalog
                </a>
            </section>
        @else
            <div class="cart-layout">
                <section class="cart-card">
                    <div class="cart-heading">
                        <h2>Barang yang Dipilih</h2>
                        <span>{{ $items->count() }} jenis barang</span>
                    </div>

                    @foreach ($items as $item)
                        <article class="cart-item">
                            <div class="cart-item-info">
                                <h3>{{ $item['product']->nama_barang }}</h3>
                                <p class="cart-item-price">
                                    Rp {{ number_format((float) $item['product']->harga, 0, ',', '.') }}
                                    <span>/ barang</span>
                                </p>
                                <p class="cart-item-subtotal">
                                    Subtotal:
                                    <strong>
                                        Rp {{ number_format((float) $item['subtotal'], 0, ',', '.') }}
                                    </strong>
                                </p>
                            </div>

                            <div class="cart-item-actions">
                                <form method="POST"
                                      action="{{ route('cart.update', $item['product']->id_barang) }}"
                                      class="quantity-form">
                                    @csrf

                                    <button
                                        type="submit"
                                        name="jumlah"
                                        value="{{ max(1, $item['jumlah'] - 1) }}"
                                        class="quantity-btn"
                                        aria-label="Kurangi jumlah"
                                        {{ $item['jumlah'] <= 1 ? 'disabled' : '' }}
                                    >−</button>

                                    <span class="quantity-value">
                                        {{ $item['jumlah'] }}
                                    </span>

                                    <button
                                        type="submit"
                                        name="jumlah"
                                        value="{{ min($item['product']->stok, $item['jumlah'] + 1) }}"
                                        class="quantity-btn"
                                        aria-label="Tambah jumlah"
                                        {{ $item['jumlah'] >= $item['product']->stok ? 'disabled' : '' }}
                                    >+</button>
                                </form>

                                <form method="POST"
                                      action="{{ route('cart.remove', $item['product']->id_barang) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-remove">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </article>
                    @endforeach

                    <a href="{{ route('products.index') }}" class="back-link">
                        ← Lanjut Belanja
                    </a>
                </section>

                <aside class="summary-card">
                    <h2>Ringkasan Pesanan</h2>

                    <div class="summary-row">
                        <span>Jenis barang</span>
                        <span>{{ $items->count() }}</span>
                    </div>

                    <div class="summary-row summary-total">
                        <span>Total</span>
                        <strong>
                            Rp {{ number_format((float) $total, 0, ',', '.') }}
                        </strong>
                    </div>

                    <form method="POST" action="{{ route('checkout') }}"
                          class="checkout-form">
                        @csrf

                        <label for="alamat_pengiriman">
                            Alamat Pengiriman
                        </label>

                        <textarea
                            id="alamat_pengiriman"
                            name="alamat_pengiriman"
                            rows="4"
                            required
                            placeholder="Masukkan alamat lengkap"
                        >{{ old('alamat_pengiriman', auth()->user()->alamat) }}</textarea>

                        @error('alamat_pengiriman')
                            <p class="field-error">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="btn btn-primary btn-block">
                            Checkout Sekarang
                        </button>
                    </form>
                </aside>
            </div>
        @endif
    </main>

    <footer class="site-footer">
        <p>&copy; {{ date('Y') }} Toko Online</p>
    </footer>
</body>
</html>
