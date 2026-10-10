<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Toko Online</title>
</head>
<body>
    <h1>Login</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('login.process') }}">
        @csrf

        <label>Username atau email</label>
        <input name="login" value="{{ old('login') }}" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
    <a href="{{ route('products.index') }}">Kembali ke katalog</a>
</body>
</html>
