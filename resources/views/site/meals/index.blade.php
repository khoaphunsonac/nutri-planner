@extends('site.layout')

@section('content')


    <section style="background-img: url(https://example.com/images/scrambled-eggs.jpg)">
        <div class="align-self-center text-center">
            <div class="container mb-3">
                <div>Kế hoạch món ăn trong tuần</div>
                <p>11.08 <span>-</span> 17.08</p>
            </div>
        </div>
    </section>
    <div class="card shadow-sm">
        <div class="card-body">
             {{-- form lọc --}}
            <form action="{{route('meals.index')}}" class="mb-4" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" value{{$search}} class="form-control" value="{{$search ?? old($search)}}" placeholder="Tìm món ăn...">
                    </div>
                    <div class="col-md-3">
                        <select name="mealType" id="" class="form-control">
                            <option value="">-- Loại bữa ăn --</option>
                            <option value="1" {{$mealType == 1 ? 'selected' : ''}}>Bữa sáng</option>
                            <option value="2" {{$mealType == 2 ? 'selected' : ''}}>Bữa trưa</option>
                            <option value="3" {{$mealType == 3 ? 'selected' : ''}}>Bữa chiều</option>
                            <option value="4" {{$mealType == 4 ? 'selected' : ''}}>Bữa tối</option>
                            <option value="5" {{$mealType == 5 ? 'selected' : ''}}>Bữa khuya</option>
                            <option value="6" {{$mealType == 6 ? 'selected' : ''}}>Bữa ăn nhẹ</option>
                            <option value="7" {{$mealType == 7 ? 'selected' : ''}}>Sinh tố</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">Lọc</button>
                    </div>
                </div>
            </form>

            {{-- danh sách meals --}}
            <div class="d-flex align-items-center mb-4">
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a href="{{ route('meals.index', ['tab' => 'thuc-don']) }}" class="nav-link active fw-bold text-dark" style="border-bottom:3px solid red; display: inline-block; padding-bottom: 4px;">Thực đơn</a>
                        
                    </li>
                    {{-- <li class="nav-item">
                        <a href="#" class="nav-link  text-dark">Món ăn khác</a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a href="{{ route('meals.index', ['tab' => 'tags']) }}" class="nav-link  {{$tab === 'tags' ? 'active fw-bold text-dark' : 'text-dark'}}">Thẻ</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('meals.index', ['tab' => 'allergens']) }}" class="nav-link  {{$tab === 'allergens' ? 'active fw-bold text-dark' : 'text-dark'}}">Dị ứng</a>
                    </li> --}}
                </ul>
                
            </div>
            <div class="card shadow-sm p-3">
                <div class=" mb-3 d-flex justify-content-around">
                    <a href="#" class="btn btn-outline-secondary">&laquo; Tuần rước</a>
                    <p>11.08 <span>-</span> 17.08</p>
                    <a href="#" class="btn btn-outline-secondary">Tuần Sau &raquo; </a>
                </div>
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
                                        $totalPro += $ingredient->protein;
                                        $totalCarbs += $ingredient->carb;
                                        $totalFat += $ingredient->fat;
                                        $totalKcal += ($ingredient->protein*4) + ($ingredient->carb*4) + ($ingredient->fat*9);
                                    }
                                }
                            @endphp
                            <div class="col-md-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body">
                                        <img src="{{ $meal->image_url ?? 'https://via.placeholder.com/400x300' }}" class="card-img-top" alt="{{ $meal->name }}">
                                    
                                        <h5 class="card-title">{{ $meal->name }}</h5>
                                        <p class="card-text text-muted">{{ Str::limit($meal->description, 80) }}</p>
                                        <p class="mb-2">
                                            <strong>{{$totalKcal}} kcal</strong> | 
                                            P: {{$totalPro}} g |
                                            C: {{$totalCarbs}} g |
                                            F: {{$totalFat}} g 
                                        </p>
                                        <a href="{{route('meals.show',$meal->id)}}" class="btn btn-primary">Chi tiết</a>
                                    </div>
                                    
                                </div>
                            
                            </div>
                        @endforeach
                    </div>
                    {{-- @elseif($tab === 'tags')
                        <h5 class="mb-3 text-info fw-bold">Danh sách Thẻ</h5>
                        @foreach($data as $meal)
                            <p>
                                <strong>{{ $meal->name }}:</strong>
                                @foreach($meal->tags as $index => $tag)
                                    {{ $tag->name }}@if($index + 1 < count($meal->tags)), @endif
                                @endforeach
                            </p>
                        @endforeach
                    @elseif($tab === 'allergens')
                        <h5 class="mb-3 text-danger fw-bold">Món ăn và Dị ứng</h5>
                        @foreach($data as $meal)
                            <p>
                                <strong>{{ $meal->name }}:</strong>
                                <?php
                                    $count = count($meal->allergens);
                                    $i = 0;
                                    foreach ($meal->allergens as $allergen) {
                                        echo $allergen->name;
                                        $i++;
                                        if ($i < $count) {
                                            echo ', ';
                                        }
                                    }
                                ?>
                            </p>
                        @endforeach
                    @endif --}}
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
                
            </div>

            {{--phan trang  --}}
            <div>
                {{$meals->appends(request()->except('meals_page'))->links('pagination::bootstrap-5')}}
            </div>
        </div>

    </div>
   
@endsection