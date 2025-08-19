@extends('site.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="slider">
            <div class="sliders">
                <div class="slide">
                    <img src="https://fitfood.vn/img/1920x800/images/nen-web-16950958311174.webp?f=jpg" alt="meal">
                    <p>TRẢI NGHIỆM BỮA ĂN SẠCH
                        <br>
                        <strong style="font-size: 43px; color: aliceblue">TƯƠI NGON GIÀU DINH DƯỠNG</strong>
                    </p>
                </div>
                <div class="slide">
                    <img src="https://fitfood.vn/img/1920x800/images/nen-final-1-1695095846415.webp?f=jpg" alt="meal">
                    <p>KẾ HOẠCH BỮA ĂN HÀNG TUẦN
                        <br>
                        <strong style="font-size: 43px; color: aliceblue">CHO MỘT LỐI SỐNG LÀNH MẠNH</strong>
                    </p>
                </div>
                <div class="slide">
                    <img src="https://fitfood.vn/img/1920x800/images/nen-final-2-16947528537416.webp?f=jpg" alt="meal">
                    <p>GIẢI PHÁP HEALTHY FOOD
                        <br>
                        <strong style="font-size: 43px; color: aliceblue">BỮA ĂN SẠCH</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ảnh chéo với text --}}
<div class="row">
    <div class="col-md-12">
    <section class="main-about">
    <div class="image">
        {{-- demo tạm ảnh này --}}
      <img src="https://images.pexels.com/photos/17326174/pexels-photo-17326174.jpeg?cs=srgb&dl=pexels-solehuddin-din-147017742-17326174.jpg&fm=jpg" alt="FITFOOD VIETNAM" />
    </div>
    <div class="content">
      <h1 class="title">NUTRI PLANNER</h1>
      <p>NUTRI PLANNER cung cấp các phần ăn lành mạnh hàng tuần giúp bạn duy trì một lối sống khỏe. Chúng tôi tập trung vào chế độ ăn cân bằng được thiết kế chuyên biệt để hỗ trợ bạn kiểm soát cân nặng một cách hiệu quả nhất.</p>
      <p>Nếu bạn đang tìm kiếm những bữa ăn ngon và tốt cho sức khỏe được chuẩn bị sẵn ở Saigon thì Fitfood là một lựa chọn tối ưu. Thực đơn đa dạng với hơn 100 món của chúng tôi có thể giúp bạn thưởng thức mà không ngán trong hơn 1 tháng.</p>
    </div>
  </section>
</div>

{{-- display sp tiêu biểu --}}
</div>
  <div class="row mt-2" >
  <div class="col-md-12">
    <div class="render-meal new-meals-container">
      <div class="" style=" padding-top: 30px;">
          <h2 class="section-title " style="color: rgb(236, 236, 236);">Món ăn mới nhất</h2>
          <hr class="section-title-hr" >
      </div>
      <!-- <div class="content-meal">
        <a href="">
          <div class="meal-item">
            <img src="https://fitfood.vn/static/sizes/260x200-fitfood-goi-fit3-healthy-2-17521258413949.jpg" alt="meal">
            <h3>Gói Fit 3</h3>
            <p>Trưa - Tối. Best seller</p>
          </div>
        </a>
        <a href="">
          <div class="meal-item">
            <img src="" alt="meal">
            <h3>Gói Fit 3</h3>
            <p>Trưa - Tối. Best seller</p>
          </div>
        </a>
        <a href="">
          <div class="meal-item">
            <img src="" alt="meal">
            <h3>Gói Fit 3</h3>
            <p>Trưa - Tối. Best seller</p>
          </div>
        </a>
        <a href="">
          <div class="meal-item">
            <img src="" alt="meal">
            <h3>Gói Fit 3</h3>
            <p>Trưa - Tối. Best seller</p>
          </div>
        </a>
        <a href="">
          <div class="meal-item">
            <img src="" alt="meal">
            <h3>Gói Fit 3</h3>
            <p>Trưa - Tối. Best seller</p>
          </div>
        </a>
        <a href="">
          <div class="meal-item">
            <img src="" alt="meal">
            <h3>Gói Fit 3</h3>
            <p>Trưa - Tối. Best seller</p>
          </div>
        </a>
        <a href="">
          <div class="meal-item">
            <img src="" alt="meal">
            <h3>Gói Fit 3</h3>
            <p>Trưa - Tối. Best seller</p>
          </div>
        </a>
        <a href="">
          <div class="meal-item">
            <img src="https://fitfood.vn/static/sizes/260x200-fitfood-goi-fit3-healthy-2-17521258413949.jpg" alt="meal">
            <h3>Gói Fit 3</h3>
            <p>Trưa - Tối. Best seller</p>
          </div>
        </a>
      </div> -->

      {{-- hiển thị 8 món mới nhất --}}
      <div class=" container new  "> 
        {{-- <div class="section-header my-5" style=" color: white;">
          <h3 class="mb-0 d-block" >Món ăn mới nhất</h3>
          <hr style="
              display: inline-block;
              width: 19%; 
              height: 4px; 
              background-color: #ffffff; 
              border: none; 
              border-radius: 2px; 
              vertical-align: middle;
          ">
        </div> --}}
      
        <div class="row g-4">
      
          @foreach ($latestMeals as $latest)
            @php
                
                //tính toán dinh dưỡng
                
                    $totalPro = 0;
                    $totalCarbs= 0;
                    $totalFat= 0;
                    $totalKcal= 0;
                    foreach($latest->recipeIngredients as $pri){
                        $ingredient = $pri->ingredient;
                        if($ingredient){
                            $totalPro += $ingredient->protein;
                            $totalCarbs += $ingredient->carb;
                            $totalFat += $ingredient->fat;
                            $totalKcal += ($ingredient->protein*4) + ($ingredient->carb*4) + ($ingredient->fat*9);
                        }
                    }
                

                // hiển thị ảnh
                $image = $meal->image_url ?? '';
                $imageURL = $image ? url("uploads/meals/{$image}") : "https://placehold.co/300x400?text=No+Image";
                                              
            @endphp
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4" >
                <div class="card meal-card shadow-sm h-100" >
                        @php
                            $image = $latest->image_url ?? '';
                            $imageURL = $image ? url("uploads/meals/{$image}") : "https://placehold.co/300x400?text=No+Image";
                            $user = auth()->user();
                            $liked = false;
                            if ($user && $user->savemeal) {
                                $liked = in_array($latest->id, explode('-', $user->savemeal));
                            }
                        @endphp
                    
                
                    <a href="{{ route('meal.show', $latest->id) }}" class="text-decoration-none text-dark">
                        
                        <img src="{{ $imageURL }}" alt="{{ $latest->name }}"  class="card-img-top" style="height: 300px; object-fit: cover;">
                        
                        <div class="card-body ">
                            <h4 class="card-title my-3">{{ $latest->name }}</h4>
                            <p class="card-text text-muted ">{{ Str::limit($latest->description, 80) }}</p>
                            <div class="nutrition-info mt-auto pt-2">
                              <div class="d-flex flex-wrap gap-1">
                                <span class="badge bg-primary rounded-pill">{{ round($totalKcal) }} kcal</span>
                                <span class="badge bg-success rounded-pill">P: {{ round($totalPro) }}g</span>
                                <span class="badge bg-warning text-dark rounded-pill">C: {{ round($totalCarbs) }}g</span>
                                <span class="badge bg-danger rounded-pill">F: {{ round($totalFat) }}g</span>
                              </div>
                            </div>
                            {{-- <a href="{{route('meal.show',$meal->id)}}" class="btn btn-primary">Chi tiết</a> --}}
                          
                        </div>
                    </a>
                    {{-- Nút yêu thích --}}
                    <div style="position: absolute; top: 5px; right: 5px; display: inline;"  class="favorite-form">
                        @if(auth()->check())
                            <button type="button" class="btn btn-favorite position-absolute top-0 end-0 m-2"
                                    data-id="{{ $latest->id }}" style="background: rgba(0,0,0,0.1); border:none; cursor:pointer;">
                                <i class="fas fa-heart" style="color: {{ $liked?'red':'rgba(255,255,255,0.7)' }}; font-size:30px;"></i>
                            </button>
                        @endif
                    </div>
                </div>
                
            </div>
          @endforeach
      </div>
    </div>
  </div>
