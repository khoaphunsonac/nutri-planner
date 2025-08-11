<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/layout.css') }}">

    {{-- custom css --}}
    <link rel="stylesheet" href="{{ asset('assets/user/css/home.css') }}">

    <title>Fitfood VN</title>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="">
            <img src="{{ asset('assets/admin/img/avatar/logo-fitfood.jpg') }}" alt="Logo">
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
                    <a class="nav-link highlight" href="">THỰC ĐƠN</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="">PHẢN HỒI</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">ĐÁNH GIÁ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">MÁY TÍNH DINH DƯỠNG</a>
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
    </div>
    </nav>
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