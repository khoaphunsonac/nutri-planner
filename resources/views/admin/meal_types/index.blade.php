@extends('admin.layout')
@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Danh sách loại bữa ăn</h4>
        <a href="{{ route('admin.meal_types.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Thêm
        </a>
    </div>

    <!-- Alerts -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close pb-1" data-bs-dismiss="alert" style="font-size:.7rem"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first() }}
            <button type="button" class="btn-close pb-1" data-bs-dismiss="alert" style="font-size:.7rem"></button>
        </div>
    @endif

    <!-- Search -->
    <form method="get" class="mb-3" role="search" aria-label="Tìm loại bữa ăn">
        <div class="input-group">
            <input name="q" class="form-control" placeholder="Tìm theo tên…" value="{{ $q ?? '' }}">
            <button class="btn btn-outline-secondary" type="submit">Tìm</button>
        </div>
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="width:80px">ID</th>
                    <th>Tên loại</th>
                    <th style="width:220px">Ngày tạo</th>
                    <th style="width:160px">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $it)
                    <tr onclick="window.location='{{ route('admin.meal_types.show', $it->id) }}'" style="cursor:pointer;">
                        <td>{{ $it->id }}</td>
                        <td class="text-start">{{ $it->name }}</td>
                        <td>{{ $it->created_at?->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.meal_types.show', $it->id) }}"
                               class="btn btn-sm btn-secondary"
                               title="Xem" aria-label="Xem"
                               onclick="event.stopPropagation()">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('admin.meal_types.edit', $it->id) }}"
                               class="btn btn-sm btn-info"
                               title="Sửa" aria-label="Sửa"
                               onclick="event.stopPropagation()">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            {{-- Route xoá dùng GET /{id}/delete theo định nghĩa hiện tại --}}
                            <a href="{{ route('admin.meal_types.delete', $it->id) }}"
                               class="btn btn-sm btn-danger"
                               title="Xoá" aria-label="Xoá"
                               onclick="event.stopPropagation(); return confirm('Xác nhận xoá?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            Chưa có dữ liệu.
                            <a href="{{ route('admin.meal_types.create') }}" class="ms-1">Thêm mới ngay</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($items->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-2">
            <div class="small text-muted">
                Hiển thị {{ $items->firstItem() }}–{{ $items->lastItem() }} / {{ $items->total() }}
            </div>
            {{ $items->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
