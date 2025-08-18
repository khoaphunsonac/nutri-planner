@extends('admin.layout')


@section('content')

<style>
    .preview-box {
    border: 2px solid #ddd;
    border-radius: 10px;
    padding: 10px;
    transition: all 0.3s ease;
    background-color: #ebfcff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

.preview-box:hover {
    border-color: #006de1; /* xanh nổi bật */
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transform: translateY(-3px);
}

.preview-box .list-group-item {
    border: none; /* bỏ viền item gốc */
    padding: 8px 0;
}

</style>

<div class="container-fluid mt-1">
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

    <div class="bg-white p-5 rounded shadow w-100">
        <h4 class="mb-4 text-primary fw-bold">
            <i class="bi bi-person-badge-fill me-2"></i>Chi tiết thông tin người dùng
        </h4>

        <form action="{{ route($shareUser . 'save', $id) }}" method="post">
            @csrf

            <div class="row g-3">
                {{-- Username --}}
                <div class="col-md-6">
                    <label class="form-label">Tên đăng nhập</label>
                    <input type="text" value="{{ $item->username }}" disabled class="form-control bg-light">
                    <input type="hidden" name="username" value="{{ $item->username }}">
                </div>

                {{-- Email --}}
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" value="{{ $item->email }}" disabled class="form-control bg-light">
                    <input type="hidden" name="email" value="{{ $item->email }}">
                </div>

                {{-- Password (ẩn) --}}
                {{-- <input type="hidden" name="password" value="{{ $item->password }}"> --}}

                {{-- Role --}}
                <div class="col-md-6">
                    <label class="form-label">Vai trò</label>
                    <input type="text" value="{{ ucfirst($item->role) }}" disabled class="form-control bg-light">
                    <input type="hidden" name="role" value="{{ $item->role }}">
                </div>

                {{-- Status --}}
                <div class="col-md-2 d-flex flex-column justify-content-start">
                    <label class="form-label mb-2">Trạng thái tài khoản</label>
                    <span id="statusText" class="badge fs-6 
                        {{ $item->status === 'active' ? 'bg-success text-white' : 'bg-danger text-white' }}
                        py-2 px-3"
                        style="font-weight: 500; border-radius: 0.5rem;">
                        {{ $item->status === 'active' ? 'Hoạt động' : 'Đã khoá' }}
                    </span>
                    <input type="hidden" name="status" id="statusInput" value="{{ $item->status }}">
                </div>

                {{-- Món yêu thích --}}
                <div class="col-12">
                    @php
                        $preview = $item->savemeal_preview;
                        $total = $item->savemeal_total;
                    @endphp
                    <label class="form-label">Món yêu thích <span style="color: rgb(255, 88, 28)">(Tổng: {{ $total }})</span></label>

                    @if ($total > 0)
                        <a href="{{ route('users.detail', ['id' => $id]) }}" class="text-decoration-none">
                            <div class="list-group preview-box">
                                @foreach ($preview as $meal)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ $meal->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </a>

                        @else
                            <p class="text-muted fst-italic">Không có món yêu thích</p>
                        @endif
                    </div>

                {{-- Toggle button --}}
                <div class="col-md-6">
                    <button type="button" class="btn {{ $item->status === 'active' ? 'btn-outline-danger' : 'btn-outline-success' }}" onclick="toggleStatus()">
                        {{ $item->status === 'active' ? 'Khoá tài khoản' : 'Mở tài khoản' }}
                    </button>
                </div>

                {{-- Lý do bị khoá --}}
                <div class="col-md-6" id="noteField">
                    <label for="note" class="form-label">Nhập lý do bị khoá nếu có</label>
                    <textarea id="note" name="note" class="form-control" rows="3" placeholder="Nhập lý do khoá...">{{ $item->note ?? old('note') }}</textarea>
                    @error('note')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary w-100 mt-4">
                {{ $btn }}
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route($shareUser.'index') }}" class="btn btn-secondary rounded-pill">
                <i class="bi bi-arrow-left-circle me-1"></i> Quay lại
            </a>
        </div>
    </div>
</div>

<script>
function toggleStatus() {
    const input = document.getElementById('statusInput');
    const text = document.getElementById('statusText');
    const btn = event.target;
    const noteField = document.getElementById('noteField');

    if (input.value === 'active') {
        input.value = 'inactive';
        text.textContent = 'Đã khoá';
        text.className = 'px-2 py-1 fs-6 text-danger';
        btn.textContent = 'Mở tài khoản';
        btn.className = 'btn btn-outline-success';
        noteField.style.display = 'block';
    } else {
        input.value = 'active';
        text.textContent = 'Hoạt động';
        text.className = 'px-2 py-1 fs-6 text-success';
        btn.textContent = 'Khoá tài khoản';
        btn.className = 'btn btn-outline-danger';
        noteField.style.display = 'none';
    }
}

// Ẩn/hiện textarea theo trạng thái lúc load trang
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('statusInput');
    const noteField = document.getElementById('noteField');
    noteField.style.display = input.value === 'active' ? 'none' : 'block';
});
</script>

@endsection
