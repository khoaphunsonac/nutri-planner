@extends('admin.layout')
@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{route('allergens.index')}}">Allergens Management</a></li>
            <li class="breadcrumb-item" aria-current="page"> <a href="">Danh sách</a></li>
        </ol>
    </nav>

   
    <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Allergens Management</h2>
    </div>
    

    @if (session('success'))
        <div class="alert alert-success my-4" style="max-width: 300px; margin: 0 auto;">{{session('success')}}</div>
    @endif
    {{-- Dashboard summary --}}
    <div>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card text-center -shadow-sm">
                    <div class="card-body">
                        <h4>{{$totalAllergens ?? 0}}</h4>
                        <p class="text-muted mb-0">Tổng Allergen</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center -shadow-sm">
                    <div class="card-body">
                        <h4>{{$activeAllergens ?? 0}}</h4>
                        <p class="text-muted mb-0">Đang hoạt động</p>
                    </div>
                </div>
            </div>
        
            <div class="col-md-4">
                <div class="card text-center -shadow-sm">
                    <div class="card-body">
                        <h4>{{$usageRate ?? 0}}</h4>
                        <p class="text-muted mb-0">Sử dụng</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card text-center -shadow-sm">
                    <div class="card-body">
                        <h4>{{$totalMeals ?? 0}}</h4>
                        <p class="text-muted mb-0">Tổng Meals</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center -shadow-sm">
                    <div class="card-body">
                        <h4>{{$totalMappings ?? 0}}</h4>
                        <p class="text-muted mb-0">Tổng Dị ứng theo món ăn</p> {{--  Mappings --}}
                    </div>
                </div>
            </div>
        
        </div>
    </div>
    

    {{-- fillter form --}}
    <form action="" method="GET" class="row g-2 align-items-center mb-5" >
        <div class="col-md-8"> 
            <input type="text" name="search" class="form-control" id="" placeholder="Tìm kiếm Allergen..." value="{{$search ?? old($search)}}">
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary w-100" type="submit">Lọc</button>
        </div>

    </form>
    {{-- Allergen table --}}
    <div class="d-flex  ">
        <div class=" card rounded bg-light p-3 ms-auto">
            <a href="{{route('allergens.create')}}" class="btn btn-outline-primary "><i class="bi bi-plus-circle mb-2"></i> Add New Allergen</a>
        </div>
    </div>
     
    <div class="card shadow-sm mb-4">
       
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Danh sách Allergens</h5>
            
                <small class="text-end">
                    {{--  Tổng số Allergen thỏa query tìm kiếm --}}
                    @if ($item->total() > 0)
                    Tổng: {{$item->total()}} mục
                    @else
                        Không có kết quả nào
                    @endif
                </small>
            
            
            
        </div>
        <div class="card-body table-reponsive">
            <table class="table table-hover table -bordered align-middle text-center">
                <thead class="table-light ">
                    <tr>
                        <th width="30">ID</th>
                        <th width="150">Tên Allergen</th>
                        <th width="150">Ngày tạo</th>
                        <th width="200" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($item)>0)
                        @foreach ($item as $phanTu)
                            <tr>
                                <td>
                                    <input type="number" class="form-control form-control-sm sort-order text-center" value="{{$phanTu['id'] ?? 1}}" min="1" data-id= "{{$phanTu['id']}}" disabled>
                                </td>
                                <td>
                                    {{$phanTu['name']}}
                                </td>
                                <td>

                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{route('allergens.show',['allergen'=>$phanTu->id])}}" class="btn btn-sm btn-info rounded  me-3" title="chi tiết"><i class="bi bi-eye" ></i></a>
                                        <a href="{{route('allergens.edit',['allergen'=>$phanTu->id])}}" class="btn btn-sm btn-warning rounded  me-3" title="Sửa"><i class="bi bi-pencil-square" ></i></a>
                                        <form action="{{route('allergens.destroy',['allergen'=>$phanTu->id])}}" method="POST" style="display:inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa Allergen này không?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa"><i class="bi bi-trash" ></i></button>
                                        </form>
                                    </div>
                                    
                                </td>
                            </tr>
                        @endforeach
                            
                    @else
                        <tr>
                            <td class="text-center text-muted" colspan="6">Không có Allergen nào</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{$item->links('pagination::bootstrap-5')}}
        </div>
    </div>

    {{-- Meal-Allergen table --}}
    <div class="d-flex  ">
        <div class=" card rounded bg-light p-3 ms-auto">
            <a href="{{route('createMap')}}"><i class="bi bi-plus-circle mb-2"></i> Add New Mapping</a>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-link text-success"></i>Meal-Allergen Mapping</h5>
            {{-- <small class="text-end">
                {{--  Tổng số Allergen thỏa query tìm kiếm 
                @if ($item->total() > 0)
                Tổng: {{$item->total()}} mục
                @else
                    Không có kết quả nào
                @endif
            </small> --}}
        </div>
        <div class="card-body table-reponsive">
            <table class="table table-hover table -bordered align-middle text-center">
                <thead class="table-success ">
                    <tr>
                        <th width="30">ID</th>
                        <th width="150">Meal</th>
                        <th width="150">Allergen</th>
                        <th width="200" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    
                        @foreach ($mealAllergens  as $map)
                            <tr>
                                <td>
                                    <input type="text" class="form-control form-control-sm sort-order text-center" value="{{$map->id ?? 1}}" min="1" data-id= "{{$map->id}}">
                                </td>
                                <td>
                                    {{$map->meals->name}}
                                </td>
                                <td>
                                    {{$map->allergens->name}}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        
                                        <form action="{{route('destroyMap',['id'=>$map->id])}}" method="POST" style="display:inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa Mappings này không?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa"><i class="bi bi-trash" ></i></button>
                                        </form>
                                    </div>
                                    
                                </td>
                            </tr>
                        @endforeach
                            
                    @if($mealAllergens ->isEmpty())
                        <tr>
                            <td class="text-center text-muted" colspan="6">Không có Mappings  nào</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{$item->links('pagination::bootstrap-5')}}
        </div>
    </div>

    {{-- Overview --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-eye text-success"></i> Meal-Allergen Overview</h5>
        </div>
        <div class="card-body">
            @foreach($meals as $meal)
                <div class="border-start border-success border-4 p-3 mb-3 bg-light rounded">
                    <h6  class="fw-bold text-dark mb-2"><i class="fas fa-utensils text-secondary"></i> {{ $meal->name }}</h6>
                    <p class="mb-0">
                        Allergens:
                        @if($meal->allergens->isEmpty())
                            <span class="text-muted">No allergens</span>
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
