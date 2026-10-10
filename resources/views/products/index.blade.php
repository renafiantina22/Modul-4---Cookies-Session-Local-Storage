<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Barang | Toko Online</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a href="{{ url('/') }}" class="brand">
                <span class="brand-title">Toko Online</span>
                <span class="brand-tagline">Temukan kebutuhanmu dengan mudah.</span>
            </a>

            <nav class="main-nav">
                @if (auth()->check())
                    <span class="welcome">
                        Halo, {{ auth()->user()->nama_lengkap }}
                    </span>

                    <a href="{{ url('/') }}" class="nav-link">Katalog</a>
                    <a href="{{ route('cart.index') }}" class="nav-link">
                        Keranjang
                    </a>
                    <a href="{{ route('orders.index') }}" class="nav-link">
                        Riwayat Pesanan
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-light btn-small">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-light btn-small">
                        Daftar
                    </a>
                @endif
            </nav>
        </div>
    </header>

    <main class="container">
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

        <section class="page-intro">
            <h1>Katalog Barang</h1>
            <p>Silakan lihat produk yang tersedia di toko kami.</p>
        </section>

        <section class="products-grid">
            @forelse ($products as $product)
                <article class="product-card">
                    <div class="product-image-wrap">
                        <img
                            src="{{ asset('images/products/' . $product->gambar) }}"
                            alt="{{ $product->nama_barang }}"
                            class="product-image"
                            onerror="this.onerror=null; this.src='https://placehold.co/400x300/f1f3f5/687582?text=Produk';"
                        >
                    </div>

                    <div class="product-info">
                        <h2>{{ $product->nama_barang }}</h2>

                        <p class="product-description">
                            {{ $product->deskripsi }}
                        </p>

                        <p class="product-price">
                            Rp {{ number_format((float) $product->harga, 0, ',', '.') }}
                        </p>

                        @if ($product->stok > 0)
                            <p class="product-stock">
                                Stok: {{ $product->stok }}
                            </p>
                        @else
                            <p class="product-stock stock-empty">
                                Stok habis
                            </p>
                        @endif

                        @if ($product->stok > 0)
                            <form
                                method="POST"
                                action="{{ route('cart.add', $product->id_barang) }}"
                            >
                                @csrf
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-block"
                                >
                                    Masukkan ke Keranjang
                                </button>
                            </form>
                        @else
                            <button
                                type="button"
                                class="btn btn-disabled btn-block"
                                disabled
                            >
                                Stok Habis
                            </button>
                        @endif
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <h2>Belum ada barang</h2>
                    <p>Produk akan ditampilkan di sini setelah tersedia.</p>
                </div>
            @endforelse
        </section>
    </main>

    <footer class="site-footer">
        <p>&copy; {{ date('Y') }} Toko Online</p>
    </footer>
</body>
</html>
