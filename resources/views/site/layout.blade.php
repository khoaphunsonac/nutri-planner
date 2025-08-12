<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- favicon --}}
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/admin/img/avatar/favicon.ico/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/admin/img/avatar/favicon.ico/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/admin/img/avatar/favicon.ico/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/admin/img/avatar/favicon.ico/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/admin/img/avatar/favicon.ico/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/admin/img/avatar/favicon.ico/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/admin/img/avatar/favicon.ico/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/admin/img/avatar/favicon.ico/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/admin/img/avatar/favicon.ico/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('assets/admin/img/avatar/favicon.ico/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/admin/img/avatar/favicon.ico/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/admin/img/avatar/favicon.ico/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/admin/img/avatar/favicon.ico/favicon-16x16.png') }}">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

     {{-- custom css --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/css/home.css') }}">

    <title>Nutri Planner</title>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('index') }}">
            {{-- <img src="{{ asset('assets/admin/img/avatar/logo-fitfood.jpg') }}" alt="Logo"> --}}
            <img src="{{ asset('assets/admin/img/avatar/logochinh.png') }}" alt="logo fitfood" style="width: 80%; height: 37px;">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="">TRANG CHỦ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link highlight" href="{{ route('meal.index') }}">THỰC ĐƠN</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">NUTRI-CALC</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">TDEE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="">PHẢN HỒI</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">LIÊN HỆ</a>
                </li>
            </ul>

            <div class="right-menu">
                <a href="" class="nav-link text-light">Đăng Ký</a>
                <a href="" class="nav-link text-light">Đăng Nhập</a>
                <div class="cart-icon">
                    <img src="https://cdn-icons-png.flaticon.com/512/833/833314.png" alt="cart" width="20">
                    <span>0</span>
                </div>
            </div>
        </div>
    </div>
    </nav>
     <!-- icon message -->
        <a href="" class="message-icon">
            <i class="bi bi-house-door"></i>
        </a>
    {{-- kế thừa --}}
    <div class="content-wrapper">
        @yield('content')
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelector('.message-icon').addEventListener('click', function (e) {
    e.preventDefault(); // chặn nhảy link mặc định
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // hiệu ứng cuộn mượt
    });
});
</script>
</body>
</html>