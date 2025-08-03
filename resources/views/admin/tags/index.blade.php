@extends('admin.layout')
@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="">Tags Management</a></li>
            <li class="breadcrumb-item" aria-current="page"> <a href="">Danh sách</a></li>
        </ol>
    </nav>

   
    <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Tags Management</h2>
        <a href="{{route('tags.create')}}"><i class="bi bi-plus-circle"></i> Add New Tag</a>
    </div>
    

    @if (session('success'))
        <div class="alert alert-success mt-2">{{session('success')}}</div>
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
            <input type="text" name="search" class="form-control" id="" placeholder="Tìm kiếm tag..." value="{{$search ?? old($search)}}">
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
            <table class="table table-hover table -bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="30">ID</th>
                        <th width="150">Tên Tag</th>
                        {{-- <th width="150">Trạng thái</th> --}}
                        {{-- <th width="150">Số món ăn</th> --}}
                        <th width="150">Ngày tạo</th>
                        <th width="200" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (count($item)>0)
                        @foreach ($item as $phanTu)
                            <tr>
                                <td>
                                    <input type="number" class="form-control form-control-sm sort-order text-center" value="{{$phanTu['id'] ?? 1}}" min="1" data-id= "{{$phanTu['id']}}">
                                </td>
                                <td>
                                    {{$phanTu['name']}}
                                </td>
                                {{-- <td>
                                    @if ($phanTu['deleted_at'])
                                        <span class="badge bg-danger">Đã xóa</span>
                                    @else
                                        <span class="badge bg-success">Hoạt động</span>
                                    @endif
                                </td> --}}
                                {{-- <td>
                                    
                                </td> --}}
                                <td>

                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{route('tags.show',['tag'=>$phanTu->id])}}" class="btn btn-sm btn-info rounded  me-3" title="chi tiết"><i class="bi bi-eye" ></i></a>
                                        <a href="{{route('tags.edit',['tag'=>$phanTu->id])}}" class="btn btn-sm btn-warning rounded  me-3" title="Sửa"><i class="bi bi-pencil-square" ></i></a>
                                        <form action="{{route('tags.destroy',['tag'=>$phanTu->id])}}" method="POST" style="display:inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tag này không?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa"><i class="bi bi-trash" ></i></button>
                                        </form>
                                        {{-- <a href="#" class="btn btn-sm btn-danger" title="Xóa"> <i class="bi bi-trash" ></i></a> --}}
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

    {{-- Pagination --}}
    
        {{-- <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center mb-0">
                <li class="page-item"><a href="#" class="page-link">Trước</a></li>
                <li class="page-item active" ><a href="#" class="page-link">1</a></li>
                <li class="page-item " ><a href="#" class="page-link">2</a></li>
                <li class="page-item " ><a href="#" class="page-link">3</a></li>
                <li class="page-item"><a href="#" class="page-link">Sau</a></li>
            </ul>
        </nav> --}}
        

@endsection
