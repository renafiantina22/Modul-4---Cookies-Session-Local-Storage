<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .login-card {
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .login-card h1 {
            margin: 0 0 8px;
            text-align: center;
            color: #1e293b;
        }

        .subtitle {
            margin-bottom: 25px;
            text-align: center;
            color: #64748b;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            color: #334155;
            font-weight: bold;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 14px;
            outline: none;
        }

        .form-group input:focus {
            border-color: #2563eb;
        }

        .error {
            margin-bottom: 18px;
            padding: 10px 12px;
            background: #fee2e2;
            color: #b91c1c;
            border-radius: 7px;
            font-size: 14px;
        }

        
        .success {
            margin-bottom: 18px;
            padding: 10px 12px;
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            border-radius: 7px;
            font-size: 14px;
            text-align: center;
        }


        .btn-login {
            width: 100%;
            padding: 11px;
            border: none;
            border-radius: 7px;
            background: #2563eb;
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-login:hover {
            background: #1d4ed8;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-card">


            <h1>Login</h1>
            <p class="subtitle">Masuk untuk membuka dashboard</p>

            @if (session('success'))
                <div class="success">
                    {{ session('success') }}
                </div>
            @endif


            @if (session('error'))
                <div class="error">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}">
                @csrf

                <div class="form-group">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Masukkan username"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >
                </div>

                <button type="submit" class="btn-login">
                    Masuk
                </button>
            </form>

        </div>
    </div>

</body>
</html>