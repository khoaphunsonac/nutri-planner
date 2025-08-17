@extends('admin.layout')

@section('content')
{{-- Breadcrumb --}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb breadcrumb-compact">
        <li class="breadcrumb-item">
            <a href="#"><i class="bi bi-house-door"></i></a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('users.index') }}"><i class="bi bi-people-fill me-1"></i>Users Management</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            <i class="bi bi-list-ul me-1"></i>Danh sách
        </li>
    </ol>
</nav>

{{-- Compact Header --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex align-items-center">
        <h4 class="mb-0 me-3">Quản lý người dùng</h4>
        <span class="badge bg-primary rounded-pill">{{ $accounts->total() }}</span>
        <small class="text-muted ms-2">
            <i class="bi bi-info-circle me-1"></i>
            <a href="{{ route($shareUser.'index') }}" class="text-decoration-none">Quản lý tài khoản admin và người dùng</a>
        </small>
    </div>
</div>  

{{-- Dashboard summary --}}
<div class="row g-3 mb-4 d-flex justify-content-between align-items-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body d-flex p-0">
                {{-- Tổng người dùng --}}
                <div class="w-50 bg-info text-white text-center py-3 rounded-start">
                    <h5 class="mb-1">{{ $accounts->total() ?? 0 }}</h5>
                    <small>Tổng người dùng</small>
                </div>
                {{-- Tài khoản bị khoá --}}
                <div class="w-50 bg-danger-subtle text-danger text-center py-3 rounded-end">
                    <h5 class="mb-1">
                        <i class="bi bi-lock-fill me-1"></i>{{ $lockedUsers ?? 0 }}
                    </h5>
                    <small>Tài khoản bị khoá</small>
                </div>
            </div>
        </div>
    </div>
    {{-- tìm kiếm tài khoản user để lock --}}  
    <div class="col-md-6">
    <form action="{{ route($shareUser . 'index') }}" class="d-flex">
        <input 
            type="search" 
            name="keyword" 
            value="{{ request('keyword') }}" 
            class="form-control me-2 shadow-sm" 
            placeholder="Tìm kiếm tài khoản người dùng..."
            style="border-radius: 50px;"
        >
        <button type="submit" class="btn btn-primary px-4" style="border-radius: 50px;">
            <i class="bi bi-search"></i> Tìm
        </button>
    </form> 
    </div>

</div>

{{-- Table danh sách --}}

   <table class="table table-hover align-middle text-center" 
   style="border: 2px solid rgb(255, 0, 0);">
    <thead class="table-light">
        <tr>
            <th style="color: rgb(255, 94, 0)">#</th>
            <th style="color: rgb(255, 94, 0)">Tên đăng nhập</th>
            <th style="color: rgb(255, 94, 0)">Ngày tạo</th>
            <th style="color: rgb(255, 94, 0)">Email</th>
            <th style="color: rgb(255, 94, 0)">Vai trò</th>
            <th style="color: rgb(255, 94, 0)">Trạng thái</th>
            <th style="color: rgb(255, 94, 0)">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <!-- Cột số thứ tự hoặc biểu tượng -->
            <td>
                <span class="badge bg-warning text-bold rounded-pill p-2">
                    <i class="bi bi-gem" style="font-size: 20px;"></i>
                </span>
            </td>
            <td class="fw-semibold text-secondary">{{ $Admin->username }}</td>
            <td>{{ $Admin->created_at->format('d/m/Y') }}</td>
            <td>{{ $Admin->email }}</td>
            <td>
                <span class="badge bg-danger text-white px-3 py-2 rounded-pill">
                    <i class="bi bi-award-fill me-1"></i> Admin
                </span>
            </td>
            <td>
                @if ($Admin->status === 'active')
                    <span class="badge bg-success">Hoạt động</span>
                @else
                    <span class="badge bg-danger">Dừng hoạt động</span>
                @endif
            </td>
            <td>
                <a href="{{ route($shareUser.'edit') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-pencil-square"></i> Sửa tài khoản admin
                </a>
            </td>
        </tr>
    </tbody>
    </table>

    {{-- bảng user --}}
    <div class="table-responsive shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-light px-4 py-3">
        <h5 class="mb-0">Danh sách người dùng</h5>
        <small class="text-muted" style="font-size: 20px">
            @if ($accounts->count() > 0)
                Tổng: <span style="color: blue">{{ $accounts->count() }}</span> tài khoản trang hiện tại<i></i>
            @else
                Không có người dùng nào
            @endif
        </small>
    </div>
    <div class="card-body text-center">
        <table class="table table-bordered table-hover align-middle text-center mb-0">
            <thead>
                <tr>
                    <th class="text-primary">#</th>
                    <th class="text-primary">Tên đăng nhập</th>
                    <th class="text-primary">Ngày tạo</th>
                    <th class="text-primary">Email</th>
                    <th class="text-primary">Vai trò</th>
                    <th class="text-primary">Phản hồi</th>
                    <th class="text-primary">Trạng thái</th>
                    <th class="text-primary" width="300">Món yêu thích</th>
                    <th colspan="2">Thao tác</th>
                </tr>   
            </thead>
            <tbody class="table-light">
                @forelse ($accounts as $item)
                {{-- hiển thị riêng môi admin --}}
                    <tr style="cursor: pointer;" onclick="window.location='{{ route($shareUser . 'form', ['id' => $item->id]) }}'">
                       <td class="fw-bold text-primary">
                            <span class="d-inline-block px-2 py-1 border rounded bg-light sort-order text-center"
                                style="width:50px">
                                {{ ($accounts->currentPage() - 1) * $accounts->perPage() + $loop->iteration }}
                            </span>
                        </td>

                        <td class="text-center">
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
                        @php
                            $preview = $item->savemeal_preview; // mảng tối đa 3 meal
                            $total = $item->savemeal_total;     // tổng số meal
                        @endphp

                        <td>
                            @if ($total > 0)
                                @foreach ($preview as $meal)
                                    <span class="badge bg-primary mb-1">{{ $meal->name }}</span>
                                @endforeach

                                {{-- Nếu nhiều hơn 3 thì thêm dấu ... --}}
                                @if ($total > 3)
                                    <span class="badge bg-primary mb-1">...</span>
                                @endif
                            @else
                                0
                            @endif
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

        {{-- Phân trang --}}
        <div class="m-3">
            {{ $accounts->links() }}
        </div>
    </div>
</div>

@endsection