</div>

<div style="background-color: #ebebeb; padding: 50px 0;">
    <div class="container text-center my-5">
    <h2 style="letter-spacing: 2px;">
        CHUNG TAY BẢO VỆ <br><span style="font-size: 40px; font-weight: bold">MÔI TRƯỜNG</span>
    </h2>
    <div style="width: 50px; height: 5px; background-color: red; margin: 8px auto;"></div>

    <div class="row mt-5">
        <div class="col-md-4">
            <img src="https://fitfood.vn/img/346x288/uploads/dsc04248-15668117116574.JPG" alt="Túi" class="img-fluid rounded">
            <p class="mt-3 text-muted">
                Nhà cung cấp duy nhất sử dụng túi Nylon sinh học tự hủy thân thiện với môi trường
            </p>
        </div>
        <div class="col-md-4">
            <img src="https://fitfood.vn/img/346x288/uploads/dsc04268-15668122623444.JPG" alt="Hộp nhựa" class="img-fluid rounded">
            <p class="mt-3 text-muted">
                Rửa sạch lại hộp nhựa đen để nhận hoàn tiền 5,000 vnd cho mỗi 10 hộp
            </p>
        </div>
        <div class="col-md-4">
            <img src="https://fitfood.vn/img/346x288/uploads/dsc04263-15668117777881.JPG" alt="Muỗng nĩa" class="img-fluid rounded">
            <p class="mt-3 text-muted">
                NUTRI PLANNER chỉ cung cấp 01 bộ muỗng nĩa mỗi ngày để giảm thiểu rác thải nhựa
            </p>
        </div>
    </div>
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

// like
document.querySelectorAll('.btn-favorite').forEach(btn => {
    btn.addEventListener('click', async function(e){
        e.preventDefault();
        e.stopPropagation();

        const mealId = this.dataset.id;
        const icon = this.querySelector('i');

        try {
            const response = await fetch(`/meals/favorite/${mealId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            if(response.status === 401){
                window.location.href = "{{ route('login') }}";
                return;
            }

            const data = await response.json();

            if(data.status === 'success'){
                // 1. Thay đổi màu icon tim
                icon.style.color = data.saved ? 'red' : 'rgba(255,255,255,0.7)';

                // 2. Update badge giỏ hàng (layout)
                const badge = document.getElementById('favoriteCountBadge');
                if(data.favoriteCount > 0){
                    badge.textContent = data.favoriteCount;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            }

        } catch(err){
            window.location.href = "{{ route('login') }}";
        }
    });
});

</script>
@endsection
