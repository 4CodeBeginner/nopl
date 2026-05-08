<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg,
                    #0d47a1,
                    #1976d2,
                    #43a047,
                    #fdd835);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 18px;
            overflow: hidden;
            background: #fff;
        }

        .login-header {
            text-align: center;
            padding: 30px 25px 20px;
        }

        .login-header img {
            width: 120px;
            margin-bottom: 15px;
        }

        .login-header h3 {
            font-weight: 700;
            color: #212529;
            margin-bottom: 5px;
        }

        .login-header p {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 0;
        }

        .card-body {
            padding: 25px;
        }

        .form-label {
            font-weight: 600;
            font-size: 14px;
        }

        .input-group-text {
            background: #f1f3f5;
            border-radius: 10px 0 0 10px;
        }

        .form-control {
            height: 48px;
            border-radius: 0 10px 10px 0;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #1976d2;
        }

        .btn-login {
            height: 48px;
            border-radius: 10px;
            font-weight: 600;
            background: #1976d2;
            border: none;
            transition: 0.2s;
        }

        .btn-login:hover {
            background: #0d47a1;
        }

        .alert {
            font-size: 14px;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="card shadow-lg login-card">

        <!-- HEADER -->
        <div class="login-header">

            <img src="{{ asset('img/emstoys.png') }}" alt="Logo">

            <h3>Admin Login</h3>

            <p>
                Silakan login untuk mengakses dashboard
            </p>

        </div>

        <!-- BODY -->
        <div class="card-body">

            {{-- ERROR --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="/login">

                @csrf

                <!-- EMAIL -->
                <div class="mb-3">

                    <label class="form-label">
                        Email
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>

                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Masukkan email" value="{{ old('email') }}" required>

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

                <!-- PASSWORD -->
                <div class="mb-4">

                    <label class="form-label">
                        Password
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>

                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password"
                            required>

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

                <!-- BUTTON -->
                <button type="submit" class="btn btn-primary w-100 btn-login">

                    <i class="bi bi-box-arrow-in-right"></i>
                    Login

                </button>

            </form>

        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
