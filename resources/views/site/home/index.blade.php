@extends('site.layout')

@section('content')
<style>
html, body {
    margin: 0;
    padding: 0;
    overflow-x: hidden; /* Ẩn thanh cuộn ngang */
}

.slider {
    position: relative;
    overflow: hidden;
    width: 100%;
    height: 100vh; /* Luôn full chiều cao màn hình */
}

.sliders {
    display: flex;
    transition: transform 0.8s ease;
}

.slide {
    min-width: 100%;
    position: relative;
    box-sizing: border-box;
}

.slide img {
    width: 100%;
    height: 100vh; /* Ảnh cao = màn hình */
    object-fit: cover; /* Ảnh fill khung, không méo */
}

/* Chữ căn giữa trên ảnh */
.slide p {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); /* căn giữa cả ngang lẫn dọc */
    color: white;
    font-size: 28px;
    text-align: center;
    text-shadow: 2px 2px 5px black;
    line-height: 1.5;
}
</style>

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
{{--  --}}
<div class="row">
    <div class="col-md-12">
        
    </div>
</div>
{{-- js --}}
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
@endsection
