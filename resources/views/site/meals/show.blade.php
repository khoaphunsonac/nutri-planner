@extends('site.layout')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm p-4">
        <div class="row">
            {{-- Ảnh món ăn --}}
            <div class="col-md-5">
                <img src="{{ $meal->image_url ?? 'https://via.placeholder.com/600x400' }}" alt="{{ $meal->name }}" class="img-fluid rounded">
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
@endsection