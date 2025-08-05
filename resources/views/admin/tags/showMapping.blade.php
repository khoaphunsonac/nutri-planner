@extends('admin.layout')
@section('content')
<div class="card">
    <div class="card-header">
        <h5>Gán món ăn cho Tag: {{ $tag->name }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('tags.mapMeals', $tag->id) }}" method="POST">
            @csrf
            @foreach($allMeals as $meal)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="meals[]" value="{{ $meal->id }}"
                        {{ $tag->meals->contains($meal->id) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $meal->name }}</label>
                </div>
            @endforeach

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="{{ route('tags.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection
