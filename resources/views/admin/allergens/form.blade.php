@extends('admin.layout')
@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{route('allergens.index')}}">Quản lý Dị ứng</a></li>
            <li class="breadcrumb-item link-primary" aria-current="page"> {{$item ? ' Chỉnh sửa Allergen' : ' Thêm mới Allergen'}}</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-lg-center mb-4">
        <h2>{{$item ? ' Chỉnh sửa Dị ứng' : ' Thêm mới Dị ứng'}}</h2>
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
                            <label for="name" class=" my-3">Tên Dị ứng</label>
                            <input type="text" name="name" class="form-control" id="" value="{{$item->name ?? old('name')}}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="mt-4 d-flex gap-2">
                                
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i>{{$item ? 'Cập nhật Dị ứng' : 'Thêm Dị ứng'}}
                                    </button>
                                     {{-- nút xóa --}}
                                    <button type="reset" class="btn btn-secondary" onclick="clearForm()">
                                        <i class="fas fa-undo"></i> Làm lại
                                    </button>
                                    
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
                        <h5>📝 Gợi ý đặt tên Dị ứng</h5>
                        <p> Tên Dị ứng nên ngắn gọn, dễ đọc, tên dạng danh từ, không thêm từ “Dị ứng” phía sau</p>
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
            const form = document.getElementById('tagForm');
            const isEditing = !!document.querySelector('input[name="id"]'); // Nếu có ID là đang sửa

            if (isEditing) {
                // Gán lại dữ liệu từ data-default
                form.querySelectorAll('input, textarea, select').forEach(el => {
                    if (el.dataset.default !== undefined) {
                        el.value = el.dataset.default;
                    }
                    if (el.type === 'checkbox' || el.type === 'radio') {
                        el.checked = el.dataset.default === '1' ? true : false;
                    }
                });
            } else {
                // Xóa sạch khi thêm mới
                form.querySelectorAll('input, textarea, select').forEach(el => {
                    if (el.type !== 'hidden' && el.type !== 'submit' && el.type !== 'button') {
                        el.value = '';
                        if (el.type === 'checkbox' || el.type === 'radio') el.checked = false;
                    }
                });
            }
        }
    </script>
@endsection