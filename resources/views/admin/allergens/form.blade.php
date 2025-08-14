@extends('admin.layout')
@section('content')
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb breadcrumb-compact">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item"> <a href="{{route('allergens.index')}}"><i class="bi bi-exclamation-triangle"> Dị ứng</i></a></li>
            <li class="breadcrumb-item active ">  {{  isset($item) && $item ? 'Cập nhật Dị ứng: ' . $item->name : 'Thêm Dị ứng mới' }} </li>
        </ol>
    </nav>
     {{-- Header --}}
    <div class="d-flex justify-content-between align-items-lg-center mb-4">
        <h2>{{isset($item) && $item ? ' Cập nhật Dị ứng:  '. $item->name  : ' Thêm Dị ứng '}}</h2> 
        <a href="{{route('allergens.index')}}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Quay lại </a>
    </div>

    
    {{-- @if (session('success'))
        <div class="alert alert-success mt-2 text-center" style="width:300px">{{session('success')}}</div>
    @endif --}}


     
    <div class="row mt-4">
    {{-- Form nhập Dị ứng --}}
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body shadow-lg">
                <form action="{{ route('allergens.save') }}" method="POST">
                    @csrf
                    @if ($item)
                        <input type="hidden" name="id" value="{{ $item->id }}">
                    @endif

                    {{-- Tên dị ứng --}}
                    <div class="mb-4">
                        <h5 class="form-label fw-bold mb-2">Tên Dị ứng</h5>
                        <input type="text" name="name" class="form-control" 
                               value="{{ $item->name ?? old('name') }}" placeholder="Nhập tên dị ứng"  style="cursor: text">
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Danh sách món ăn --}}
                    <div class="mb-4" >
                        <h5 class="form-label fw-bold mb-2">Chọn món ăn liên quan</h5>
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
                                                   {{ (isset($item) && $item->meals->contains($meal->id)) ? 'checked' : '' }} style="cursor: pointer">
                                            <label class="form-check-label" for="meal_{{ $meal->id }}"  style="cursor: pointer">
                                                {{ $meal->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Phân trang --}}
                        <div class="mt-3">
                            {{ $meals->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                    {{-- Nút submit --}}
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> {{ isset($item) ? 'Cập nhật Dị ứng' : 'Thêm Dị ứng' }}
                        </button>
                        <button type="reset" class="btn btn-secondary" onclick="clearForm()">
                            <i class="fas fa-undo me-1"></i> Làm lại
                        </button>
                        <a href="{{ route('allergens.index') }}" class="btn btn-outline-secondary">
                            Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Gợi ý đặt tên --}}
    <div class="col-lg-4">
        <div class="card border-1 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-3">📝 Gợi ý đặt tên Dị ứng</h5>
                <hr>
                <p class="mb-2"><strong>📌 Gợi ý:</strong> Tên Dị ứng nên ngắn gọn, dễ đọc, tên dạng danh từ, 
                    <span class="text-danger">không thêm từ “Dị ứng”</span> phía sau.</p>
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