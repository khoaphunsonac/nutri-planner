@extends('Admin.layout')

@section('content')

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb breadcrumb-compact">
        <li class="breadcrumb-item">
            <a href="#"><i class="bi bi-house-door"></i></a>
        </li>
        <li class="breadcrumb-item active">
            <i class="bi bi-chat-dots me-1"></i>Phản hồi người dùng
        </li>
    </ol>
</nav>

{{-- Compact Header --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex align-items-center">
        <h4 class="mb-0 me-3">Quản lý phản hồi người dùng</h4>
        <span class="badge bg-primary rounded-pill">{{ $feedbacks->total() }}</span>
        <small class="text-muted ms-2">
            <i class="bi bi-info-circle me-1"></i>Click vào dòng để xem chi tiết
        </small>
    </div>
</div>

{{-- Hiển thị alert nếu có --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close pb-1" data-bs-dismiss="alert" style="font-size: 0.7rem;"></button>
    </div>
@endif

{{-- Bộ lọc --}}
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('feedbacks.index') }}" id="filterForm" class="row g-3 align-items-end">

            <div class="col-md-4">
                <label class="form-label fw-semibold">Tìm nội dung</label>
                <input type="text" name="search" placeholder="Tìm kiếm..." 
                       class="form-control" value="{{ request('search') }}" 
                       oninput="document.getElementById('filterForm').submit()">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Rating</label>
                <select name="rating" class="form-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Tất cả</option>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                            {{ str_repeat('★', $i) . str_repeat('☆', 5 - $i) }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Từ ngày</label>
                <input type="date" name="date_from" class="form-control" 
                       value="{{ request('date_from') }}" 
                       onchange="document.getElementById('filterForm').submit()">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Đến ngày</label>
                <input type="date" name="date_to" class="form-control" 
                       value="{{ request('date_to') }}" 
                       onchange="document.getElementById('filterForm').submit()">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <a href="{{ route('feedbacks.index') }}" class="btn btn-secondary w-100">
                    Reset
                </a>
            </div>

        </form>
    </div>
</div>


{{-- Bảng feedback --}}
<div class="table-responsive shadow-sm rounded">
    <table class="table table-bordered table-hover align-middle mb-0">
        <thead class="table-light text-center">
            <tr>
                <th>#</th>
                <th>Người dùng</th>
                <th>Rating</th>
                <th>Nội dung</th>
                <th>Ngày gửi</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
        @forelse($feedbacks as $index => $feedback)
            <tr onclick="window.location='{{ route('feedbacks.show', $feedback->id) }}'">
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $feedback->account->username ?? 'Không có user' }}</td>
                <td class="text-center text-warning">
                    {!! str_repeat('★', $feedback->rating) . str_repeat('☆', 5 - $feedback->rating) !!}
                </td>
                <td>{{ Str::limit($feedback->comment, 50) }}</td>
                <td class="text-center">{{ $feedback->created_at->format('d/m/Y H:i') }}</td>

                <td class="text-center">
                    @if($feedback->status == 'pending')
                    <form action="{{ route('feedbacks.updateStatus', $feedback->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        <button class="btn btn-sm btn-success">✓</button>
                    </form>
                    @endif
                    <form action="{{ route('feedbacks.destroy', $feedback->id) }}" method="GET" class="d-inline-block" onsubmit="return confirm('Xác nhận xóa?')">
                        @csrf @method('GET')
                        <button class="btn btn-sm btn-danger">🗑️</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted">Không có phản hồi nào</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-3">
    {{ $feedbacks->links() }}
</div>

{{-- Script: ngăn click vào nút bị redirect dòng --}}
<script>
    document.querySelectorAll('table tbody tr td:last-child *').forEach(element => {
        element.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
</script>

@endsection
