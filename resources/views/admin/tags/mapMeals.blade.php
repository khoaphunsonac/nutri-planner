@extends('admin.layout')
@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{route('tags.index')}}">Tags Management</a></li>
            <li class="breadcrumb-item link-primary" aria-current="page"> Danh sách</li>
        </ol>
    </nav>

   
    <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Tags Management</h2>
        <a href="{{route('tags.add')}}"><i class="bi bi-plus-circle"></i> Add New Tag</a>
    </div>

    <div class="modal fade" id="mealTagModal" tabindex="-1" aria-labelledby="mealTagModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('tags.mapMeal', ['id' => $item->id]) }}" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mealTagModalLabel">Gán món ăn cho Tag: {{ $item->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @foreach ($meals as $meal)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="meals[]" value="{{ $meal->id }}"
                            {{ $item->meals->contains($meal->id) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $meal->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Lưu</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            </div>
        </div>
    </form>
  </div>
</div>

@endsection