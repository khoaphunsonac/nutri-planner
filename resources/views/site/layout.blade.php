<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

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
    <link rel="stylesheet" href="{{ asset('assets/user/css/register.css') }}">

    <title>Nutri Planner</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">
        {{-- <a class="navbar-brand" href="{{ route('index') }}"> --}}
            {{-- <img src="{{ asset('assets/admin/img/avatar/logo-fitfood.jpg') }}" alt="Logo"> --}}
            <img src="{{ asset('assets/admin/img/avatar/logochinh.png') }}" alt="logo fitfood" style="width: 80%; height: 37px;">
        </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        TRANG CHỦ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('meal.index') ? 'active' : '' }}" href="{{ route('meal.index') }}">
                        THỰC ĐƠN
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('nutri-calc') ? 'active' : '' }}" href="{{ route('nutri-calc') }}">
                        NUTRI-CALC
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tdee') ? 'active' : '' }}" href="{{ route('tdee') }}">
                        TDEE
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('feedbacks.create') ? 'active' : '' }}" href="{{ route('feedbacks.create') }}">
                        PHẢN HỒI
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contacts.index') ? 'active' : '' }}" href="{{ route('contacts.index') }}">
                        LIÊN HỆ
                    </a>
                </li>
                </ul>
                <div class="right-menu">
                    @if (Auth::check())
                        <div class="user-dropdown">
                            <span class="user-name-highlight">Xin chào {{ Auth::user()->username }}</span>
                            <div class="dropdown-menu">
                                {{-- nếu role admin thì mới có nút dashboard --}}
                                @if (Auth::user()->role === 'admin')
                                    <li>
                                    <a class="dropdown-item text-center" href="{{ route('dashboard') }}" >Dashboard</a>
                                </li>
                                @endif
                                <div class="dropdown-divider"></div> 
                                <form action="{{ route('register.logout') }}" method="post">
                                 @csrf
                                 <button type="submit" class="dropdown-item text-center">Đăng xuất</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('showRegister') }}" class="nav-link text-light">Đăng Ký</a>
                        <a href="{{ route('login') }}" class="nav-link text-light">Đăng Nhập</a>
                    @endif

                    {{-- Nút giỏ hàng --}}
                    <div class="cart-icon" style="cursor: pointer;">
                        <a href="{{ route('meal.showsavemeals') }}" >
                            <!-- <i class="bi bi-cart-fill" style="font-size: 1.5rem;"></i> -->
                            <img src="{{ asset('assets/admin/img/meal/cooking.png') }}" class="cart" alt="Logo" > 
                            
                             @php
                                $favoriteCount = 0;
                                $favoriteCount = 0;
                                    if(auth()->check() && !empty(auth()->user()->savemeal)) {
                                        $savedIds = array_filter(explode('-', auth()->user()->savemeal));
                                        $favoriteCount = App\Models\MealModel::whereIn('id', $savedIds)->count();
                                    }
                            @endphp
                            @if($favoriteCount > 0)
                                <span id="favoriteCountBadge" class="ms-1 badge bg-danger">{{ $favoriteCount }}</span>
                            @else
                                <span id="favoriteCountBadge" class="ms-1 badge bg-danger" style="display:none;"></span>
                            @endif
                        </a>
                    </div>
                    {{-- Popup --}}
                    <div id="loginRegisterPopup" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999;">
                        <div style="background:white; padding:20px; border-radius:8px; width:500px; margin:150px auto; text-align:center; position:relative;">
                            <h4>Bạn cần đăng nhập hoặc đăng ký</h4>
                            <p>Hãy chọn một trong hai để tiếp tục</p>
                            <div style="margin-top:15px;">
                                <a href="{{ route('login') }}" class="btn btn-primary" style="margin-right:5px;">
                                    <i class="bi bi-lock"></i> Đăng nhập
                                </a>
                                <a href="{{ route('register.submit') }}" class="btn btn-success">
                                    <i class="bi bi-person-plus-fill me-2"></i> Đăng ký
                                </a>
                            </div>
                            <button onclick="closeLoginRegisterPopup()" style="position:absolute; top:5px; right:8px; background:none; border:none; font-size:18px; cursor:pointer;">×</button>
                        </div>
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

        /* Script xử lý giỏ hàng */
        function handleCartClick() {
            @if(auth()->check())
                // Nếu đã đăng nhập → chuyển đến trang giỏ hàng
                window.location.href = "{{ route('meal.showsavemeals') }}";
            @else
                // Nếu chưa đăng nhập → hiện popup
                document.getElementById('loginRegisterPopup').style.display = 'block';
            @endif
        }

        function closeLoginRegisterPopup() {
            document.getElementById('loginRegisterPopup').style.display = 'none';
        }
    </script>
</body>

</html>
