<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #22c55e, #3b82f6);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 380px;
            padding: 30px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            animation: fadeIn 0.5s ease-in-out;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .login-title {
            font-weight: 700;
            color: #1e293b;
        }

        .login-subtitle {
            font-size: 14px;
            color: #64748b;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
        }

        .form-control:focus {
            box-shadow: 0 0 0 2px #22c55e;
        }

        .btn-login {
            background: linear-gradient(135deg, #22c55e, #3b82f6);
            border: none;
            font-weight: 600;
            border-radius: 10px;
            padding: 10px;
            color: white;
            transition: 0.3s;
        }

        .btn-login:hover {
            box-shadow: 0 0 15px rgba(34, 197, 94, 0.7),
                0 0 25px rgba(59, 130, 246, 0.6);
            transform: translateY(-2px);
        }

        .btn-login:active {
            transform: scale(0.97);
        }

        .captcha-img {
            cursor: pointer;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .extra-link a {
            text-decoration: none;
            color: #2563eb;
        }

        .extra-link a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="login-card">

        <div class="text-center mb-4">
            <h4 class="login-title">⚽ Sport Booking</h4>
            <div class="login-subtitle">User Login</div>
        </div>

        <form action="proses_login.php" method="POST">

            <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>

            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

            <div class="text-center mb-3">
                <img src="captcha.php" id="captcha-img"
                    onclick="refreshCaptcha()"
                    class="captcha-img">
            </div>

            <input type="text" name="captcha" class="form-control mb-4" placeholder="Masukkan captcha" required>

            <button class="btn btn-login w-100">Login</button>

        </form>

        <div class="text-center mt-3 extra-link">
            <p><small>Belum punya akun?</small><a href="register.php"> Daftar</a></p>
        </div>

    </div>

    <script>
        function refreshCaptcha() {
            document.getElementById('captcha-img').src = 'captcha.php?' + Date.now();
        }
    </script>

</body>

</html>