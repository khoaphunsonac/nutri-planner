@extends('admin.layout')
@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{route('allergens.index')}}">Allergens Management</a></li>
            <li class="breadcrumb-item link-primary" aria-current="page"> {{$item ? ' Chỉnh sửa Allergen' : ' Thêm mới Allergen'}}</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-lg-center mb-4">
        <h2>{{$item ? ' Chỉnh sửa Allergen' : ' Thêm mới Allergen'}}</h2>
        <a href="{{route('allergens.index')}}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại </a>
    </div>
    @if (session('success'))
        <div class="alert alert-success mt-2 text-center" style="width:300px">{{session('success')}}</div>
    @endif
    <div class="row">
        <div class="col-m-8">
            <div class="row">
                <div class="card shadow-sm border-0 mb-4">
                    <form action="{{ route('allergens.save' )}}" method="POST">
                        @csrf
                        @if ($item)
                            <input type="hidden" name="id" value="{{$item->id}}">
                        @endif
                        <div class=" mb-3">
                            <label for="name" class=" my-3">Tên Allergen</label>
                            <input type="text" name="name" class="form-control" id="" value="{{$item->name ?? old('name')}}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="mt-4 d-flex gap-2">
                                
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i>{{$item ? 'Cập nhật Allergen' : 'Thêm Allergen'}}
                                    </button>
                                     {{-- nút xóa --}}
                                    <button type="reset" class="btn btn-secondary" onclick="clearForm()">
                                        <i class="fas fa-undo"></i> Làm lại
                                    </button>
                                    {{-- nút khôi phục --}}
                                    <button type="reset" class="btn btn-info text-white">Khôi phục</button>
                                    @if ($item)
                                    {{-- Nếu đang sửa thì hiện thêm nút “Chi tiết” và “Thêm mới” --}}
                                    {{-- <a href="{{ route('allergens.show', ['id' => $item->id, 'redirect'=>url()->current()]) }}" class="btn btn-outline-dark">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </a> --}}

                                    <a href="{{ route('allergens.add') }}" class="btn btn-success">
                                        <i class="fas fa-plus-circle"></i> Thêm mới
                                    </a>
                                @endif
                                    <a href="{{route('allergens.index')}}" class="btn btn-outline-secondary"> Hủy</a>
                                
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


    <script>
        function clearForm() {
        document.querySelector('input[name=name]').value = '';
        }
    </script>
@endsection