@extends('admin.layout')

@section('content')
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb breadcrumb-compact">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a>
            </li>
            <li class="breadcrumb-item active">
                <i class="bi bi-nut-fill me-1"></i>Loại chế độ ăn
            </li>
        </ol>
    </nav>

    {{-- Compact Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center">
            <h4 class="mb-0 me-3">Quản lý loại chế độ ăn</h4>
            <span class="badge bg-primary rounded-pill">{{ $dietTypes->total() }}</span>
            <small class="text-muted ms-2">
                <i class="bi bi-info-circle me-1"></i>Click vào dòng để xem chi tiết
            </small>
        </div>
        <a href="{{ route('diettypes.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus me-1"></i>Thêm mới
        </a>
    </div>

    {{-- Thông báo thành công --}}
    {{-- @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close pb-1" data-bs-dismiss="alert" style="font-size: 0.7rem;"></button>
        </div>
    @endif --}}

    {{-- Form lọc tìm kiếm --}}
    <form action="" method="GET" class="row g-2 align-items-center mb-4">
        <div class="col-md-8">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm chế độ ăn..."
                   value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary w-100" type="submit">
                <i class="bi bi-funnel-fill me-1"></i>Lọc
            </button>
        </div>
    </form>

    {{-- Bảng dữ liệu --}}
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Danh sách Loại Chế Độ Ăn</h5>
            <small>
                @if ($dietTypes->total() > 0)
                    Tổng: {{ $dietTypes->total() }} mục
                @else
                    Không có kết quả nào
                @endif
            </small>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">STT</th>
                            <th width="300">Tên loại</th>
                            <th>Món ăn</th>
                            <th width="120">Số Món Ăn</th>
                            <th width="180">Ngày Tạo</th>
                            <th width="200" class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dietTypes as $index => $diet)
                            <tr onclick="window.location='{{ route('diettypes.show',$diet->id) }}'" style="cursor: pointer;">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $diet->name }}</td>
                               <td class="text-center">
                        @if ($diet->meals->isNotEmpty())
                        @foreach ($diet->meals->take(3) as $meal)
            <span class="badge bg-success me-1">{{ $meal->name }}</span>
        @endforeach

        @if ($diet->meals->count() > 3)
            <span class="badge bg-success">…</span>
        @endif
    @else
        <span class="text-muted">Chưa có</span>
    @endif
</td>
                                <td>{{ $diet->meals->count() }}</td>
                                <td>{{ $diet->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="text-center" onclick="event.stopPropagation()">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('diettypes.show', $diet->id) }}" class="btn btn-sm btn-info me-2" onclick="event.stopPropagation()">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('diettypes.edit', $diet->id) }}" class="btn btn-sm btn-warning me-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="{{ route('diettypes.destroy', $diet->id) }}"
                                           class="btn btn-sm btn-danger"
                                           onclick="event.stopPropagation(); return confirm('Bạn có chắc chắn muốn xóa?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Không có loại chế độ ăn nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $dietTypes->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
