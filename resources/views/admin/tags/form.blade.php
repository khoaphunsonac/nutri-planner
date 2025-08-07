@extends('admin.layout')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="#"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item"> <a href="{{route('tags.index')}}"><i class="bi bi-tags">Thẻ</i></a></li>
            <li class="breadcrumb-item link-primary " aria-current="page">  {{  isset($item) && $item ? 'Cập nhật Thẻ: ' . $item->name : 'Thêm Thẻ mới' }} </li>
        </ol>
    </nav>
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-lg-center mb-4">
        <h2>{{isset($item) && $item ? ' Cập nhật Thẻ '. $item->name  : ' Thêm Thẻ '}}</h2>
        <a href="{{route('tags.index')}}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại </a>
    </div>
 


    @if (session('success'))
        <div class="alert alert-success mt-2 text-center" style="width:350px">{{session('success')}}</div>
    @endif
    <div class="row">
        <div class="col-m-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <form action="{{ route('tags.save')}}" id="tagForm" method="POST">
                        @csrf
                        @if ($item)
                            <input type="hidden" name="id" value="{{$item->id}}">
                        @endif
                        <div class=" mb-3">
                            <label for="name" class=" mb-3"><strong>Tên Thẻ</strong></label>
                            <input type="text" name="name" class="form-control" id="" data-default="{{ $item->name ?? '' }}" value="{{old('name', $item->name ?? '')}}">
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

                        {{-- Nhập để tìm món ăn --}}
                        <div class="mb-3">
                            <label for="meal-search"><strong>Thêm món ăn</strong></label>
                            <input list="meal-options" id="meal-search" class="form-control mb-2" placeholder="Nhập tên món ăn để chọn">
                            <datalist id="meal-options">
                                @foreach ($allMeals as $meal)
                                    <option data-id="{{ $meal->id }}" value="{{ $meal->name }}"></option>
                                @endforeach
                            </datalist>

                            {{-- Danh sách món ăn đã chọn --}}
                            <div id="selected-meals" class="mt-2">
                                @if(isset($item))
                                    @foreach ($item->meals as $meal)
                                        <span class="badge bg-success me-1 mb-1 selected-meal" data-id="{{ $meal->id }}">
                                            {{ $meal->name }}
                                            <button type="button" class="btn-close btn-close-white btn-sm ms-1 remove-meal" aria-label="Remove"></button>
                                        </span>
                                    @endforeach
                                @endif
                            </div>

                            {{-- Hidden input để submit --}}
                            <input type="hidden" name="meals" id="meals-hidden">
                        </div>


                    </form>
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

 
    const input = document.getElementById('meal-search');
    const hiddenInput = document.getElementById('meals-hidden');
    const selectedMealsDiv = document.getElementById('selected-meals');

    // Lưu ID đã chọn
    let selectedMealIds = [];

    // Nếu có sẵn (khi sửa tag)
    document.querySelectorAll('.selected-meal').forEach(el => {
        const id = el.dataset.id;
        const name = el.innerText.trim();
        selectedMealIds.push(id);
        renderMeal(id, name); // render lại để có nút xóa
        el.remove(); // xóa thẻ ban đầu (nếu có sẵn)
    });
    updateHiddenInput();

    // Khi người dùng chọn từ datalist
    input.addEventListener('change', function () {
        const selectedOption = [...document.querySelectorAll('#meal-options option')]
            .find(option => option.value === input.value);

        if (selectedOption) {
            const id = selectedOption.dataset.id;
            const name = selectedOption.value;

            if (!selectedMealIds.includes(id)) {
                selectedMealIds.push(id);
                renderMeal(id, name);
                updateHiddenInput();
            }

            input.value = '';
        }
    });

    // Render thẻ món ăn
    function renderMeal(id, name) {
        const span = document.createElement('span');
        span.classList.add('badge', 'bg-success', 'me-1', 'mb-1', 'selected-meal');
        span.dataset.id = id;
        span.innerHTML = `${name} <button type="button" class="btn-close btn-close-white btn-sm ms-1 remove-meal" aria-label="Remove"></button>`;

        selectedMealsDiv.appendChild(span);

        // Gắn sự kiện xóa
        span.querySelector('.remove-meal').addEventListener('click', () => {
            selectedMealsDiv.removeChild(span);
            selectedMealIds = selectedMealIds.filter(mId => mId !== id);
            updateHiddenInput();
        });
    }

    // Cập nhật hidden input để submit
    function updateHiddenInput() {
        hiddenInput.value = selectedMealIds.join(',');
    }



</script>
@endsection