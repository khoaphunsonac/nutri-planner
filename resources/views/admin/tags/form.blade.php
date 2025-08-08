@extends('admin.layout')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item"> <a href="{{route('tags.index')}}"><i class="bi bi-tags">Thẻ</i></a></li>
            <li class="breadcrumb-item active " aria-current="page">  {{  isset($item) && $item ? 'Cập nhật Thẻ: ' . $item->name : 'Thêm Thẻ mới' }} </li>
        </ol>
    </nav>
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-lg-center mb-4">
        <h2>{{isset($item) && $item ? ' Cập nhật Thẻ:  '. $item->name  : ' Thêm Thẻ '}}</h2>
        <a href="{{route('tags.index')}}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại </a>
    </div>
 


    @if (session('success'))
        <div class="alert alert-success mt-2 text-center" style="width:350px">{{session('success')}}</div>
    @endif

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body shadow-lg">
                    <form action="{{ route('tags.save')}}" id="tagForm" method="POST">
                        @csrf
                        @if ($item)
                            <input type="hidden" name="id" value="{{$item->id}}">
                        @endif
                         {{-- Tên thẻ --}}
                        <div class=" mb-4">
                            <h4 for="name" class="form-label fw-bold mb-2">Tên Thẻ</h4>
                            <input type="text" name="name" class="form-control" id=""  value="{{ $item->name ?? old('name') }}" style="cursor: pointer">
                            @error('name')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                            
                        </div>

                        {{-- Danh sách món ăn --}}
                        <div class="mb-4" >
                            <h4 class="form-label fw-bold mb-2">Chọn món ăn liên quan</h4>
                            <div class="border rounded p-3" style="max-height: 1000px; overflow-y: auto;">
                                <div class="row">
                                    @foreach($meals as $meal)
                                        <div class="col-md-4 col-sm-6 col-12 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                    type="checkbox"
                                                    name="meals[]"
                                                    value="{{ $meal->id }}"
                                                    id="meal_{{ $meal->id }}"
                                                    {{  in_array($meal->id, $selectedMeals) ? 'checked' : ''  }} style="cursor: pointer">
                                                <label class="form-check-label" for="meal_{{ $meal->id }}" >
                                                    {{ $meal->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        {{-- Phân trang --}}
                        <div class="mt-3">
                            {{ $meals->links('pagination::bootstrap-5') }}
                        </div>
                        {{-- Nút submit --}}
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
                    </form>
                </div>

            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-1 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold text-primary mb-3">📝 Gợi ý đặt tên Thẻ</h5>
                    <hr>
                    <p class="mb-2">
                        <strong>📌 Gợi ý:</strong> Tên Thẻ nên ngắn gọn, có ý nghĩa mô tả 
                        <span class="text-success">chế độ ăn</span> hoặc <span class="text-success">đặc tính món ăn</span>.
                    </p>
                    <p class="mb-2">
                        <strong>🎯 Mẹo:</strong> Hãy chọn tên dễ hiểu để người dùng nhận biết nhanh 
                        khi xem danh sách.
                    </p>
                    <p class="mb-0">
                        <strong>✅ Ví dụ:</strong><br>
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

 
    
    // Chỉ là ví dụ JS: click checkbox -> đổi màu row
    document.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            if (this.checked) {
                this.parentNode.style.color = 'green';
            } else {
                this.parentNode.style.color = 'black';
            }
        });
    });


</script>
@endsection