<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Login</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow" style="max-width: 400px; width: 100%;">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Đăng nhập</h2>
                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" name="username" id="username" class="form-control"
                            value="{{ old('username') }}" autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu:</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger mt-2">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
