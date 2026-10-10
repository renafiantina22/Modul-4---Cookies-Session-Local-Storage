<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi - Toko Online</title>
</head>
<body>
    <h1>Registrasi Pengguna</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('register.process') }}">
        @csrf

        <label>Nama lengkap</label>
        <input name="nama_lengkap" value="{{ old('nama_lengkap') }}" maxlength="100" required>

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" maxlength="100" required>

        <label>Username</label>
        <input name="username" value="{{ old('username') }}" maxlength="50" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Konfirmasi password</label>
        <input type="password" name="password_confirmation" required>

        <label>Nomor HP</label>
        <input name="no_hp" maxlength="15" value="{{ old('no_hp') }}">

        <label>Alamat</label>
        <textarea name="alamat">{{ old('alamat') }}</textarea>

        <button type="submit">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
</body>
</html>
