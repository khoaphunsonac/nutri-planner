@extends('admin.layout')

@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="#">Dashboard</a></li>
            <li class="breadcrumb-item link-primary" aria-current="page">Quản lý loại chế độ ăn</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Diet Types Management</h2>
        <a href="{{ route('diettypes.create') }}" class="btn btn-success"><i class="bi bi-plus-circle"></i> Thêm mới</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-2 text-center" style="width: 350px;">{{ session('success') }}</div>
    @endif

    {{-- Form lọc tìm kiếm --}}
    <form action="" method="GET" class="row g-2 align-items-center mb-4">
        <div class="col-md-8">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm chế độ ăn..."
                   value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary w-100" type="submit">Lọc</button>
        </div>
    </form>

    {{-- Bảng dữ liệu --}}
    <div class="table-responsive">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Danh sách Loại Chế Độ Ăn</h5>
            <small>
                @if ($dietTypes->total() > 0)
                    Tổng: {{ $dietTypes->total() }} mục
                @else
                    Không có kết quả nào
                @endif
            </small>
        </div>

        <div class="card-body text-center">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">ID</th>
                        <th width="300">Tên loại</th>
                        <th width="200" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dietTypes as $diet)
                        <tr onclick="window.location='{{ route('diettypes.show', $diet->id) }}'" style="cursor: pointer;">
                            <td>{{ $diet->id }}</td>
                            <td>{{ $diet->name }}</td>
                            <td class="text-center" onclick="event.stopPropagation()">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('diettypes.show', $diet->id) }}" class="btn btn-sm btn-info me-2" onclick="event.stopPropagation()">
                                        <i class="bi bi-eye"></i>
                                    <a href="{{ route('diettypes.edit', $diet->id) }}" class="btn btn-sm btn-warning me-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('diettypes.destroy', $diet->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Không có loại chế độ ăn nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $dietTypes->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
