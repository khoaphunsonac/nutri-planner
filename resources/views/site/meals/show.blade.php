@extends('site.layout')

@section('content')

<style>
    .container.my-4 {
        margin-top: 8rem !important; /* Đè lên mọi margin khác */
        padding-top: 0 !important;
    }
    .card.meal-card {
        transition: transform 0.3s;
    }
    .card.meal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .card-img-top {
        border-bottom: 1px solid #eee;
    }
    .card.meal-card:hover img {
        filter: brightness(70%);
    }
    .new{
        margin-top: 300px;
    }
</style>

<div class="container  my-4" >
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
                <p class="text-muted">{{ $meal->description }}</p>

                {{-- Loại bữa ăn --}}
                <p><strong>Loại bữa ăn:</strong> {{ $meal->mealType->name ?? 'Không xác định' }}</p>

                {{-- Tags --}}
                <p>
                    <strong>Thẻ:</strong> 
                    @forelse($meal->tags as $tag)
                        <span class="badge bg-info text-dark">{{ $tag->name }}</span>
                    @empty
                        <span>Không có Thẻ</span>
                    @endforelse
                </p>

                {{-- Dị ứng --}}
                <p>
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
                            $totalPro += $ingredient->protein;
                            $totalCarbs += $ingredient->carb;
                            $totalFat += $ingredient->fat;
                            $totalKcal += ($ingredient->protein*4) + ($ingredient->carb*4) + ($ingredient->fat*9);
                        }
                    }
                @endphp
                <p>
                    <strong>Thông tin dinh dưỡng (ước tính):</strong> 
                    <span class="text-primary">{{ $totalKcal }} kcal</span> | P: {{ $totalPro }} g | C: {{ $totalCarbs }} g | F: {{ $totalFat }} g
                </p>
            </div>
        </div>

        {{-- Công thức chi tiết: nguyên liệu + bước làm --}}
        <hr>

        <h4>Công thức nguyên liệu</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nguyên liệu</th>
                    <th>Số lượng</th>
                    <th>Đơn vị</th>
                    <th>Protein (g)</th>
                    <th>Carb (g)</th>
                    <th>Fat (g)</th>
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
                        <td>{{ $ingredient->protein ?? 0 }}</td>
                        <td>{{ $ingredient->carb ?? 0 }}</td>
                        <td>{{ $ingredient->fat ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4>Bước thực hiện: </h4>
        <pre>{{$meal->preparation}}</pre>

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
</div>
@endsection