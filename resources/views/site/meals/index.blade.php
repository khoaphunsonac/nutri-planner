@extends('site.layout')

@section('content')
    {{-- style --}}
    <style>
        .shadow-text {
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .col-md-4 {
            padding-bottom: 30px; /* tạo khoảng trống dưới card */
        }

        .card.meal-card {
            transition: all 0.3s ease;
            cursor: pointer;
            overflow: hidden;
            position: relative;
        }

        .card.meal-card img {
            transition: all 0.3s ease;
            display: block;
            width: 100%;
            object-fit: cover; /* ảnh tràn khung */
            
        }

        .card.meal-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,0.9);
            /* z-index: 5; */
        }

        .card.meal-card:hover img {
            filter: brightness(70%);
        }

        .btn-favorite{
            cursor: pointer;
        }
        .btn-favorite{
            transform: scale(1.1);
            transition: 0.2s;
        }
        
    </style>

        
        <div class=" meal-header align-items-center text-center" style="background-image: url(https://fitfood.vn/img/2160x900/uploads/menu-16952880378313.jpg); ">
            <div class="container mb-3" style="">
                <h2 class="display-5 fw-bold text-white shadow-text">Kế hoạch món ăn mỗi bữa</h2>
                <!-- <p>11.08 <span>-</span> 17.08</p> -->
            </div>
        </div>
    
        
        {{-- form lọc + fillter--}}
        <div class="card p-4 mb-4 d-flex justify-content-around text-center">
            <div class="card-header bg-white border-0 ">
                <h3 class="card-title mb-0">Tìm kiếm món ăn</h3>
            </div>
            <div class="card-body ">
            <form action="{{route('meal.index')}}" class="mb-4" method="GET">
                <!-- search -->
                <div class="row g-2">
                    {{-- search --}}
                    <div class="col-md-10">
                        <input type="text" name="search" class="form-control @error('search') is-invalid @enderror" value="{{$search ?? old($search)}}" placeholder="Tìm món ăn, nguyên liệu hoặc chế độ ăn..." onchange="this.form.submit()"> {{-- tự động submit khi thay đổi --}}
                        
                    </div>
                    
                    {{-- Submit button --}}
                    <div class="col-md-2 ">
                       <button type="button" class="btn btn-secondary w-100"
                                onclick="document.querySelector('input[name=search]').value = '';">
                            Xóa
                        </button>
                    </div>
                    
                </div>
                <!-- fillter -->
                <div class="row g-2 mt-2 align-items-center  my-4" >
                    

                    {{-- Calories--}}
                    <div class="col-md-3" >
                        <select name="calories_range" 
                            class="form-select text-center" 
                            onchange="this.form.submit()" 
                            style="cursor: pointer"
                            data-bs-toggle="tooltip" 
                            data-bs-placement="bottom" 
                            title="1 Calorie (dinh dưỡng) = 1 Kcal =  1000 calories (khoa học)"
                        >
                            <option value="">-- Chọn khoảng Calories (Kcal) --</option>
                            <option value="0-500" {{ request('calories_range') == '0-500' ? 'selected' : '' }}>0 - 500</option>
                            <option value="500-1000" {{ request('calories_range') == '500-1000' ? 'selected' : '' }}>500 - 1000</option>
                            <option value="1000 - 1500" {{ request('calories_range') == '1000 - 1500' ? 'selected' : '' }}>1000 - 1500</option>
                            <option value="1500 - 2000" {{ request('calories_range') == '1500 - 2000' ? 'selected' : '' }}>1500 - 2000</option>
                            <option value="2000 - 2500" {{ request('calories_range') == '2000 - 2500' ? 'selected' : '' }}>2000 - 2500</option>
                            <option value="2500 - 3000" {{ request('calories_range') == '2500 - 3000' ? 'selected' : '' }}>2500 - 3000</option>

                        </select>
                    </div >
                    
                    {{-- fillter  diettype --}}
                    <div class="col-md-3" >
                        <select name="diet" class="form-select me-2 text-center" onchange="this.form.submit()" style="cursor: pointer">
                            <option value="">-- Chọn chế độ ăn --</option>
                            @foreach($dietTypes as $diet)
                                <option value="{{ $diet->id }}" {{ request('diet') == $diet->id ? 'selected' : '' }}>
                                    {{ $diet->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    

                    {{-- fillter  mealTypeFill--}}
                    <div class="col-md-3 ">
                        <select name="meal_type" class="form-select me-2 text-center" onchange="this.form.submit()" style="cursor: pointer">
                            <option value="">-- Chọn bữa ăn --</option>
                            @foreach($mealTypes as $mealType)
                                <option value="{{ $mealType->id }}" {{ request('meal_type') == $mealType->id ? 'selected' : '' }}>
                                    {{ $mealType->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- fillter  allergenFill--}}
                    <div class="col-md-3 position-relative">
                        <select name="allergen" class="form-select text-center" onchange="this.form.submit()" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Chọn để loại bỏ món ăn có chất dị ứng bạn không muốn. Ví dụ: đậu phộng, hải sản,..." style="cursor: pointer">
                            <option value="">-- Chọn chất dị ứng --</option>
                            @foreach($allergens as $allergen)
                                <option value="{{ $allergen->id }}" {{ request('allergen') == $allergen->id ? 'selected' : '' }}>
                                    {{ $allergen->name }}
                                </option>
                            @endforeach
                            

                        </select>
                    </div>

                </div>
                
                
            </form>
            
            </div>
        </div>

        <div class="card p-4  shadow-sm">
            <div class="card-body">
                @if( $meals->count() > 0)
                    
                    <div class="row g-4">
                            @foreach ($meals as $meal)
                                @php
                                    $totalPro = 0;
                                    $totalCarbs= 0;
                                    $totalFat= 0;
                                    $totalKcal= 0;
                                    

                                    foreach ($meal->recipeIngredients as $ing) {
                                        $ingredient = $ing->ingredient;
                                        if ($ingredient) {
                                            $quantity = $ing->quantity ?? 1;
                                            $totalPro += $ingredient->protein ;
                                            $totalCarbs += $ingredient->carb ;
                                            $totalFat += $ingredient->fat ;
                                            $totalKcal += ($ingredient->protein * 4) + ($ingredient->carb * 4) + ($ingredient->fat * 9);
                                        }
                                    }

                                    
                                @endphp
                            
                                <div class="col-md-4 ">
                                    
                                        <div class="card meal-card shadow-sm h-100" >
                                                @php
                                                    $image = $meal->image_url ?? '';
                                                    $imageURL = $image ? url("uploads/meals/{$image}") : "https://placehold.co/300x400?text=No+Image";
                                                    
                                                     
                                                @endphp
                                            
                                        
                                            <a href="{{ route('meal.show', $meal->id) }}" class="text-decoration-none text-dark">
                                                <img src="{{ $imageURL }}" alt="{{ $meal->name }}"  class="card-img-top" style="height: 300px; object-fit: cover;">
                                                

                                                <div class="card-body ">
                                                    <h4 class="card-title my-3">{{ $meal->name }}</h4>
                                                    <p class="card-text text-muted ">{{ Str::limit($meal->description, 80) }}</p>
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
                                            <div style="position: absolute; top: 10px; right: 10px; display: inline;"  class="favorite-form">
                                                @php
                                                    $saved = auth()->check() && auth()->user()->savemeal && in_array($meal->id, explode('-', auth()->user()->savemeal));
                                                @endphp

                                                @if(auth()->check())
                                                    {{-- Đã đăng nhập → dùng form POST để lưu --}}
                                                    
                                                        <button type="button" 
                                                            class="btn btn-favorite " 
                                                            data-id="{{ $meal->id }}" 
                                                            aria-label="Yêu thích"
                                                            style="font-size: 20px; background: rgba(0,0,0,0.1); border: none; cursor: pointer;">
                                                            <i class="fas fa-heart" style="color: {{ $saved ? 'red' : 'rgba(255,255,255,0.7)' }};"></i>
                                                        </button>
                                                    
                                                @else
                                                    {{-- Chưa đăng nhập → hiện nút gọi cảnh báo --}}
                                                    <button class="btn btn-favorite" 
                                                        type="button" 
                                                        style="font-size: 20px; background: rgba(0,0,0,0.1); border: none; cursor: pointer;"
                                                        onclick="showLoginRegisterPopup()">
                                                        <i class="fas fa-heart" style="color: rgba(255,255,255,0.7);"></i>
                                                    </button>
                                                @endif
                                                
                                            </div>
                                        </div>
                                    
                                </div>
                            
                            
                        @endforeach
                        {{-- Popup --}}
                        <div id="loginRegisterPopup" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
                            <div style="background:white; padding:20px; border-radius:8px; width:500px; margin:150px auto; text-align:center; position:relative;">
                                <h4>Bạn cần đăng nhập hoặc đăng ký</h4>
                                <p>Hãy chọn một trong hai để tiếp tục</p>
                                <div style="margin-top:15px;">
                                    <a href="{{ route('login') }}" class="btn btn-primary" style="margin-right:5px;"><i class="bi bi-lock"></i> Đăng nhập</a>
                                    <a href="{{ route('register.submit') }}" class="btn btn-success"><i class="bi bi-person-plus-fill me-2"></i>Đăng ký</a>
                                </div>
                                <button onclick="closeLoginRegisterPopup()" style="position:absolute; top:5px; right:8px; background:none; border:none; font-size:18px; cursor:pointer;">×</button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning text-center mx-auto" style="width: 40%">
                        
                            {{-- @if(!empty($search)&& !empty($mealTypeName))
                            Không có kết quả tìm kiếm nào  "<strong>{{ $search }}</strong>" và loại "<strong>{{ $mealTypeName }}</strong>"
                        @elseif(!empty($mealTypeName))
                            Không có món ăn nào cho loại "<strong>{{ $mealTypeName }}</strong>"
                        @elseif(!empty($search))
                            Không có kết quả tìm kiếm cho "<strong>{{ $search }}</strong>".
                        @endif --}}
                        <div class="alert alert-warning">
                            Không có kết quả hiển thị  
                            @if (!empty($searchConditions))
                                cho {{ implode(' và ', $searchConditions) }}
                            @endif
                        </div>
                    </div>
                @endif
                
                {{--phan trang  --}}
                <div>
                    {{$meals->appends(request()->except('meals_page'))->links('pagination::bootstrap-5')}}
                </div>
                

                
            </div>

        </div>
   

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // document.addEventListener('DOMContentLoaded', function () {
    // document.querySelectorAll('.favorite-form').forEach(function (form) {
    //         form.addEventListener('click', function (event) {
    //             event.stopPropagation(); // Ngăn click lan ra ngoài
    //         });
    //     });
    // });

    function showLoginRegisterPopup(){
        document.getElementById('loginRegisterPopup').style.display = 'block';
    }
    function closeLoginRegisterPopup(){
        document.getElementById('loginRegisterPopup').style.display = 'none';
    }


document.querySelectorAll('.btn-favorite').forEach(btn => {
    btn.addEventListener('click', async function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        if (!this.dataset.id) {
            showLoginRegisterPopup();
            return;
        }

        const mealId = this.dataset.id;
        const icon = this.querySelector('i');
        
        try {
            const response = await fetch(`/meals/favorite/${mealId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();
            
            if (data.status === 'success') {
                // 1. Cập nhật icon tim
                icon.style.color = data.saved ? 'red' : 'rgba(255,255,255,0.7)';
                
                // 2. Cập nhật số lượng trong giỏ hàng
                const badge = document.getElementById('favoriteCountBadge');
                if (data.favoriteCount > 0) {
                    badge.textContent = data.favoriteCount;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
                
                // 3. Hiển thị thông báo
                alert(data.message); // Có thể thay bằng toast đẹp hơn
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Lỗi hệ thống');
        }
    });
});

    
</script>
@endsection