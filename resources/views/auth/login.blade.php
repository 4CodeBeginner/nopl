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

    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            min-height: 100vh;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .login-header {
            background: #0d6efd;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .form-control {
            height: 50px;
            border-radius: 12px;
        }

        .btn-login {
            height: 50px;
            border-radius: 12px;
            font-weight: 600;
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            margin: auto;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 35px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">

            <div class="col-md-5">

                <div class="card shadow-lg login-card">

                    <div class="login-header">
                        <div class="icon-box mb-3">
                            <i class="bi bi-person-lock"></i>
                        </div>

                        <h3 class="fw-bold mb-1">Admin Login</h3>
                        <p class="mb-0">
                            Silakan login untuk mengakses dashboard
                        </p>
                    </div>

                    <div class="card-body p-4">

                        {{-- Alert Error --}}
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                {{ session('error') }}

                                <button type="button" class="btn-close" data-bs-dismiss="alert">
                                </button>
                            </div>
                        @endif

                        <form method="POST" action="/login">

                            @csrf

                            {{-- Email --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Email
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>

                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Masukkan email" value="{{ old('email') }}" required>

                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="mb-4">

                                <label class="form-label fw-semibold">
                                    Password
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>

                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Masukkan password" required>

                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>

                            {{-- Button --}}
                            <button type="submit" class="btn btn-primary w-100 btn-login">

                                <i class="bi bi-box-arrow-in-right"></i>
                                Login
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
