@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <h2><i class="bi bi-basket me-2"></i>Danh sách nguyên liệu</h2>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <span class="text-muted me-2">Tổng số nguyên liệu:</span>
                <span class="badge bg-primary">{{ count($ingredients) }}</span>
            </div>
            <a href="{{ route('ingredients.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>Thêm nguyên liệu
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success d-flex align-items-center mb-4">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="ingredients-card card">
            <div class="table-responsive">
                <table class="ingredients-table table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Tên nguyên liệu</th>
                            <th style="width: 100px;">Đơn vị</th>
                            <th style="width: 100px;">Protein</th>
                            <th style="width: 100px;">Carb</th>
                            <th style="width: 100px;">Fat</th>
                            <th style="width: 120px;">Calo</th>
                            <th style="width: 140px;" class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ingredients as $ingredient)
                            <tr>
                                <td class="fw-medium">{{ $loop->iteration }}</td>
                                <td class="fw-medium">{{ $ingredient->name }}</td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $ingredient->unit }}</span>
                                </td>
                                <td>{{ number_format($ingredient->protein, 1) }}g</td>
                                <td>{{ number_format($ingredient->carb, 1) }}g</td>
                                <td>{{ number_format($ingredient->fat, 1) }}g</td>
                                <td>
                                    <span class="fw-medium text-primary">{{ number_format($ingredient->calo, 1) }}</span>
                                    <small class="text-muted">kcal</small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('ingredients.edit', $ingredient->id) }}" class="btn btn-warning"
                                            title="Chỉnh sửa">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger"
                                            onclick="confirmDelete({{ $ingredient->id }})" title="Xóa">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $ingredient->id }}" method="POST"
                                        action="{{ route('ingredients.destroy', $ingredient->id) }}"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-basket3 fs-1 d-block mb-3"></i>
                                        <p class="mb-2">Chưa có nguyên liệu nào</p>
                                        <a href="{{ route('ingredients.create') }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-circle me-1"></i>Thêm nguyên liệu đầu tiên
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm('Bạn có chắc chắn muốn xóa nguyên liệu này không?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endsection
