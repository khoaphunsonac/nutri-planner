@extends('admin.layout')
@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{route('allergens.index')}}">Allergens Management</a></li>
            <li class="breadcrumb-item link-primary" aria-current="page"> Thêm mới Allergen Mapping</li>
        </ol>
    </nav>

   
    <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Allergens Management</h2>
            <a href="{{route('allergens.index')}}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại </a>
    </div>

    {{-- Thêm mapping Meal-Allergen table --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="{{ route('allergens.mapping.save') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-5">
                    <label class="form-label">Chọn Món Ăn</label>
                    <select name="meal_id" class="form-select" >
                        <option value="">-- Chọn món --</option>
                        @foreach($meals as $meal)
                            <option value="{{ $meal->id }}" {{ old('meal_id') == $meal->id ? 'selected' : '' }}>{{ $meal->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-5">
                    <label class="form-label">Chọn Dị Ứng</label>
                    <select name="allergen_id" class="form-select" >
                        <option value="">-- Chọn dị ứng --</option>
                        @foreach($allergens as $allergen)
                            <option value="{{ $allergen->id }}"  {{ old('allergen_id') == $allergen->id ? 'selected' : '' }}>{{ $allergen->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-plus-circle"></i> Thêm
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection