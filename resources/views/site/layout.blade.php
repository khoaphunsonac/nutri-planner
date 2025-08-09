<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/layout.css') }}">
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
                    <a class="nav-link" href="">LIÊN HỆ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">FAQS</a>
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
        <!-- icon message -->
        <a href="" class="message-icon" title="Chao đổi với chúng tôi">
            <img src="https://cdn-icons-png.flaticon.com/512/726/726623.png" alt="message">
        </a>
    </div>
    </nav>
    
    <div class="row">
        <div class="col-md-12">
            <div class="slider">
    <div class="sliders">
        <div class="slide">
            <img src="https://fitfood.vn/img/1920x800/images/nen-web-16950958311174.webp?f=jpg" alt="meal">
            <p>TRẢI NGHIỆM BỮA ĂN SẠCH
                <br>
                <strong>TƯƠI NGON GIÀU DINH DƯỠNG</strong>
            </p>
        </div>
        <div class="slide">
            <img src="https://fitfood.vn/img/1920x800/images/nen-final-1-1695095846415.webp?f=jpg" alt="meal">
            <p>KẾ HOẠCH BỮA ĂN HÀNG TUẦN
                <br>
                <strong>CHO MỘT LỐI SỐNG LÀNH MẠNH</strong>
            </p>
        </div>
        <div class="slide">
            <img src="https://fitfood.vn/img/1920x800/images/nen-final-2-16947528537416.webp?f=jpg" alt="meal">
            <p>GIẢI PHÁP HEALTHY FOOD
                <br>
                <strong>BỮA ĂN SẠCH</strong>
            </p>
        </div>
    </div>
</div>

        </div>
    </div>
    {{-- kế thừa --}}
    <div class="content-wrapper">
        @yield('content')
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
let index = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

function showSlide() {
    index++;
    if (index >= totalSlides) index = 0;
    document.querySelector('.sliders').style.transform = `translateX(-${index * 100}%)`;
}

setInterval(showSlide, 3000); // 3 giây đổi 1 ảnh
</script>

</body>
</html>
