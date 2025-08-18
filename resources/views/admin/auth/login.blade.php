<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Admin Login - NutriPlanner</title>
    <style>
        :root {
            --primary-orange: #f8a13c;
            --secondary-orange: #f57c00;
            --dark-orange: #e65100;
            --light-bg: #fffcf4;
            --white: #ffffff;
            --gray-light: #f8f9fa;
            --gray-muted: #6c757d;
            --shadow: 0 8px 25px rgba(248, 161, 60, 0.15);
            --shadow-hover: 0 12px 35px rgba(248, 161, 60, 0.25);
        }

        body {
            background-color: var(--light-bg);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image:
                radial-gradient(circle at 20% 80%, rgba(248, 161, 60, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(245, 124, 0, 0.1) 0%, transparent 50%);
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(248, 161, 60, 0.1);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .login-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-5px);
        }

        .login-header {
            background-color: var(--primary-orange);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
            pointer-events: none;
        }

        .brand-logo {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .login-header h2 {
            margin: 0 0 10px 0;
            font-weight: 700;
            font-size: 1.8rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .login-header p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .login-body {
            padding: 40px 30px 30px;
        }

        .form-floating {
            margin-bottom: 25px;
            position: relative;
        }

        .form-floating .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 15px 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--white);
            height: auto;
        }

        .form-floating .form-control:focus {
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 0.2rem rgba(248, 161, 60, 0.25);
            background-color: var(--white);
        }

        .form-floating label {
            padding: 15px 20px;
            color: var(--gray-muted);
            font-weight: 500;
        }

        .form-floating .form-control:focus~label,
        .form-floating .form-control:not(:placeholder-shown)~label {
            color: var(--secondary-orange);
            font-weight: 600;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray-muted);
            cursor: pointer;
            z-index: 10;
            padding: 5px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            background-color: rgba(248, 161, 60, 0.1);
            color: var(--primary-orange);
        }

        .form-check {
            margin: 25px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            margin: 0;
            border: 2px solid #e9ecef;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .form-check-input:checked {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
        }

        .form-check-input:focus {
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 0.2rem rgba(248, 161, 60, 0.25);
        }

        .form-check-label {
            font-size: 0.95rem;
            color: var(--gray-muted);
            cursor: pointer;
            font-weight: 500;
        }

        .btn-login {
            background-color: var(--primary-orange);
            border: none;
            border-radius: 25px;
            padding: 15px 20px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
        }

        .btn-login:hover {
            background-color: var(--secondary-orange);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 124, 0, 0.4);
            color: white;
        }

        .btn-home {
            background-color: transparent;
            border: 2px solid var(--primary-orange);
            color: var(--primary-orange);
            border-radius: 25px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-home:hover {
            background-color: var(--primary-orange);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(248, 161, 60, 0.3);
        }

        .alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 25px;
            padding: 15px 20px;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .security-note {
            background-color: var(--gray-light);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            margin-top: 20px;
            border: 1px solid rgba(248, 161, 60, 0.1);
        }

        .security-note small {
            color: var(--gray-muted);
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        /* Loading state */
        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-card {
                margin: 10px;
                border-radius: 15px;
            }

            .login-body {
                padding: 30px 20px 25px;
            }

            .login-header {
                padding: 30px 20px;
            }

            .brand-logo {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .login-header h2 {
                font-size: 1.5rem;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card {
            animation: fadeInUp 0.6s ease;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="brand-logo">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <h2>Admin Panel</h2>
                <p>NutriPlanner Management System</p>
            </div>

            <div class="login-body">
                <form method="POST" action="{{ route('admin.login.submit') }}" id="loginForm">
                    @csrf

                    {{-- Alert Messages --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    {{-- Username Field --}}
                    <div class="form-floating">
                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                            id="username" name="username" placeholder="Username" value="{{ old('username') }}"
                            autofocus>
                        <label for="username">
                            <i class="bi bi-person-fill me-2"></i>Tên đăng nhập
                        </label>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password Field --}}
                    <div class="form-floating">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Password">
                        <label for="password">
                            <i class="bi bi-lock-fill me-2"></i>Mật khẩu
                        </label>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="bi bi-eye-fill" id="passwordToggleIcon"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="row mb-3">
                        <div class="col-12 col-sm-7">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    <i class="bi bi-bookmark-fill me-1"></i>
                                    Ghi nhớ đăng nhập (30 ngày)
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-5 text-sm-end mt-2 mt-sm-0">
                            <a href="{{ route('password.request') }}" class="fw-semibold text-warning text-decoration-none">
                                Quên mật khẩu?
                            </a>
                        </div>
                    </div>

                    {{-- Login Button --}}
                    <button type="submit" class="btn btn-login" id="loginBtn">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        <span id="loginText">Đăng Nhập</span>
                        <span id="loginSpinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </span>
                    </button>

                    {{-- Home Button --}}
                    <div class="text-center">
                        <a href="{{ route('home') }}" class="btn-home">
                            <i class="bi bi-house-fill"></i>
                            Quay về trang chủ
                        </a>
                    </div>
                </form>

                {{-- Security Note --}}
                <div class="security-note">
                    <small>
                        <i class="bi bi-shield-check"></i>
                        Truy cập bảo mật vào hệ thống quản trị
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto focus on username field
        document.addEventListener('DOMContentLoaded', function() {
            const usernameField = document.getElementById('username');
            if (usernameField && !usernameField.value) {
                usernameField.focus();
            }
        });

        // Toggle password visibility
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('passwordToggleIcon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.className = 'bi bi-eye-slash-fill';
            } else {
                passwordField.type = 'password';
                toggleIcon.className = 'bi bi-eye-fill';
            }
        }

        // Form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function() {
            const loginBtn = document.getElementById('loginBtn');
            const loginText = document.getElementById('loginText');
            const loginSpinner = document.getElementById('loginSpinner');

            loginBtn.disabled = true;
            loginText.textContent = 'Đang xử lý...';
            loginSpinner.classList.remove('d-none');
        });

        // Enter key handling
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('loginForm').submit();
            }
        });

        // Enhanced form validation
        const usernameField = document.getElementById('username');
        const passwordField = document.getElementById('password');

        [usernameField, passwordField].forEach(field => {
            field.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    this.classList.remove('is-invalid');
                }
            });
        });
    </script>
</body>

</html>
