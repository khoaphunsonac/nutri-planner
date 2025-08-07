@extends('admin.layout')
@section('content')
    <div class="container mt-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb breadcrumb-compact">
                <li class="breadcrumb-item">
                    <a href="#"><i class="bi bi-house-door"></i></a>
                </li>
                <li class="breadcrumb-item active">
                    <i class="bi bi-envelope-at me-1"></i>Liên hệ
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <h4 class="mb-0 me-3">Quản lý liên hệ</h4>
                <small class="text-muted ms-2">
                    <i class="bi bi-info-circle me-1"></i>
                    Chọn một liên hệ để xem chi tiết
                </small>
            </div>
        </div>

        <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close pb-1" data-bs-dismiss="alert" style="font-size: 0.7rem;"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first() }}
                <button type="button" class="btn-close pb-1" data-bs-dismiss="alert" style="font-size: 0.7rem;"></button>
            </div>
        @endif

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Nội dung</th>
                        <th>Thời gian gửi</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr onclick="window.location='{{ route('contact.show', $item->id) }}'" style="cursor: pointer;">
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($item->message, 50) }}</td>
                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('contact.show', $item->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Chi tiết
                                </a>
                                <a href="{{ route('contact.delete', $item->id) }}" class="btn btn-sm btn-danger"
                                   onclick="return confirm('Xác nhận xoá?')">
                                    <i class="bi bi-trash"></i> Xoá
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Không có liên hệ nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Địa chỉ trung tâm và bản đồ -->
        <hr>
        <div class="mt-5">
            <h5><i class="bi bi-geo-alt-fill me-1"></i>Địa chỉ trung tâm</h5>

            <!-- Email -->
            <p id="emailDisplay">
                <strong>Email:</strong>
                <span id="currentEmail">support@yourcenter.com</span>
                <button class="btn btn-sm btn-warning ms-2" onclick="enableEmailEdit()">
                    <i class="bi bi-pencil"></i> Sửa
                </button>
            </p>

            <div id="emailEdit" class="d-none">
                <input type="email" id="emailInput" class="form-control w-auto d-inline-block" style="width: 300px;"
                       value="support@yourcenter.com" />
                <button class="btn btn-sm btn-success ms-2" onclick="saveEmail()">
                    <i class="bi bi-check-lg"></i> Lưu
                </button>
            </div>

            <!-- Địa chỉ -->
            <p id="addressDisplay">
                <span id="currentAddress">778/10 Đ. Nguyễn Kiệm, Phường 3, Phú Nhuận, Hồ Chí Minh 700990, Vietnam</span>
                <button class="btn btn-sm btn-warning ms-2" onclick="enableEdit()">
                    <i class="bi bi-pencil"></i> Sửa
                </button>
            </p>

            <div id="addressEdit" class="d-none">
                <input type="text" id="mapAddress" class="form-control"
                       value="778/10 Đ. Nguyễn Kiệm, Phường 3, Phú Nhuận, Hồ Chí Minh 700990, Vietnam" />
                <button class="btn btn-sm btn-success mt-2" onclick="updateMap()">
                    <i class="bi bi-check-lg"></i> Cập nhật
                </button>
            </div>

            <!-- Bản đồ -->
            <div class="ratio ratio-16x9 mt-3 shadow-sm">
                <iframe id="mapFrame"
                        src="https://www.google.com/maps?q=778/10 Đ. Nguyễn Kiệm, Phường 3, Phú Nhuận, Hồ Chí Minh 700990, Vietnam&output=embed"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>

    <!-- Script xử lý -->
    <script>
        // Địa chỉ
        const addressDisplay = document.getElementById('addressDisplay');
        const addressEdit = document.getElementById('addressEdit');
        const mapAddress = document.getElementById('mapAddress');
        const mapFrame = document.getElementById('mapFrame');
        const currentAddress = document.getElementById('currentAddress');

        function enableEdit() {
            addressDisplay.classList.add('d-none');
            addressEdit.classList.remove('d-none');
            mapAddress.focus();
        }

        function updateMap() {
            const newAddress = mapAddress.value.trim();
            if (newAddress === '') return;

            const encodedAddress = encodeURIComponent(newAddress);
            const newMapSrc = `https://www.google.com/maps?q=${encodedAddress}&output=embed`;

            mapFrame.src = newMapSrc;
            currentAddress.textContent = newAddress;
            addressEdit.classList.add('d-none');
            addressDisplay.classList.remove('d-none');
        }

        // Email
        const emailDisplay = document.getElementById('emailDisplay');
        const emailEdit = document.getElementById('emailEdit');
        const emailInput = document.getElementById('emailInput');
        const currentEmail = document.getElementById('currentEmail');

        function enableEmailEdit() {
            emailDisplay.classList.add('d-none');
            emailEdit.classList.remove('d-none');
            emailInput.focus();
        }

        function saveEmail() {
            const newEmail = emailInput.value.trim();
            if (newEmail === '') return;

            currentEmail.textContent = newEmail;
            emailEdit.classList.add('d-none');
            emailDisplay.classList.remove('d-none');
        }
    </script>
@endsection
