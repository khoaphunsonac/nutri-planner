@extends('site.layout')

@section('content')
    <style>
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

        
    </style>

    <section style="background-img: url(https://example.com/images/scrambled-eggs.jpg)">
        <div class="align-self-center text-center">
            <div class="container mb-3">
                <div>Kế hoạch món ăn mỗi bữa</div>
                <!-- <p>11.08 <span>-</span> 17.08</p> -->
            </div>
        </div>
    </section>
    <div class="card shadow-sm">
        <div class="card-body">
             {{-- form lọc --}}
            <form action="{{route('meal.index')}}" class="mb-4" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" value{{$search}} class="form-control" value="{{$search ?? old($search)}}" placeholder="Tìm món ăn, nguyên liệu hoặc chế độ ăn...">
                    </div>
                    
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">Tìm</button>
                    </div>
                </div>
            </form>

            {{-- danh sách meals --}}
            <div class="d-flex align-items-center mb-4">
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a href="{{ route('meal.index', ['tab' => 'thuc-don']) }}" class="nav-link active fw-bold text-dark" style="border-bottom:3px solid red; display: inline-block; padding-bottom: 4px;">Thực đơn</a>
                        
                    </li>
                </ul>
                
            </div>
            <div class="card shadow-sm p-3">
                <!-- <div class=" mb-3 d-flex justify-content-around">
                    <a href="#" class="btn btn-outline-secondary">&laquo; Tuần rước</a>
                    <p>11.08 <span>-</span> 17.08</p>
                    <a href="#" class="btn btn-outline-secondary">Tuần Sau &raquo; </a>
                </div> -->
                @if( $meals->count() > 0)
                    
                    <div class="row mb-3">
                            @foreach ($meals as $meal)
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
                                                    <p class="mb-2 my-4">
                                                        <strong>{{$totalKcal}} kcal</strong> | 
                                                        P: {{$totalPro}} g |
                                                        C: {{$totalCarbs}} g |
                                                        F: {{$totalFat}} g 
                                                    </p>
                                                    {{-- <a href="{{route('meal.show',$meal->id)}}" class="btn btn-primary">Chi tiết</a> --}}
                                            
                                                </div>
                                            </a>
                                        </div>
                                    
                                </div>
                            
                            
                        @endforeach
                    </div>
                    @else
                        <div class="alert alert-warning text-center mx-auto" style="width: 40%">
                            
                             @if(!empty($search)&& !empty($mealTypeName))
                               Không có kết quả tìm kiếm nào  "<strong>{{ $search }}</strong>" và loại "<strong>{{ $mealTypeName }}</strong>"
                            @elseif(!empty($mealTypeName))
                                Không có món ăn nào cho loại "<strong>{{ $mealTypeName }}</strong>"
                            @elseif(!empty($search))
                                Không có kết quả tìm kiếm cho "<strong>{{ $search }}</strong>".
                            @endif
                        </div>
                    @endif
                

            {{--phan trang  --}}
            <div>
                {{$meals->appends(request()->except('meals_page'))->links('pagination::bootstrap-5')}}
            </div>
        </div>

    </div>
   
@endsection