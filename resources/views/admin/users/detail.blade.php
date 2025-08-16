@extends('admin.layout')
{{-- trường hợp muốn dữ tk đó lại nhưng lại muốn khoá ((: --}}
@section('content')

<div class="container mt-4" style="max-width: 600px;">
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

    <div class="bg-white p-4 rounded shadow">
        <h4 class="mb-4 text-primary fw-bold">
            <i class="bi bi-person-badge-fill me-2"></i>Chi tiết thông tin người dùng
        </h4>

        <form action="{{ route($shareUser . 'save', $id) }}" method="post">
            @csrf

            {{-- Username --}}
            <div class="mb-3">
                <label class="form-label">Tên đăng nhập</label>
                <input type="text" value="{{ $item->username }}" disabled class="form-control bg-light">
                <input type="hidden" name="username" value="{{ $item->username }}">
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" value="{{ $item->email }}" disabled class="form-control bg-light">
                <input type="hidden" name="email" value="{{ $item->email }}">
            </div>

            {{-- Password (ẩn) --}}
            <input type="hidden" name="password" value="{{ $item->password }}">

            {{-- Role --}}
            <div class="mb-3">
                <label class="form-label">Vai trò</label>
                <input type="text" value="{{ ucfirst($item->role) }}" disabled class="form-control bg-light">
                <input type="hidden" name="role" value="{{ $item->role }}">
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label class="form-label d-block">
                    Trạng thái tài khoản:
                    <strong id="statusText" class="px-2 py-1 fs-6 {{ $item->status === 'active' ? 'text-success' : 'text-danger' }}">
                        {{ $item->status === 'active' ? 'Hoạt động' : 'Đã khoá' }}
                    </strong>
                </label>
                <input type="hidden" name="status" id="statusInput" value="{{ $item->status }}">
            </div>

            {{-- tog button --}}
            <div class="mb-4">
                <button type="button" class="btn {{ $item->status === 'active' ? 'btn-outline-danger' : 'btn-outline-success' }}" onclick="toggleStatus()" >
                    {{ $item->status === 'active' ? 'Khoá tài khoản' : 'Mở tài khoản' }}
                </button>
            </div>

            {{-- lý do bị khoá --}}
           <div class="mb-3" id="noteField">
                <label for="note" class="form-label">Nhập lý do bị khoá nếu có</label>
                <textarea id="note" name="note" class="form-control" rows="3" placeholder="Nhập lý do khoá...">{{ $item->note ?? old('note') }}</textarea>
            @error('note')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary w-100">
                {{ $btn }}
            </button>
        </form>
        <div class="text-center">
            <a href="{{ route($shareUser.'index') }}" class="btn btn-secondary mt-3 rounded-pill">
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
        const noteField = document.getElementById('noteField'); // div chứa textarea

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
        if(input.value === 'active'){
            noteField.style.display = 'none';
        } else {
            noteField.style.display = 'block';
        }
    });
</script>

@endsection
