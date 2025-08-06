@extends('admin.layout')
@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{route('allergens.index')}}">Quản lý Dị ứng</a></li>
            <li class="breadcrumb-item link-primary" aria-current="page"> Danh sách</li>
        </ol>
    </nav>

   
    <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Quản lý Dị ứng</h2>
    </div>
    

    @if (session('success'))
        <div class="d-flex justify-content-center">
            <div class="alert alert-success my-4 text-center" style="max-width: 300px; margin: 0 auto;">{{session('success')}}</div>
        </div>
    @endif
    {{-- Dashboard summary --}}
    <div>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card text-center -shadow-sm">
                    <div class="card-body">
                        <h4>{{$totalAllergens ?? 0}}</h4>
                        <p class="text-muted mb-0">Tổng Dị ứng</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center -shadow-sm">
                    <div class="card-body">
                        <h4>{{$activeAllergens ?? 0}}</h4>
                        <p class="text-muted mb-0">Tổng Dị ứng hoạt động</p>
                    </div>
                </div>
            </div>
        
            <div class="col-md-4">
                <div class="card text-center -shadow-sm">
                    <div class="card-body">
                        <h4>{{$usageRate ?? 0}}</h4>
                        <p class="text-muted mb-0">Sử dụng Dị ứng</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card text-center -shadow-sm">
                    <div class="card-body">
                        <h4>{{$totalMealsModel ?? 0}}</h4>
                        <p class="text-muted mb-0">Tổng Món ăn</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center -shadow-sm">
                    <div class="card-body">
                        <h4>{{$totalMappings   }}</h4>
                        <p class="text-muted mb-0">Tổng Dị ứng theo món ăn</p> {{--  Mappings --}}
                    </div>
                </div>
            </div>
        
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-md-9">
             <div class=" card mb-1 px-3 py-3 shadow-sm ">
                {{-- fillter form --}}
                {{-- <form action="" method="GET" class="row g-2 align-items-center" >
                    <div class="col-md-8"> 
                        <input type="text" name="search" class="form-control" id="" placeholder="Tìm kiếm Allergen..." value="{{$search ?? old($search)}}">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary w-100" type="submit">Lọc</button>
                    </div>

                </form> --}}
                    
                        <form action="" method="GET" class="row g-2 align-items-center">
                            
                            <div class="col-sm-5">
                                <input type="text" name="allergenSearch" class="form-control" placeholder="Tìm theo dị ứng... " value="{{$allergenSearch ?? old($allergenSearch)}}">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" name="mealSearch" class="form-control" placeholder="Tìm theo món ăn... " value="{{$mealSearch ?? old($mealSearch)}}">
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-sm btn-outline-success w-100" type="submit"> <i class="bi bi-search"></i> Tìm
                                </button>
                            </div>
                        </form>
                   
            </div>
        </div>
        <div class="col-md-3">
            {{-- Allergen table --}}
            
                <div class=" card shadow-sm mb-1 px-3 py-3 bg-light text-end">
                    <a href="{{route('allergens.add')}}" class="btn btn-outline-primary "><i class="bi bi-plus-circle mb-2"></i> Thêm Dị ứng</a>
                </div>
            
        </div>
    </div> 


    <div class="card shadow-sm mb-5">
       
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Danh sách Dị ứng</h5>
            
                <small class="text-end">
                    {{--  Tổng số Allergen thỏa query tìm kiếm --}}
                    @if ($item->total() > 0)
                    Tổng: {{$item->total()}} mục
                    @else
                        0 mục
                    @endif
                </small> 
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-light ">
                    <tr>
                        <th width="30">ID</th>
                        <th width="150">Tên Dị ứng</th>
                        <th width="150">Món ăn</th>
                        <th width="100">Số món ăn</th>
                        <th width="150">Ngày tạo</th>
                        <th width="200" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($item)>0)
                        @foreach ($item as $phanTu)
                            <tr onclick="window.location='{{ route('allergens.show', $phanTu->id) }}'" style="cursor: pointer;">
                                
                                <td class="align-middle text-center">
                                    <span class=" d-inline-block px-2 py-1 border rounded bg-light sort-order text-center" style="width:50px">{{$phanTu['id'] ?? 1}} </span>
                                </td>
                                <td>
                                    {{$phanTu['name']}}
                                </td>
                                <td>
                                    @if ($phanTu->meals->count()>0)
                                        @foreach ($phanTu->meals as $meal)
                                            <span class="badge bg-success mb-1">{{ $meal->name  }}</span>
                                        @endforeach
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
                                    {{ $phanTu->meals_count ?? 0 }}
                                </td>
                                <td>
                                    {{ $phanTu->created_at }}
                                </td>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{route('allergens.show',['id'=>$phanTu->id])}}" class="btn btn-sm btn-info rounded  me-3" title="chi tiết"><i class="bi bi-eye" ></i></a>
                                        <a href="{{route('allergens.form',['id'=>$phanTu->id])}}" class="btn btn-sm btn-warning rounded  me-3" title="Sửa"><i class="bi bi-pencil-square" ></i></a>
                                        <form action="{{route('allergens.delete',['id'=>$phanTu->id])}}" method="POST" style="display:inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa Dị ứng này không?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger me-3" title="Xóa"><i class="bi bi-trash" ></i></button>
                                        </form>

                                        <!-- Nút mở modal -->
                                        <button 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#mapMealModal{{ $phanTu->id }}" 
                                            class="btn btn-sm btn-outline-primary rounded me-3"
                                            onclick="event.stopPropagation()"
                                            title="gắn mapping"
                                        >
                                            <i class="bi bi-link-45deg"></i>
                                        </button>
                                    </div>
                                    
                                </td>
                            </tr>
                        @endforeach
                        @foreach ($item as $phanTu)
                            <div class="modal fade" id="mapMealModal{{ $phanTu->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <form action="{{ route('allergens.mapMeals', ['id' => $phanTu->id]) }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Gán món ăn bị dị ứng cho: {{ $phanTu->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-start">
                                                <div class="row">
                                                    <div class="col-12" style="max-height: 300px; overflow-y: auto;">
                                                        <div class="row">
                                                            @foreach ($meals as $meal)
                                                                <div class="col-md-6 mb-2"> <!-- 2 cột -->
                                                                    <div class="form-check text-truncate" title="{{ $meal->name }}">
                                                                        <input 
                                                                            class="form-check-input" 
                                                                            type="checkbox" 
                                                                            name="meals[]" 
                                                                            id="meal_{{ $phanTu->id }}_{{ $meal->id }}" 
                                                                            value="{{ $meal->id }}"
                                                                            {{ $phanTu->meals->contains($meal->id) ? 'checked' : '' }}
                                                                        >
                                                                        <label class="form-check-label text-truncate d-inline-block w-100" for="meal_{{ $phanTu->id }}_{{ $meal->id }}">
                                                                            {{ $meal->name }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
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
                        <tr>
                            <td class="text-center text-muted" colspan="6">Không có kết quả nào</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{$item->links('pagination::bootstrap-5')}}
        </div>
    </div>


    {{-- Meal-Allergen table 
    <div class="row mt-5">

        <div class="col-md-9">
            <div class=" card mb-1 px-3 py-3 shadow-sm ">
            {{-- Bên trái: tìm kiếm
                <form action="" method="GET" class="row g-2 align-items-center">
                    <div class="col-sm-5">
                        <input type="text" name="mealSearch" class="form-control" placeholder="Tìm theo Meal... " value="{{$mealSearch ?? old($mealSearch)}}">
                    </div>
                    <div class="col-sm-5">
                        <input type="text" name="allergenSearch" class="form-control" placeholder="Tìm theo Allergen... " value="{{$allergenSearch ?? old($allergenSearch)}}">
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-sm btn-outline-success w-100" type="submit"> <i class="bi bi-search"></i> Tìm
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-3">
            {{-- Bên phải: nút thêm 
            <div class=" card shadow-sm mb-1 px-3 py-3 bg-light text-end">
                <a href="{{route('allergens.mapping.add')}}" class="btn btn-outline-primary "><i class="bi bi-plus-circle mb-2"></i> Add Mapping</a>
            </div>
        </div>
        
    </div>

    <div class="card shadow-sm mb-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-link text-success"></i>Meal-Allergen Mapping</h5>
             <small class="text-end">
                    {{--  Tổng số Allergen thỏa query tìm kiếm 
                    @if ($item->total() > 0)
                    Tổng: {{$mappingPaginate->total()}} mục
                    @else
                        0 mục
                    @endif
                </small> 
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-success ">
                    <tr>
                        <th width="30">ID</th>
                        <th width="150">Meal</th>
                        <th width="150">Allergen</th>
                        <th width="200" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    
                        @foreach ($mappingPaginate  as $map)
                            <tr>
                                
                                <td class="align-middle text-center">
                                    <span class=" d-inline-block px-2 py-1 border rounded bg-light sort-order text-center" style="width:50px">{{$map->id ?? 1}} </span>
                                </td>
                                <td>
                                    {{$map->meal->name}}
                                </td>
                                <td>
                                    {{$map->allergen->name}}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        
                                        <form action="{{route('allergens.mapping.delete',['id'=>$map->id])}}" method="POST" style="display:inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa Mappings này không?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa"><i class="bi bi-trash" ></i></button>
                                        </form>
                                    </div>
                                    
                                </td>
                            </tr>
                        @endforeach
                            
                    @if($mappingPaginate ->isEmpty())
                        <tr>
                            <td class="text-center text-muted" colspan="6">Không có Mappings  nào</td>
                        </tr>
                    @endif
                </tbody>
            </table>
             
        </div>
       <div class="d-flex justify-content-center mt-3">
            {{$mappingPaginate->appends(['allergens_page' => request('allergens_page')])->links('pagination::bootstrap-5')}}
        </div>
    </div> --}}

    {{-- Overview --}}
    <div class="card shadow-sm mt-5">
        <div class="card-header bg-white  d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-eye text-success"></i>Tổng quan chất gây dị ứng của món ăn</h5>
            <small class="text-end">
                    {{--  Tổng số Allergen thỏa query tìm kiếm --}}
                    @if ($item->total() > 0)
                    Tổng: {{$totalMeals }} mục
                    @else
                        0 mục
                    @endif
                </small>
        </div>
        <div class="card-body">
            @foreach($meals as $meal)
                <div class="border-start border-success border-4 p-3 mb-3 bg-light rounded">
                    <h6  class="fw-bold text-dark mb-2"><i class="fas fa-utensils text-secondary"></i> {{ $meal->name }}</h6>
                    <p class="mb-0">
                        Dị ứng:
                        @if($meal->allergens->isEmpty())
                            <span class="text-muted">Không Dị ứng</span>
                        @else
                            @foreach($meal->allergens as $a)
                                <span class="badge bg-danger">{{ $a->name }}</span>
                            @endforeach
                        @endif
                    </p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
