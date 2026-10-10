<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

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

        .dashboard-container {
            width: 100%;
            max-width: 600px;
            padding: 20px;
        }

        .dashboard-card {
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .dashboard-card h1 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #1e293b;
        }

        .welcome {
            font-size: 18px;
            color: #334155;
            margin-bottom: 10px;
        }

        .description {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .user-info {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .user-info p {
            margin: 6px 0;
            color: #334155;
        }

        .user-info strong {
            color: #1e293b;
        }

        .btn-logout {
            padding: 10px 20px;
            border: none;
            border-radius: 7px;
            background: #dc2626;
            color: white;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-logout:hover {
            background: #b91c1c;
        }
    </style>
</head>

<body>

    <div class="dashboard-container">
        <div class="dashboard-card">

            <h1>Dashboard</h1>

            <p class="welcome">
                Selamat datang, <strong>{{ Auth::user()->nama_lengkap }}</strong>!
            </p>

            <p class="description">
                Halaman ini hanya bisa dibuka setelah login.
            </p>

            <div class="user-info">
                <p>
                    <strong>Username:</strong>
                    {{ Auth::user()->username }}
                </p>
            </div>

            <form method="POST" action="{{ url('/logout') }}">
                @csrf

                <button type="submit" class="btn-logout">
                    Logout
                </button>
            </form>

        </div>
    </div>

</body>
</html>