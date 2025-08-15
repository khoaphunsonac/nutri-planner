<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- favicon --}}
    <link rel="apple-touch-icon" sizes="57x57"
        href="{{ asset('assets/admin/img/avatar/favicon.ico/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60"
        href="{{ asset('assets/admin/img/avatar/favicon.ico/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72"
        href="{{ asset('assets/admin/img/avatar/favicon.ico/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76"
        href="{{ asset('assets/admin/img/avatar/favicon.ico/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114"
        href="{{ asset('assets/admin/img/avatar/favicon.ico/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120"
        href="{{ asset('assets/admin/img/avatar/favicon.ico/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144"
        href="{{ asset('assets/admin/img/avatar/favicon.ico/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="152x152"
        href="{{ asset('assets/admin/img/avatar/favicon.ico/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('assets/admin/img/avatar/favicon.ico/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"
        href="{{ asset('assets/admin/img/avatar/favicon.ico/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('assets/admin/img/avatar/favicon.ico/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96"
        href="{{ asset('assets/admin/img/avatar/favicon.ico/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('assets/admin/img/avatar/favicon.ico/favicon-16x16.png') }}">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                <img src="{{ asset('assets/admin/img/avatar/logochinh.png') }}" alt="logo fitfood"
                    style="width: 80%; height: 37px;">
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
                        <a class="nav-link" href="{{ route('nutri-calc') }}">NUTRI-CALC</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tdee') }}">TDEE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('feedbacks.create') }}">PHẢN HỒI</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">LIÊN HỆ</a>
                    </li>
                </ul>

                <div class="right-menu">
                    <a href="" class="nav-link text-light">Đăng Ký</a>
                    <a href="" class="nav-link text-light">Đăng Nhập</a>
                    <div class="cart-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/833/833314.png" alt="cart"
                            width="20">
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
    <div class="row">
        <footer class="footer-main">
            <div class="container">
                <a href="/" class="mb-4 d-block">
                    <img src="{{ asset('assets/admin/img/avatar/logochinh.png') }}" style="width: 130px;" />
                </a>
                <div class="widget-footer mb-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h4>Công ty TNHH NUTRI PLANNER</h4>
                            <p>
                                <strong>Địa chỉ</strong> 778/10 Đ. Nguyễn Kiệm, Phường 3, Phú Nhuận, Hồ Chí Minh 700990,
                                Vietnam<br />
                                <strong>Điện thoại</strong> (+84) 932 788 120 [hotline]<br />
                                <strong>Email</strong> info@fitfood.vn.<br />
                                <strong>MST</strong> 0313272749 do Sở kế hoạch và đầu tư TPHCM cấp ngày 26/05/2015
                            </p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <h4>Theo dõi chúng tôi tại </h4>
                            <div class="social mb-3">
                                <a href="https://www.facebook.com/fitfoodvietnam" target="_blank">
                                    <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png"
                                        alt="fitfoodvietnam" border="0" />
                                </a>
                                <a href="https://www.instagram.com/fitfoodvn" target="_blank">
                                    <img src="https://cdn-icons-png.flaticon.com/512/174/174855.png" alt="fitfoodvn"
                                        border="0" />
                                </a>
                                <a href="https://www.youtube.com/watch?v=CJ6eTsFdd1I" target="_blank">
                                    <img src="https://cdn-icons-png.flaticon.com/512/1384/1384060.png" alt="fitfoodvn"
                                        border="0" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="copyright mb-0">© Copyright 2025 NUTRI PLANNER. All rights reserved.</p>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        document.querySelector('.message-icon').addEventListener('click', function(e) {
            e.preventDefault(); // chặn nhảy link mặc định
            window.scrollTo({
                top: 0,
                behavior: 'smooth' // hiệu ứng cuộn mượt
            });
        });
    </script>
</body>

</html>
