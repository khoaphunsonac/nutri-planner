@extends('admin.layout')

@section('content')
<div class="container-fluid mt-4">
    <h4 class="mb-4 d-flex align-items-center">
    <span class="me-2 fs-4 text-success">
        <i class="bi bi-person-lines-fill"></i>
    </span>
    <span class="d-flex align-items-center gap-2">
        Số lượng người đăng ký:
        <span class="border rounded px-3 py-1 bg-white text-primary fw-bold shadow-sm">
            {{ $countUser ?? 0 }}
        </span>
    </span>
    </h4>
    @if (!$accounts->isEmpty())
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center shadow-sm">
            <thead class="table-success text-dark">
                <tr class="align-middle">
                    <th>#</th>
                    <th>Tên đăng nhập</th>
                    <th>Ngày tạo</th>
                    <th>Email</th>
                    <th>Quyền</th>
                    <th>Phản hồi</th>
                    <th colspan="2">Thao tác</th>
                </tr>
            </thead>
            <tbody class="table-light">
                @foreach ($accounts as $item)
                <tr>
                    <td class="fw-bold text-primary">{{ $item->id }}</td>
                    <td class="text-capitalize">{{ $item->username }}</td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        <span class="badge rounded-pill bg-{{ $item->role === 'admin' ? 'danger' : 'secondary' }}">
                            {{ ucfirst($item->role) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-white border border-info text-info rounded-pill shadow-sm">
                            {{ $item->feedback_count }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route($shareUser.'form', ['id' => $item->id]) }}" class="btn btn-sm btn-warning" title="Chỉnh sửa">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </td>
                    <td>
                       <a href="{{ route($shareUser.'delete', ['id' => $item->id]) }}" class="btn btn-sm btn-outline-danger" title="Xoá người dùng" onclick="return confirm('Xác nhận xoá?')">
                            <i class="bi bi-trash3-fill"></i>   
                        </a>         
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
