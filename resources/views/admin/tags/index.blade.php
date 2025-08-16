@extends('admin.layout')
@section('content')
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb breadcrumb-compact" class="mb-4">
        <ol class="breadcrumb breadcrumb-compact">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item"> <a href="{{route('tags.index')}}"><i class="bi bi-tags">Thẻ</i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Danh sách</li>
        </ol>
    </nav>

   {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
         <div class="d-flex align-items-center">
            <h3 class="mb-0 me-3">Quản lý Thẻ</h3>
            <span class="badge bg-primary rounded-pill">{{ $totalTags}}</span>
            <small class="text-muted ms-2">
                <i class="bi bi-info-circle me-1"></i>Click vào dòng để xem chi tiết
            </small>
         </div>
        <a href="{{route('tags.add')}}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i>Thêm Thẻ</a>
    </div>
    

    {{-- @if (session('success'))
        <div class="d-flex justify-content-center">
            <div class="alert alert-success mt-2 text-center" style="width: 350px;">{{session('success')}}</div>
        </div>
    @endif --}}

    {{-- Dashboard summary --}}
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card text-center -shadow-sm">
                <div class="card-body">
                    <h4>{{$totalTags ?? 0}}</h4>
                    <p class="text-muted mb-0">Tổng Thẻ</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center -shadow-sm">
                <div class="card-body">
                    <h4>{{$activeTags ?? 0}}</h4>
                    <p class="text-muted mb-0">Đang hoạt động</p>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-3">
            <div class="card text-center -shadow-sm">
                <div class="card-body">
                    <h4>{{$deletedTags ?? 0}}</h4>
                    <p class="text-muted mb-0">Đã xóa</p>
                </div>
            </div>
        </div> --}}
        <div class="col-md-4">
            <div class="card text-center -shadow-sm">
                <div class="card-body">
                    <h4>{{$usageRate ?? 0}}</h4>
                    <p class="text-muted mb-0">Thẻ được sử dụng</p>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-3">
            <div class="card text-center -shadow-sm">
                <div class="card-body">
                    <h4>Coming soon</h4>
                    <p class="text-muted mb-0">Thẻ phổ biến</p>
                </div>
            </div>
        </div> --}}
    </div>

    {{-- fillter form --}}
    <div class="row mt-5">
        <div class="col-md-12">
             <div class=" card mb-3 px-3 py-3 shadow-sm ">
                <form action="" method="GET" class="row g-3 align-items-center" >
                    <div class="col-md-5"> 
                        <input type="text" name="search" class="form-control" id="" placeholder="Tìm kiếm tên Thẻ..." value="{{$search ?? old($search)}}"  >
                    </div>
                    <div class="col-sm-5">
                        <input type="text" name="mealSearch" class="form-control" placeholder="Tìm theo món ăn... " value="{{$mealSearch ?? old($mealSearch)}}">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100" type="submit">Lọc</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    
    <div class="card shadow-sm mb-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Danh sách Thẻ</h5>
            <small>
                {{--  Tổng số tag thỏa query tìm kiếm --}}
                @if ($item->total() > 0)
                Tổng: {{ $item->count()}}/ {{$item->total()}} mục
                @else
                    0 mục
                @endif
                
            </small>
        </div>
        <div class="card-body   text-center">
            <table class="table  table-bordered  table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="30">Số thứ tự</th>
                        <th width="150">Tên Thẻ</th>
                        <th width="150">Món ăn</th>
                        <th width="100">Số món ăn</th>
                        <th width="150">Ngày tạo</th>
                        <th width="150" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (count($item)>0)
                        @foreach ($item as $key => $phanTu)
                            <tr onclick="window.location='{{route('tags.show',$phanTu->id)}}'" style="cursor: pointer;">
                                <td class="align-middle text-center">
                                    <span class=" d-inline-block px-2 py-1 border rounded bg-light sort-order text-center" style="width:50px">{{$startIndex - $key}} </span>
                                </td>
                                <td>
                                    {{$phanTu->name}}
                                </td>
                                <td>
                                    @php
                                        $totalmeals = $phanTu->meals;
                                        $total = $totalmeals->count();
                                    @endphp
                                    @if ($total)
                                        @foreach ($totalmeals->take(2) as $meal)
                                            <span class="badge bg-success mb-1">{{ $meal->name  }}</span>
                                        @endforeach
                                        @if ($total > 2)
                                            <span class=" badge bg-success me-1 text-white ">...</span>
                                        @endif
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
                                    {{$phanTu->meals_count}}
                                </td>
                                <td>
                                    
                                    {{ \Carbon\Carbon::parse($phanTu->created_at)->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{route('tags.show',['id'=>$phanTu->id])}}" class="btn btn-sm btn-info rounded  me-3" title="chi tiết"><i class="bi bi-eye" ></i></a>
                                        <a href="{{route('tags.form',['id'=>$phanTu->id])}}" class="btn btn-sm btn-warning rounded  me-3" title="Sửa"><i class="bi bi-pencil-square" ></i></a>
                                        <form action="{{route('tags.delete',['id'=>$phanTu->id])}}" method="POST" style="display:inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tag này không?')">
                                            @csrf
                                            
                                            <button type="submit" class="btn btn-sm btn-danger me-3" title="Xóa"><i class="bi bi-trash " ></i></button>
                                        </form>

                                        <button 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#mapMealModal{{ $phanTu->id }}" 
                                            class="btn btn-sm btn-outline-primary rounded  me-3"
                                             onclick="event.stopPropagation()"
                                        >
                                            <i class="bi bi-link-45deg"></i>
                                        </button>
                                    </div>
                                    
                                </td>
                            </tr>
                            
                            
                        @endforeach
                            <!-- Tất cả các modal đặt sau bảng -->
                            @foreach ($itemMeal as $phanTu)
                                <div class="modal fade" id="mapMealModal{{ $phanTu->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <form action="{{ route('tags.mapMeals', ['id' => $phanTu->id]) }}" method="POST">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Gán món ăn cho Thẻ: {{ $phanTu->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    <div class="row">
                                                        @foreach ($allMeals as $meal)
                                                            <div class="col-md-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="meals[]" id="meal_{{ $phanTu->id }}_{{ $meal->id }}" value="{{ $meal->id }}"
                                                                        {{ $phanTu->meals->contains($meal->id) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="meal_{{ $phanTu->id }}_{{ $meal->id }}">{{ $meal->name }}</label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Lưu</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                    @else
                       @if (count($item)>0)
                            @foreach ($item as $key => $phanTu)
                                {{-- Phần hiển thị danh sách thẻ như cũ --}}
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center text-muted" colspan="6">
                                    @if(!empty($search) && !empty($mealSearch))
                                        Không tìm thấy thẻ nào phù hợp với tên thẻ "<strong>{{ $search }}</strong>" và món ăn "<strong>{{ $mealSearch }}</strong>"
                                    @elseif(!empty($search))
                                        Không tìm thấy thẻ nào phù hợp với tên thẻ "<strong>{{ $search }}</strong>"
                                    @elseif(!empty($mealSearch))
                                        Không tìm thấy thẻ nào có món ăn phù hợp với "<strong>{{ $mealSearch }}</strong>"
                                    @else
                                        Hiện không có thẻ nào trong hệ thống
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endif
                </tbody>
             </table>
            <div class="mt-3 text-end">
                {{$item->appends(request()->except('tags'))->links('pagination::bootstrap-5')}}
            </div>
        </div>
       
    </div>
    
    

    {{-- Overview --}}
    
    <div class="card shadow-sm mt-5">
        <div class="card-header bg-white  d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-list-ul"></i> Tổng quan thẻ của món ăn</h5>
            <small class="text-end">
                {{--  Tổng số Allergen thỏa query tìm kiếm --}}
                @if ($mealsForOverview->count() > 0)
                Tổng: giới hạn {{$mealsForOverview->count() }} mục
                @else
                    0 mục
                @endif
            </small>
        </div>
        <div class="card-body">
        <div class="row">
            @foreach($meals->take(10) as $meal)
                <div class="col-md-6 mb-4">
                     <a href="{{ route('meals.show', $meal->id) }}" class="text-decoration-none text-dark">
                        <div class=" list-group-item border-start border-success border-4 p-3 bg-light rounded shadow-sm h-100 hover-shadow">
                            <h6 class="fw-bold text-dark mb-2 text-truncate" title="{{ $meal->name }}">
                                <i class="fas fa-utensils text-secondary"></i> {{ $meal->name }}
                            </h6>

                            <div class="d-flex flex-wrap gap-1">
                                <strong class="me-2">Thẻ được gán:</strong>
                                @if($meal->allergens->isEmpty())
                                    <span class="text-muted">Không thẻ</span>
                                @else
                                    @php
                                        $maxTagsToShow = 3;
                                        $totalTags = $meal->tags->count();
                                        $tagsToShow = $meal->tags->take($maxTagsToShow);
                                    @endphp
                                    @foreach($tagsToShow as $t)
                                         <span class="badge bg-danger text-truncate" title="{{ $t->name }}" style="max-width: 120px;">
                                            {{ $t->name }}
                                        </span>
                                    @endforeach
                                    
                                    @if($totalTags > $maxTagsToShow)
                                        <span class="badge bg-danger" title="Còn {{ $totalTags - $maxTagsToShow }} thẻ khác">
                                            ...
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
       



@endsection
