<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — PolLapor Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #1A237E 0%, #283593 50%, #3949AB 100%);
        }
        .login-card {
            background: #fff; border-radius: 16px; padding: 40px;
            width: 100%; max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
        }
        .login-brand {
            text-align: center; margin-bottom: 32px;
        }
        .login-brand h1 { font-size: 28px; font-weight: 800; color: #1A237E; }
        .login-brand h1 span { color: #FF6F00; }
        .login-brand p { color: #6B7280; font-size: 14px; margin-top: 4px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        .form-control {
            width: 100%; padding: 12px 16px; border: 1.5px solid #E5E7EB;
            border-radius: 10px; font-size: 15px; font-family: inherit;
            transition: border-color .2s;
        }
        .form-control:focus { outline: none; border-color: #1A237E; }
        .form-check { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
        .form-check label { font-size: 13px; color: #6B7280; cursor: pointer; }
        .btn-login {
            width: 100%; padding: 14px; border: none; border-radius: 10px;
            background: #1A237E; color: #fff; font-size: 16px; font-weight: 700;
            cursor: pointer; transition: background .2s; font-family: inherit;
        }
        .btn-login:hover { background: #283593; }
        .error-msg { color: #DC2626; font-size: 13px; margin-top: 6px; }
        .alert-error {
            background: #FEE2E2; color: #991B1B; padding: 12px 16px;
            border-radius: 8px; font-size: 14px; margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-brand">
            <h1>🏛️ Pol<span>Lapor</span></h1>
            <p>Panel Admin Jurusan</p>
        </div>

        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control"
                       value="{{ old('email') }}" placeholder="admin@pollapor.ac.id" required autofocus>
                @error('email') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control"
                       placeholder="••••••••" required>
                @error('password') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="form-check">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>
    </div>
</body>
</html>
