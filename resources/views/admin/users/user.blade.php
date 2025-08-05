@extends('admin.layout')

@section('content')

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users Management</a></li>
        {{-- sau link sau --}}
        <li class="breadcrumb-item link-primary" aria-current="page">Danh sách</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Users Management</h2>
    {{-- <a href="{{ route('users.add') }}"><i class="bi bi-plus-circle"></i> Thêm người dùng</a> --}}
</div>


<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body d-flex p-0">

                {{-- người dùng --}}
                <div class="w-50 bg-info text-white text-center py-3 rounded-start">
                    <h5 class="mb-1">{{ $countUser ?? 0 }}
                    </h5>
                    <small>Tổng người dùng</small>
                </div>

                {{--khoản bị khoá --}}
                <div class="w-50 bg-danger-subtle text-danger text-center py-3 rounded-end">
                    <h5 class="mb-1">
                        <i class="bi bi-lock-fill me-1"></i>{{ $lockedUsers ?? 0 }}
                    </h5>
                    <small>Tài khoản bị khoá</small>
                </div>

            </div>
        </div>
    </div>
</div>



<div class="table-responsive shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-light px-4 py-3">
    <h5 class="mb-0">Danh sách người dùng</h5>
    <small class="text-muted">
        @if ($accounts->count() > 0)
            Tổng: <span style="color: blue">{{ $accounts->count() }}</span> mục
        @else
            Không có người dùng nào
        @endif
    </small>
</div>
    <div class="card-body text-center">
        <table class="table table-bordered table-hover align-middle text-center mb-0">
            <thead class="bg-info text-white">
                <tr>
                    <th>#</th>
                    <th>Tên đăng nhập</th>
                    <th>Ngày tạo</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Phản hồi</th>
                    <th>Trạng thái</th>
                    <th colspan="2">Thao tác</th>
                </tr>
            </thead>
           <tbody class="table-light">
    @forelse ($accounts as $item)
        <tr style="cursor: pointer;" onclick="window.location='{{ route($shareUser . 'form', ['id' => $item->id]) }}'">
            <td class="fw-bold text-primary">
                <span class="d-inline-block px-2 py-1 border rounded bg-light sort-order text-center"
                    style="width:50px">
                    {{ $item->id }}
                </span>
            </td>
            <td class="text-start">
                <strong>{{ $item->username }}</strong>
            </td>
            <td>{{ $item->created_at->format('d/m/Y') }}</td>
            <td>{{ $item->email }}</td>
            <td>
                <span class="badge rounded-pill bg-{{ $item->role === 'admin' ? 'danger' : 'secondary' }}">
                    {{ ucfirst($item->role) }}
                </span>
            </td>
            <td>
                <span class="badge bg-success text-white rounded-circle shadow-sm">
                    {{ $item->feedback_count }}
                </span>
            </td>
            <td class="{{ $item->status === 'active' ? 'text-success' : 'text-danger' }}">
                {{ $item->status === 'active' ? 'Hoạt động' : 'Đã bị khoá' }}
            </td>
            <td class="text-center" onclick="event.stopPropagation();">
                <a href="{{ route($shareUser . 'form', ['id' => $item->id]) }}"
                    class="btn btn-sm btn-warning rounded me-2" title="Chỉnh sửa">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a href="{{ route($shareUser . 'delete', ['id' => $item->id]) }}"
                    class="btn btn-sm btn-outline-danger rounded" title="Xoá người dùng"
                    onclick="return confirm('Xác nhận xoá?')">
                    <i class="bi bi-trash3-fill"></i>
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-muted">Không có người dùng nào</td>
        </tr>
    @endforelse
</tbody>

        </table>
    </div>
</div>

@endsection
