<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
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
            border-radius: 18px;
            background: linear-gradient(135deg, #0f2027, #1f2937, #000000);
            ;
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            animation: fadeIn 0.5s ease-in-out;
        }

        .login-title {
            font-weight: 600;
            color: #fff;
        }

        .login-subtitle {
            font-size: 14px;
            color: #ccc;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #fff;
            border-radius: 10px;
            padding: 10px;
        }

        .form-control::placeholder {
            color: #bbb;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 2px #ff3b3b;
            color: #fff;
        }

        .btn-login {
            background: linear-gradient(135deg, #ff3b3b, #ff7a00);
            border: none;
            font-weight: 600;
            border-radius: 10px;
            padding: 10px;
            transition: 0.3s ease;
        }

        /* HOVER MENYALA */
        .btn-login:hover {
            box-shadow: 0 0 15px rgba(255, 59, 59, 0.8),
                        0 0 30px rgba(255, 122, 0, 0.7);
            transform: translateY(-2px);
        }

        /* OPTIONAL: saat diklik */
        .btn-login:active {
            transform: scale(0.97);
        }

        .captcha-img {
            cursor: pointer;
            border-radius: 10px;
            border: 1px solid #ccc;
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

    <div class="login-card shadow-lg">

        <div class="text-center mb-4">
            <h4 class="login-title">Sport Booking</h4>
            <div class="login-subtitle">Admin Panel</div>
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
    </div>

    <script>
        function refreshCaptcha() {
            document.getElementById('captcha-img').src = 'captcha.php?' + Date.now();
        }
    </script>

</body>

</html>