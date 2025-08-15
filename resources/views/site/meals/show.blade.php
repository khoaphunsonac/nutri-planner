@extends('site.layout')

@section('content')

<style>
    
   
    
</style>
<div class="row">
    <div class="col-md-12">
        <div class="slider">
            <div class="sliders">
                <div class="slide">
                    <div class=" meal-header align-items-center text-center" style="background-image: url(https://fitfood.vn/img/2160x900/uploads/menu-16952880378313.jpg);  ">
                        <div class="container mb-3" style="">
                            <h2 class="display-5 fw-bold text-white shadow-text">Chi tiết món ăn</h2>
                            
                            <div class="scroll-down-icon">
                                <i class="fas fa-arrow-down text-white fa-3x animate-bounce"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div >   
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
                <img src="{{ $imageURL }}" alt="{{ $meal->name }}"  class="card-img-top" style="height: 300px; object-fit: cover;">
            </div>
            
            {{-- Thông tin chính --}}
            <div class="col-md-7">
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
                    $displayPro = round($totalPro, 1);
                    $displayCarbs = round($totalCarbs, 1);
                    $displayFat = round($totalFat, 1);
                    $displayKcal = round($totalKcal);
                @endphp
                <p class="text-p">
                    <strong>Thông tin dinh dưỡng (ước tính):</strong> 
                    <span class="text-primary">{{ $displayKcal }} kcal</span> | P: {{ $displayPro }} g | C: {{ $displayCarbs }} g | F: {{ $displayFat }} g
                </p>
            </div>
        </div>

        {{-- Công thức chi tiết: nguyên liệu + bước làm --}}
        <hr>
        
        <div class="mb-4">
            <h4>Nguyên liệu</h4>
            <hr class="border-bottom border-danger border-5 mt-0" style="width: 130px; ">
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
                @foreach($meal->recipeIngredients as $pri)
                    @php
                        $ingredient = $pri->ingredient;
                    @endphp
                    <tr>
                        <td>{{ $ingredient->name ?? 'N/A' }}</td>
                        <td>{{ $pri->quantity ?? '-' }}</td>
                        <td>{{ $ingredient->unit ?? '-' }}</td>
                        <td>{{ $displayPro ?? 0 }}</td>
                        <td>{{ $displayCarbs ?? 0 }}</td>
                        <td>{{ $displayFat ?? 0 }}</td>
                        <td>{{ $pri->total_calo ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <hr >

         
        <!-- <pre>{{$meal->preparation}}</pre> -->
        <div class="steps-container bg-light p-4 rounded">
            <div class="mb-4">
                <h3 class="d-inline-block mb-0">Cách chế biến</h3>
                <hr class="border-bottom border-danger border-5 mt-0" style="width: 180px; ">
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
                    $displayKcal = round($totalKcal);

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
@endsection