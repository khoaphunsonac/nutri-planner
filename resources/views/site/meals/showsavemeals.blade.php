@extends('site.layout')

@section('content')
    <style>
        .shadow-text {
            text-shadow: 2px 2px 6px rgba(0,0,0,0.6);
        }

        meal-card {
        transition: all 0.3s ease;
        cursor: pointer;
        border-radius: 12px;
        overflow: hidden;
        position: relative;
        border: none;
    }

    .meal-card img {
        transition: all 0.3s ease;
        width: 100%;
        height: 300px;
        object-fit: cover;
    }

    .meal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.2);
    }

    .meal-card:hover img {
        filter: brightness(75%);
    }

    .favorite-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        padding: 8px;
        border: none;
        transition: 0.3s ease;
    }

    .favorite-btn:hover {
        background: rgba(255, 255, 255, 1);
        transform: scale(1.1);
    }

    .favorite-btn i {
        font-size: 20px;
        color: rgba(0,0,0,0.5);
        transition: color 0.3s ease;
    }

    .favorite-btn.liked i {
        color: red;
    }
        
    </style>


    <div class=" meal-header align-items-center text-center" style="background-image: url(https://fitfood.vn/img/2160x900/uploads/menu-16952880378313.jpg); ">
        <div class="container mb-3" style="">
            <h2 class="display-5 fw-bold text-white shadow-text">Kế hoạch món ăn mỗi bữa</h2>
            <div class="scroll-down-icon">
                <i class="fas fa-arrow-down text-white fa-3x animate-bounce"></i>
            </div>
        </div>
    </div>

    <div class="container my-4">
    <h2 class="mb-4 text-center">Món ăn yêu thích</h2>

    @if($meals->count() > 0)
        <div class="row g-4">
            @foreach($meals as $meal)
                <div class="col-md-4">
                    <div class="card meal-card">
                        @php
                            $imageURL = $meal->image_url 
                                ? url("uploads/meals/{$meal->image_url}") 
                                : "https://placehold.co/300x400?text=No+Image";

                            $totalPro = $totalCarbs = $totalFat = $totalKcal = 0;
                            foreach($meal->recipeIngredients as $pri){
                                $ingredient = $pri->ingredient;
                                if($ingredient){
                                    $quantity = $pri->quantity ?? 1;
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
                            $displayKcal = round($totalKcal, 1);

                        @endphp

                        <a href="{{ route('meal.show', $meal->id) }}" class="text-decoration-none text-dark">
                            <img src="{{ $imageURL }}" alt="{{ $meal->name }}" class="card-img-top">
                            <div class="card-body">
                                <h4 class="card-title">{{ $meal->name }}</h4>
                                <p class="card-text text-muted">{{ Str::limit($meal->description, 80) }}</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-primary">{{ $displayKcal }} kcal</span>
                                    <span class="badge bg-success">P: {{ $displayPro }}g</span>
                                    <span class="badge bg-warning text-dark">C: {{ $displayCarbs }}g</span>
                                    <span class="badge bg-danger">F: {{ $displayFat }}g</span>
                                </div>
                            </div>
                        </a>

                        <form action="{{ route('meal.favorite', $meal->id) }}" method="POST" class="favorite-form">
                            @csrf
                            @php
                                $saved = auth()->check() && auth()->user()->savemeal && in_array($meal->id, explode('-', auth()->user()->savemeal));
                            @endphp
                            <button type="submit" class="favorite-btn {{ $saved ? 'liked' : '' }}">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Bạn chưa lưu món ăn nào.</p>
    @endif
</div>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.favorite-form').forEach(function (form) {
                form.addEventListener('click', function (event) {
                    event.stopPropagation(); // Ngăn click lan ra ngoài
                });
            });
        });
    </script>
@endsection