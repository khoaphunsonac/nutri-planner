@extends('admin.layout')
@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{route('allergens.index')}}">Allergens Management</a></li>
            <li class="breadcrumb-item" aria-current="page"> {{$item ? ' Chỉnh sửa Allergen' : ' Thêm mới Allergen'}}</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-lg-center mb-4">
        <h2>{{$item ? ' Chỉnh sửa Allergen' : ' Thêm mới Allergen'}}</h2>
        <a href="{{route('allergens.index')}}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại </a>
    </div>
    @if (session('success'))
        <div class="alert alert-success mt-2" style="width:250px">{{session('success')}}</div>
    @endif
    <div class="row">
        <div class="col-m-8">
            <div class="row">
                <div class="card shadow-sm border-0 mb-4">
                    <form action="{{$item ? route('allergens.update',$item->id) : route('allergens.store')}}" method="POST">
                        @csrf
                        @if ($item)
                            @method('PUT')
                        @endif
                        <div class=" mb-3">
                            <label for="name" class=" my-3">Tên Allergen</label>
                            <input type="text" name="name" class="form-control" id="" value="{{$item->name ?? old('name')}}">
                            <div class="mt-4 d-flex gap-2">
                                
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i>{{$item ? 'Cập nhật Allergen' : 'Thêm Allergen'}}
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                        <i class="fas fa-undo"></i> Làm lại
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i> Hủy
                                    </button>
                                
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            
            
        </div>

       <div class="col-m-4">
            <div class="row">
                <div class="card border-0 shadow-sm">
                
                    <div class="card-body">
                        <h5>📝 Gợi ý đặt tên Allergen</h5>
                        <p> Tên Allergen nên ngắn gọn, dễ đọc, tên dạng danh từ, không thêm từ “Allergen” phía sau</p>
                        <p class="mb-0">
                            Ví dụ: 
                            <code>Peanuts</code>, 
                            <code>Tree Nuts</code>, 
                            <code>Milk</code>, 
                            <code>Eggs</code>, 
                            <code>Wheat</code>.
                        </p>
                    </div>
                </div>
            </div>
        </div>   
    </div>
    
@endsection