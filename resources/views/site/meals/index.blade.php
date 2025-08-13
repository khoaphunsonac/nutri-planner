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

    
        <div class="  align-items-center text-center" style="margin: 100px 0; background-size: cover; background-position: center;">
            <div class="container mb-3">
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
                    <div class="col-md-9">
                        <input type="text" name="search" class="form-control @error('search') is-invalid @enderror" value="{{$search ?? old($search)}}" placeholder="Tìm món ăn, nguyên liệu hoặc chế độ ăn...">
                        {{-- Hiển thị thông báo lỗi --}}
                        @error('search')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    {{-- Submit button --}}
                    <div class="col-md-3 ">
                        <button class="btn btn-primary w-100">Tìm</button>
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
                            <option value="0-200" {{ request('calories_range') == '0-200' ? 'selected' : '' }}>0 - 200</option>
                            <option value="0-500" {{ request('calories_range') == '0-500' ? 'selected' : '' }}>0 - 500</option>
                            <option value="200-400" {{ request('calories_range') == '200-400' ? 'selected' : '' }}>200 - 400</option>
                            <option value="400-600" {{ request('calories_range') == '400-600' ? 'selected' : '' }}>400 - 600</option>
                            <option value="600-800" {{ request('calories_range') == '600-800' ? 'selected' : '' }}>600 - 800</option>
                            <option value="500-1000" {{ request('calories_range') == '500-1000' ? 'selected' : '' }}>500 - 1000</option>
                            <option value="800-1000" {{ request('calories_range') == '800-1000' ? 'selected' : '' }}>800 - 1000</option>
                            <option value="1000-1500" {{ request('calories_range') == '1000-1500' ? 'selected' : '' }}>1000 - 1500</option>
                            <option value="1000-1200" {{ request('calories_range') == '1000-1200' ? 'selected' : '' }}>1000 - 1200</option>
                            <option value="1200-1500" {{ request('calories_range') == '1200-1500' ? 'selected' : '' }}>1200 - 1500</option>
                            <option value="1500-1800" {{ request('calories_range') == '1500-1800' ? 'selected' : '' }}>1500 - 1800</option>
                            <option value="1800-2100" {{ request('calories_range') == '1800-2100' ? 'selected' : '' }}>1800 - 2100</option>
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
                                                    
                                                     // kiểm tra đã yêu thích chưa
                                                    $savedMeals = $meal->savemeal ? explode('-', $meal->savemeal) : [];
                                                    $isFavorite = in_array($meal->id, $savedMeals);
                                                @endphp
                                            
                                        
                                            <a href="{{ route('meal.show', $meal->id) }}" class="text-decoration-none text-dark">
                                                
                                                <img src="{{ $imageURL }}" alt="{{ $meal->name }}"  class="card-img-top" style="height: 300px; object-fit: cover;">
                                                <form action="{{route('meal.favorite',$meal->id)}}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-favorite" data-id="{{ $meal->id }}" 
                                                        data-liked="false" {{-- mặc định chưa thích --}}
                                                        style="font-size: 24px; background: none; border: none; cursor: pointer;"
                                                    >
                                                        @if($isFavorite)
                                                            <i class="fas fa-heart text-danger fs-4"></i>
                                                        @else
                                                            <i class="far fa-heart text-light fs-4"></i>
                                                        @endif
                                                    </button>
                                                </form>

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
                                        </div>
                                    
                                </div>
                            
                            
                        @endforeach
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

    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.favorite-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault(); // Ngăn chặn click nhảy link
                e.stopPropagation(); // Ngăn chặn sự kiện click lan ra thẻ cha

                let mealId = this.getAttribute('data-id');
                let icon = this.querySelector('i');

                fetch(`/meals/favorite/${mealId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(res => {
                    if (res.ok) {
                        // đổi icon
                        if (icon.classList.contains('far')) {
                            icon.classList.remove('far', 'text-light');
                            icon.classList.add('fas', 'text-danger');
                        } else {
                            icon.classList.remove('fas', 'text-danger');
                            icon.classList.add('far', 'text-light');
                        }
                    }
                })
                .catch(err => console.error(err));
            });
        });
    });

</script>
@endsection