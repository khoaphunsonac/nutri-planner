@extends('Admin.layout')

@section('content')
<style>
    :root {
        --main-color: #23272f;
        --secondary-color: #5a6473;
        --light-color: #f4f6fa;
        --favorite-color: #ff5a6e;
        --button-color: #1fa2ff;
        --button-color2: #12d8fa;
        --white: #fff;
        --shadow: 0 4px 24px 0 rgba(52,57,65,0.10);
        --radius: 16px;
        --rating-color: #ffc107;
    }
    body, .container {
        background: var(--light-color);
    }
    h2 {
        color: var(--main-color);
        letter-spacing: 1px;
        font-weight: 800;
        text-shadow: 0 2px 8px #0001;
    }
    .card {
        border: 1.5px solid var(--light-color);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        background: var(--white);
        transition: box-shadow 0.2s;
    }
    .card:hover {
        box-shadow: 0 8px 32px 0 rgba(31,162,255,0.10);
    }
    .card-body {
        border-radius: var(--radius);
        background: var(--white);
    }
    .form-label {
        color: var(--main-color);
        font-weight: 700;
    }
    .form-control, .form-select {
        border: 1.5px solid var(--secondary-color);
        color: var(--main-color);
        background: var(--white);
        border-radius: 10px;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-size: 1rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--button-color);
        box-shadow: 0 0 0 2px #1fa2ff33;
    }
    .btn-primary {
        background: var(--button-color);
        border: none;
        font-weight: 700;
        border-radius: 10px;
        transition: background 0.2s, box-shadow 0.2s;
        box-shadow: 0 2px 8px #1fa2ff22;
        color: #fff;
    }
    .btn-primary:hover {
        background: #138fd3;
        box-shadow: 0 4px 16px #1fa2ff33;
        color: #fff;
    }
    .btn-info {
        background: var(--secondary-color);
        border: none;
        color: var(--white);
        border-radius: 10px;
        font-weight: 600;
        transition: background 0.2s, box-shadow 0.2s;
    }
    .btn-info:hover {
        background: var(--main-color);
        color: var(--white);
        box-shadow: 0 2px 8px #34394122;
    }
    .btn-danger {
        background: var(--favorite-color);
        border: none;
        border-radius: 10px;
        color: #fff;
        font-weight: 600;
        transition: background 0.2s, box-shadow 0.2s;
    }
    .btn-danger:hover {
        background: #e83850cc;
        box-shadow: 0 2px 8px #e8385022;
    }
    .btn-success {
        background: var(--button-color2);
        border: none;
        border-radius: 10px;
        color: var(--white);
        font-weight: 600;
        transition: background 0.2s, box-shadow 0.2s;
    }
    .btn-success:hover {
        background: var(--button-color);
        box-shadow: 0 2px 8px #12d8fa22;
    }
    .table {
        background: var(--white);
        color: var(--main-color);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        font-size: 1rem;
    }
    .table thead {
        background: #e3f2fd;
        color: var(--main-color);
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .table th, .table td {
        vertical-align: middle !important;
        border-color: #e3e6ea;
        padding: 14px 10px;
    }
    .table-hover tbody tr:hover {
        background: #e3f2fd;
        transition: background 0.2s;
    }
    /* Feedback content highlight */
    .table td {
        transition: background 0.2s, color 0.2s;
    }
    .table tbody tr:hover td {
        background: #e3f2fd !important;
        color: var(--main-color);
    }
    .badge.bg-warning {
        background: var(--favorite-color) !important;
        color: #fff !important;
        font-weight: 600;
        border-radius: 8px;
        padding: 7px 14px;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px #e8385022;
    }
    .badge.bg-success {
        background: var(--button-color2) !important;
        color: #fff !important;
        font-weight: 600;
        border-radius: 8px;
        padding: 7px 14px;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px #1fa2ff22;
    }
    /* Rating stars */
    .text-warning {
        color: var(--rating-color) !important;
        font-size: 1.2em;
        letter-spacing: 1px;
        text-shadow: 0 1px 2px #0001;
    }
    /* Responsive tweaks */
    @media (max-width: 768px) {
        .card, .table, .card-body {
            border-radius: 10px;
        }
        .table th, .table td {
            font-size: 14px;
            padding: 8px;
        }
        h2 {
            font-size: 1.1rem;
        }
        .btn, .form-control, .form-select {
            font-size: 0.95rem;
        }
    }
    /* Thêm style cho hàng có thể click */
    .table tbody tr {
        cursor: pointer;
        transition: all 0.2s;
    }
    .table tbody tr:hover {
        background: #e3f2fd !important;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    /* Đảm bảo các nút hành động vẫn có thể click mà không kích hoạt sự kiện hàng */
    .table tbody tr td:last-child {
        cursor: default;
    }
    .table tbody tr td:last-child * {
        pointer-events: auto;
    }
</style>
<div class="container py-4">
    <h2 class="mb-4 fw-bold">Quản lý phản hồi người dùng</h2>

        {{-- Bộ lọc --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('feedbacks.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tìm nội dung</label>
                    <input type="text" name="search" placeholder="Tìm kiếm..." class="form-control" value="{{ request('search') }}">
                </div>
                
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Rating</label>
                    <select name="rating" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>★★★★★</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>★★★★☆</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>★★★☆☆</option>
                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>★★☆☆☆</option>
                        <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>★☆☆☆☆</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Ngày gửi</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                
                <div class="col-md-3 d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel-fill"></i> Lọc
                    </button>
                    <a href="{{ route('feedbacks.index') }}" class="btn btn-secondary mt-2">Reset</a>
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
</div>

<script>
    // Bổ sung để ngăn sự kiện click khi click vào các nút hành động
    document.querySelectorAll('table tbody tr td:last-child *').forEach(element => {
        element.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
</script>
@endsection
