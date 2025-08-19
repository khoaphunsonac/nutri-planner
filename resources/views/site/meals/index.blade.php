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

        
        <div class=" meal-header align-items-center text-center" >
            <div class="container mb-3" >
                <h2 class="display-5 fw-bold text-white shadow-text">Kế hoạch món ăn mỗi bữa</h2>
                <div class="scroll-down-icon">
                    <i class="fas fa-arrow-down text-white fa-3x animate-bounce"></i>
                </div>
            </div>
        </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
        
        {{-- form lọc + fillter--}}
        <div class="card p-4 my-5 d-flex justify-content-around text-center">
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
                                onclick="const form = this.closest('form'); 
                            form.querySelectorAll('input, select').forEach(el => el.value=''); 
                            form.submit();">
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
                                    foreach($meal->recipeIngredients as $pri){
                                        $ingredient = $pri->ingredient;
                                        if($ingredient){
                                            $quantity = $pri->quantity ?? 1; // Lấy quantity từ recipe_ingredients
                                            // Tính P/C/F = (giá trị trong ingredient) * (quantity / 100) 
                                            // Tính toán P/C/F: nếu có quantity thì chia 10, không thì lấy giá trị gốc
                                            $pro = ($ingredient->protein ?? 0) * ($quantity > 1 ? ($quantity/100) : 1);
                                            $carb = ($ingredient->carb ?? 0) * ($quantity > 1 ? ($quantity/100) : 1);
                                            $fat = ($ingredient->fat ?? 0) * ($quantity > 1 ? ($quantity/100) : 1);

                                            $totalPro += $pro;
                                            $totalCarbs += $carb;
                                            $totalFat += $fat;
                                            $totalKcal += $pri->total_calo ?? 0;
                                        }
                                    }

                                    
                                @endphp
                            
                                <div class="col-md-3 ">
                                    
                                        <div class="card meal-card shadow-sm h-100" data-url="{{ route('meal.show', $meal->id) }}" >
                                                @php
                                                    $image = $meal->image_url ?? '';
                                                    $imageURL = $image ? url("uploads/meals/{$image}") : "https://placehold.co/300x400?text=No+Image";
                                                    
                                                     
                                                @endphp
                                            
                                        
                                            
                                            <a href="{{ route('meal.show', $meal->id) }}" class="text-decoration-none text-dark">
                                                <div class="image-wrapper " style="position: relative; width: 100%; padding-top: 75%; /* 4:3 ratio */ overflow: hidden;">
                                                    <img src="{{ $imageURL }}" alt="{{ $meal->name }}" 
                                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                                </div>
                                                

                                                <div class="card-body ">
                                                    <h4 class="card-title my-3">{{ $meal->name }}</h4>
                                                    <p class="card-text text-muted ">{{ Str::limit($meal->description, 80) }}</p>
                                                    <div class="nutrition-info mt-auto pt-2">
                                                        <div class="d-flex flex-wrap gap-1">
                                                            <span class="badge bg-primary rounded-pill">{{ round($totalKcal,1) }} kcal</span>
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
                                                    $user = auth()->user();
                                                    $liked = false;
                                                    if ($user && $user->savemeal) {
                                                        $liked = in_array($meal->id, explode('-', $user->savemeal));
                                                    }
                                                @endphp

                                                    
                                                <button type="button" 
                                                    class="btn btn-favorite " 
                                                    data-id="{{ $meal->id }}" 
                                                    aria-label="Yêu thích"
                                                    style="font-size: 20px; background: rgba(0,0,0,0.1); border: none; cursor: pointer;">
                                                    
                                                    <i class="fas fa-heart" style="color:  {{$liked ? 'red' : 'rgba(255,255,255,0.7)'}} ; font-size: 20px;"></i>
                                                </button>
                                                
                                            </div>
                                        </div>
                                    
                                </div>
                            
                            
                        @endforeach
                        
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning text-center mx-auto" style="width: 40%">
                        
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
   
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script >
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    document.querySelectorAll('.btn-favorite').forEach(btn => {
        btn.addEventListener('click', async function(e) {
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

                // Nếu chưa đăng nhập → backend trả 401
                if (response.status === 401) {
                    window.location.href = "{{ route('login') }}";
                    return;
                }

                const data = await response.json();

                if (data.status === 'success') {
                    // 1. Đổi màu icon tim
                    icon.style.color = data.saved ? 'red' : 'rgba(255,255,255,0.7)';

                    // 2. Update badge số lượng
                    const badge = document.getElementById('favoriteCountBadge');
                    if (data.favoriteCount > 0) {
                        badge.textContent = data.favoriteCount;
                        badge.style.display = 'inline-block';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            } catch (error) {
                
                // fallback về login nếu có lỗi không mong muốn
                window.location.href = "{{ route('login') }}";
            }
        });
    });


</script>
@endsection