@extends('admin.layout')
@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{route('tags.index')}}">Tags Management</a></li>
            <li class="breadcrumb-item link-primary" aria-current="page"> Danh sách</li>
        </ol>
    </nav>

   
    <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Tags Management</h2>
        <a href="{{route('tags.add')}}"><i class="bi bi-plus-circle"></i> Add New Tag</a>
    </div>
    

    @if (session('success'))
        <div class="alert alert-success mt-2 text-center" style="width: 350px;">{{session('success')}}</div>
    @endif
    {{-- Dashboard summary --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card text-center -shadow-sm">
                <div class="card-body">
                    <h4>{{$totalTags ?? 0}}</h4>
                    <p class="text-muted mb-0">Tổng Tag</p>
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
                    <p class="text-muted mb-0">Sử dụng</p>
                </div>
            </div>
        </div>
    </div>

    {{-- fillter form --}}
    <form action="" method="GET" class="row g-2 align-items-center mb-5" >
        <div class="col-md-8"> 
            <input type="text" name="search" class="form-control" id="" placeholder="Tìm kiếm tag..." value="{{$search ?? old($search)}}"  >
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary w-100" type="submit">Lọc</button>
        </div>

    </form>
    {{-- Tag table --}}
    <div class="table-reponsive">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Danh sách Tags</h5>
            <small>
                {{--  Tổng số tag thỏa query tìm kiếm --}}
                @if ($item->total() > 0)
                Tổng: {{$item->total()}} mục
                @else
                    Không có kết quả nào
                @endif</small>
        </div>
        <div class="card-body text-center">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="30">ID</th>
                        <th width="150">Tên Tag</th>
                        {{-- <th width="150">Trạng thái</th> --}}
                        <th width="100">Số món ăn</th>
                        <th width="150">Ngày tạo</th>
                        <th width="150" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (count($item)>0)
                        @foreach ($item as $phanTu)
                            <tr onclick="window.location='{{route('tags.show',['id'=>$phanTu->id])}}'" style="cursor: pointer;">
                                <td class="align-middle text-center">
                                    <span class=" d-inline-block px-2 py-1 border rounded bg-light sort-order text-center" style="width:50px">{{$phanTu->id ?? 1}} </span>
                                </td>
                                <td>
                                    {{$phanTu->name}}
                                </td>
                                {{-- <td>
                                    @if ($phanTu['deleted_at'])
                                        <span class="badge bg-danger">Đã xóa</span>
                                    @else
                                        <span class="badge bg-success">Hoạt động</span>
                                    @endif
                                </td> --}}
                                <td>
                                    {{$phanTu->meals_count}}
                                </td>
                                <td>
                                    {{ $phanTu->created_at ? \Carbon\Carbon::parse($phanTu->created_at)->format('d/m/Y H:i')  : 0 }}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{route('tags.show',['id'=>$phanTu->id])}}" class="btn btn-sm btn-info rounded  me-3" title="chi tiết"><i class="bi bi-eye" ></i></a>
                                        <a href="{{route('tags.form',['id'=>$phanTu->id])}}" class="btn btn-sm btn-warning rounded  me-3" title="Sửa"><i class="bi bi-pencil-square" ></i></a>
                                        <form action="{{route('tags.delete',['id'=>$phanTu->id])}}" method="POST" style="display:inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tag này không?')">
                                            @csrf
                                            
                                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa"><i class="bi bi-trash" ></i></button>
                                        </form>
                                        
                                    </div>
                                    
                                </td>
                            </tr>
                        @endforeach
                            
                    @else
                        <tr>
                            <td class="text-center text-muted" colspan="6">Không có tag nào</td>
                        </tr>
                    @endif
                </tbody>
        </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{$item->links('pagination::bootstrap-5')}}
        </div>
    </div>


@endsection
