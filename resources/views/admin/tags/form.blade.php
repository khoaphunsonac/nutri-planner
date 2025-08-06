@extends('admin.layout')
@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{route('tags.index')}}">Quản lý Thẻ</a></li>
            <li class="breadcrumb-item link-primary " aria-current="page">  {{ $item ? 'Chỉnh sửa Thẻ' : 'Thêm mới Thẻ' }}</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-lg-center mb-4">
        <h2>{{$item ? ' Chỉnh sửa Thẻ' : ' Thêm mới Thẻ'}}</h2>
        <a href="{{route('tags.index')}}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại </a>
    </div>
    @if (session('success'))
        <div class="alert alert-success mt-2 text-center" style="width:350px">{{session('success')}}</div>
    @endif
    <div class="row">
        <div class="col-m-8">
            <div class="row">
                <div class="card shadow-sm border-0 mb-4">
                <form action="{{ route('tags.save')}}" id="tagForm" method="POST">
                    @csrf
                    @if ($item)
                        <input type="hidden" name="id" value="{{$item->id}}">
                    @endif
                    <div class=" mb-3">
                        <label for="name" class=" my-3"><strong>Tên Thẻ</strong></label>
                        <input type="text" name="name" class="form-control" id="" data-default="{{ $item->name ?? '' }}" value="{{$item->name ?? old('name')}}">
                        @error('name')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        <div class="mt-4 d-flex gap-2">
                            
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i>{{$item ? 'Cập nhật Thẻ' : 'Thêm Thẻ'}}
                                </button>
                                {{-- nút xóa --}}
                                <button type="button" class="btn btn-secondary" onclick="clearForm()">
                                    <i class="fas fa-undo"></i> Làm lại
                                </button>
                                
                                <a href="{{route('tags.index')}}" class="btn btn-outline-secondary"> Hủy</a>
                        </div>
                    </div>

                </form>
            </div>
            </div>
            
            
        </div>

       <div class="col-m-4">
            <div class="card border-0 shadow-sm">
            
                <div class="card-body">
                    <h5>📝 Gợi ý đặt tên Thẻ</h5>
                    <p> Tên Thẻ nên ngắn gọn, có ý nghĩa mô tả chế độ ăn hoặc đặc tính món ăn.</p>
                    <p class="mb-0">
                        Ví dụ: 
                        <code>Low Carb</code>, 
                        <code>Gluten Free</code>, 
                        <code>Vegetarian</code>, 
                        <code>Quick</code>, 
                        <code>High Protein</code>.
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