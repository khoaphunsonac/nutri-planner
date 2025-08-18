@extends('site.layout')

@section('content')

        <div class=" meal-header align-items-center text-center" style="background-image: url(https://fitfood.vn/img/2160x900/uploads/menu-16952880378313.jpg);">
            <div class="container mb-3" style="">
                <h2 class="display-5 fw-bold text-white shadow-text">Chi tiết món ăn</h2>
                <div class="scroll-down-icon">
                    <i class="fas fa-arrow-down text-white fa-3x animate-bounce"></i>
                </div>
                
            </div>
        </div>

<div class="wide-container  my-5" >
    <div class="card shadow-sm p-4">
        <div class="row">
            {{-- Ảnh món ăn --}}
            <div class="col-md-5 ">
                 @php
                    $image = $meal->image_url ?? '';
                    $imageURL = $image ? url("uploads/meals/{$image}") : "https://placehold.co/300x400?text=No+Image";
                @endphp
                 <div class="image-wrapper " style="position: relative; width: 100%; padding-top: 75%; /* 4:3 ratio */ overflow: hidden;">
                    <img src="{{ $imageURL }}" alt="{{ $meal->name }}" 
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 80%; object-fit: cover;border-radius: 10px;">
                </div>
            </div>
            
            {{-- Thông tin chính --}}
            <div class="col-md-7"> 
                 {{-- Nút yêu thích --}}
                <div style="position: absolute; top: 10px; right: 10px;">
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
                
                <h2>{{ $meal->name }}</h2>
                <p class="text-muted " style="font-size: 18px">{{ $meal->description }}</p>

                {{-- Loại bữa ăn --}}
                <p class="text-p"><strong>Loại bữa ăn:</strong> {{ $meal->mealType->name ?? 'Không xác định' }}</p>

                {{-- Tags --}}
                <p class="text-p">
                    <strong>Thẻ:</strong> 
                    @forelse($meal->tags as $tag)
                        <span class="badge bg-info text-dark">{{ $tag->name }}</span>
                    @empty
                        <span>Không có Thẻ</span>
                    @endforelse
                </p>

                {{-- Dị ứng --}}
                <p class="text-p">
                    <strong>Có thể gây dị ứng:</strong>
                    @forelse($meal->allergens as $allergen)
                        <span class="badge bg-danger">{{ $allergen->name }}</span>
                    @empty
                        <span>Không có chất gây dị ứng</span>
                    @endforelse
                </p>

                {{-- Thông tin dinh dưỡng tổng --}}
                @php
                    $totalPro = 0;
                    $totalCarbs = 0;
                    $totalFat = 0;
                    $totalKcal = 0;
                    
                    // Mảng chuyển đổi đơn vị về gram
                    $unitToGram = [
                        'g' => 1,
                        'kg' => 1000,
                        'ml' => 1, // Giả sử 1ml ≈ 1g cho chất lỏng
                        'l' => 1000,
                        'muỗng canh' => 15, // 1 muỗng canh ≈ 15g
                        'muỗng cà phê' => 5, // 1 muỗng cà phê ≈ 5g
                        'cốc' => 200, // 1 cốc ≈ 200g
                        'lát' => 25, // 1 lát ≈ 25g (có thể điều chỉnh)
                        'gói' => 100, // 1 gói ≈ 100g (có thể điều chỉnh)
                        'cái' => 100, // 1 cái ≈ 100g (có thể điều chỉnh)
                    ];
                @endphp

                {{-- Tính toán trước để có thể sử dụng ở cả phần tổng và bảng chi tiết --}}
                @php
                    $ingredientNutritions = [];
                    
                    foreach($meal->recipeIngredients as $pri) {
                        $ingredient = $pri->ingredient;
                        if($ingredient) {
                            $quantity = $pri->quantity ?? 0;
                            $unit = $ingredient->unit ?? 'g';
                            
                            // Chuyển đổi quantity về gram
                            $quantityInGram = $quantity * ($unitToGram[$unit] ?? 1);
                            
                            // Tính tỷ lệ dựa trên 100g (vì thông tin dinh dưỡng trong DB tính cho 100g)
                            $ratio = $quantityInGram / 100;
                            
                            // Tính toán P/C/F cho nguyên liệu này
                            $pro = ($ingredient->protein ?? 0) * $ratio;
                            $carb = ($ingredient->carb ?? 0) * $ratio;
                            $fat = ($ingredient->fat ?? 0) * $ratio;
                            
                            // Tính calo: ưu tiên total_calo từ DB, nếu không có thì tính từ P/C/F
                            if(isset($pri->total_calo) && $pri->total_calo > 0) {
                                $kcal = $pri->total_calo;
                            } else {
                                $kcal = ($pro * 4) + ($carb * 4) + ($fat * 9);
                            }
                            
                            // Lưu thông tin để hiển thị trong bảng
                            $ingredientNutritions[] = [
                                'name' => $ingredient->name,
                                'quantity' => $quantity,
                                'unit' => $unit,
                                'protein' => round($pro, 1),
                                'carb' => round($carb, 1),
                                'fat' => round($fat, 1),
                                'kcal' => round($kcal, 1)
                            ];
                            
                            // Cộng vào tổng
                            $totalPro += $pro;
                            $totalCarbs += $carb;
                            $totalFat += $fat;
                            $totalKcal += $kcal;
                        }
                    }
                    
                    $displayPro = round($totalPro,);
                    $displayCarbs = round($totalCarbs);
                    $displayFat = round($totalFat);
                    $displayKcal = round($totalKcal, 1);
                @endphp

                <div class="nutrition-summary mb-4">
                    <h4>Thông tin dinh dưỡng (ước tính):</h4>
                     <span>
                       <strong class="text-primary total-nutrition mb-3">{{ $displayKcal }} kcal </strong> | P: {{ $displayPro }}g | C: {{ $displayCarbs }}g | F: {{ $displayFat }}g
                     
                    </span>   
                    
                </div>
            </div>
        </div>

        {{-- Công thức chi tiết: nguyên liệu + bước làm --}}
        <hr>
        
        <div class="mb-4">
            <h4>Nguyên liệu</h4>
            <hr class="border-bottom border-danger border-5 mt-0" style="width: 150px; ">
        </div>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Nguyên liệu</th>
                    <th>Số lượng</th>
                    <th>Đơn vị</th>
                    <th>Protein (g)</th>
                    <th>Carb (g)</th>
                    <th>Fat (g)</th>
                    <th>Kcal </th>
                </tr>
            </thead>
             <tbody>
        @foreach($ingredientNutritions as $nutrition)
            <tr>
                <td>{{ $nutrition['name'] }}</td>
                <td>{{ $nutrition['quantity'] }}</td>
                <td>{{ $nutrition['unit'] }}</td>
                <td>{{ $nutrition['protein'] }}</td>
                <td>{{ $nutrition['carb'] }}</td>
                <td>{{ $nutrition['fat'] }}</td>
                <td>{{ $nutrition['kcal'] }}</td>
            </tr>
        @endforeach
        {{-- Dòng tổng cộng --}}
        <tr class="table-warning">
            <td><strong>TỔNG CỘNG </strong>(tròn số)</td>
            <td colspan="2">-</td>
            <td><strong>{{ $displayPro }}</strong></td>
            <td><strong>{{ $displayCarbs }}</strong></td>
            <td><strong>{{ $displayFat }}</strong></td>
            <td><strong>{{ round($totalKcal) }}</strong></td>
        </tr>
    </tbody>
        </table>

        <hr >

         
        <!-- <pre>{{$meal->preparation}}</pre> -->
        <div class="steps-container bg-light p-4 rounded">
            <div class="mb-4">
                <h3 class="d-inline-block mb-0">Cách chế biến</h3>
                <hr class="border-bottom border-danger border-5 mt-0" style="width: 200px; ">
            </div>
            @php
                // Tách các bước từ chuỗi trong DB
                $steps = preg_split('/\n|\d+\./', $meal->preparation, -1, PREG_SPLIT_NO_EMPTY);
                $stepCount = count($steps);
                $half = ceil($stepCount / 2);
            @endphp
            
            <div class="row">
                {{-- Cột trái --}}
                <div class="col-md-6">
                    @foreach(array_slice($steps, 0, $half) as $index => $step)
                        @if(trim($step))
                            <div class="step-card mb-3 p-3 bg-white rounded shadow-sm">
                                <div class="d-flex align-items-center">
                                    <span class="step-number bg-primary text-white fw-bold rounded-circle   me-3">B{{ $index + 1 }}</span>
                                    <div class="step-content">
                                        {{ trim($step) }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                
                {{-- Cột phải --}}
                <div class="col-md-6">
                    @foreach(array_slice($steps, $half) as $index => $step)
                        @if(trim($step))
                            <div class="step-card mb-3 p-3 bg-white rounded shadow-sm">
                                <div class="d-flex align-items-center">
                                    <span class="step-number bg-primary text-white fw-bold rounded-circle   me-3">B{{ $index + $half + 1 }}  </span>
                                    <div class="step-content" style="font-size: 1rem;">
                                        {{ trim($step) }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <a href="{{ route('meal.index') }}" class="btn btn-outline-primary mb-3 text-center gap-2" style="width:200px;">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
</div>

{{-- hiển thị 8 món mới nhất --}}
<div class="container new ">
    <h4 class="mb-4" style="border-bottom:3px solid red; display: inline-block; padding-bottom: 4px;">Món ăn mới nhất</h4>
    <div class="row">
       
            @foreach ($latestMeals as $latest)
            @php
                
                //tính toán dinh dưỡng
                
                    $totalPro = 0;
                    $totalCarbs= 0;
                    $totalFat= 0;
                    $totalKcal= 0;
                    foreach($latest->recipeIngredients as $recipeIngredient){
                        $ingredient = $recipeIngredient->ingredient;
                        if($ingredient){
                            $quantity = $recipeIngredient->quantity ?? 1; // Lấy quantity từ recipe_ingredients
                           
                            // Tính toán P/C/F: nếu có quantity thì chia 10, không thì lấy giá trị gốc
                            $pro = ($ingredient->protein ?? 0) * ($quantity > 1 ? ($quantity/100) : 1);
                            $carb = ($ingredient->carb ?? 0) * ($quantity > 1 ? ($quantity/100) : 1);
                            $fat = ($ingredient->fat ?? 0) * ($quantity > 1 ? ($quantity/100) : 1);
                            
                            $totalPro += $pro;
                            $totalCarbs += $carb;
                            $totalFat += $fat;
                            $totalKcal += $recipeIngredient->total_calo ?? 0;
                        }
                    }
                    // Làm tròn
                    $displayPro = round($totalPro, 1);
                    $displayCarbs = round($totalCarbs, 1);
                    $displayFat = round($totalFat, 1);
                    $displayKcal = round($totalKcal, 1);

                // hiển thị ảnh
                $image = $meal->image_url ?? '';
                $imageURL = $image ? url("uploads/meals/{$image}") : "https://placehold.co/300x400?text=No+Image";
                                              
            @endphp
            <div class="col-md-3 mb-4" >
                <div class="card meal-card shadow-sm h-100" >
                        @php
                            $image = $latest->image_url ?? '';
                            $imageURL = $image ? url("uploads/meals/{$image}") : "https://placehold.co/300x400?text=No+Image";
                        @endphp
                    
                
                    <a href="{{ route('meal.show', $latest->id) }}" class="text-decoration-none text-dark">
                        
                        <img src="{{ $imageURL }}" alt="{{ $latest->name }}"  class="card-img-top" style="height: 300px; object-fit: cover;">
                        
                        <div class="card-body ">
                            <h4 class="card-title my-3">{{ $latest->name }}</h4>
                            <p class="card-text text-muted ">{{ Str::limit($latest->description, 80) }}</p>
                            <div class="nutrition-info mt-auto pt-2">
                              <div class="d-flex flex-wrap gap-1">
                                <span class="badge bg-primary rounded-pill">{{ $displayKcal }} kcal</span>
                                <span class="badge bg-success rounded-pill">P: {{ $displayPro }}g</span>
                                <span class="badge bg-warning text-dark rounded-pill">C: {{ $displayCarbs }}g</span>
                                <span class="badge bg-danger rounded-pill">F: {{ $displayFat }}g</span>
                              </div>
                            </div>
                            {{-- <a href="{{route('meal.show',$meal->id)}}" class="btn btn-primary">Chi tiết</a> --}}
                          
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>


<script>
    



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