@extends('admin.layout')
@section('content')
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb breadcrumb-compact">
            <li class="breadcrumb-item"><a href="#"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item"> <a href="{{route('allergens.index')}}"><i class="bi bi-exclamation-triangle">Dị ứng</i></a></li>
            <li class="breadcrumb-item active ">  {{  isset($item) && $item ? 'Cập nhật Dị ứng: ' . $item->name : 'Thêm Dị ứng mới' }} </li>
        </ol>
    </nav>
     {{-- Header --}}
    <div class="d-flex justify-content-between align-items-lg-center mb-4">
        <h2>{{isset($item) && $item ? ' Cập nhật Dị ứng:  '. $item->name  : ' Thêm Dị ứng '}}</h2> 
        <a href="{{route('allergens.index')}}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại </a>
    </div>

    
    @if (session('success'))
        <div class="alert alert-success mt-2 text-center" style="width:300px">{{session('success')}}</div>
    @endif

    <div class="row mt-4">
        <div class="col-md-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <form action="{{ route('allergens.save' )}}" method="POST">
                            @csrf
                            @if ($item)
                                <input type="hidden" name="id" value="{{$item->id}}">
                            @endif
                            <div class=" mb-3">
                                <h3 for="name" class=" form-label fw-bold my-3">Tên Dị ứng</h3>
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

       <div class="col-md-4">
                <div class="card border-1 shadow-sm">
                
                    <div class="card-body">
                        <h5 class="fw-bold text-primary mb-3">📝 Gợi ý đặt tên Dị ứng</h5> <hr>
                        <p class="mb-2"><strong>📌 Gợi ý:</strong> Tên Dị ứng nên ngắn gọn, dễ đọc, tên dạng danh từ, <span class="text-danger">không thêm từ “Dị ứng”</span> phía sau.</p>
                        <p class="mb-2"><strong>🎯 Mẹo:</strong> Hãy chọn tên dễ hiểu để người dùng không bị nhầm lẫn khi xem danh sách.</p>
                        <p class="mb-0">
                            <strong>✅ Ví dụ:</strong><br>
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