<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <title>Nutri Planner</title>

    <!-- Bootstrap, Icons, Font -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Noto+Sans&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/ingredients.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/dashboard.css') }}">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm bg-dash px-3 py-2">
    <div class="container-fluid">
        <!-- Nút menu mobile -->
        <button class="btn btn-outline-light d-lg-none me-2" onclick="toggleSidebar()">☰</button>

        <!-- Logo -->
        <a class="navbar-brand text-light" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/admin/img/avatar/logochinh.png') }}" alt="logo fitfood" style="height: 37px;">
        </a>

        <!-- Phần bên phải -->
        <div class="d-flex align-items-center ms-auto">
            @auth
                <span class="text-light me-3 d-none d-sm-inline">Xin chào, {{ Auth::user()->username }}</span>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/admin/img/avatar/admin.jpg') }}" alt="admin" width="36" height="36"
                             class="rounded-circle border border-light">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                        {{-- <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Hồ sơ</a></li> --}}
                        {{-- <li><hr class="dropdown-divider"></li> --}}
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}">
                                <i class="bi bi-house"></i> Trang chủ
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </div>
</nav>


    <!-- Overlay for mobile -->
    <div class="overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>


    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">
            <div class="sidebar-header p-3">
                <h5 class="m-0">🍴 Nutri Planner</h5>
            </div>
        </a>
        {{-- hiện vãn chưa có link được nha anh em test link bên anh em đi --}}
        <a href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="{{ route('meals.index') }}"><i class="bi bi-egg-fried"></i> Món ăn</a>
        <a href="{{ route('ingredients.index') }}"><i class="bi bi-basket"></i> Nguyên liệu</a>
        <a href="{{ route('users.index') }}"><i class="bi bi-people"></i> Người dùng</a>
        <a href="{{ route('allergens.index') }}"><i class="bi bi-exclamation-triangle"></i> Dị ứng</a>
        <a href="{{ route('tags.index') }}"><i class="bi bi-tags"></i> Thẻ</a> <!-- Đã thêm mục này -->
        <a href="{{ route('contact.index') }}"><i class="bi bi-envelope"></i> Liên hệ</a>
        <a href="{{ route('feedbacks.index') }}"><i class="bi bi-chat-dots"></i> Phản hồi</a>
        <a href="{{ route('diettypes.index') }}"><i class="bi bi-list-ul"></i> Loại chế độ ăn</a>
        <a href="{{ route('admin.meal_types.index') }}"><i class="bi bi-grid"></i> Loại món ăn</a>
    </aside>

    <!-- Main content mọi content kế thừa của anh em sẽ vô đây -->
    <div class="content-wrapper">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show m-3" role="alert">
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }
    </script>
</body>

</html>
