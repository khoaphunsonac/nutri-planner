<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách liên hệ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4">Danh sách liên hệ</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
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
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($item->message, 50) }}</td>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('contact.show', $item->id) }}" class="btn btn-sm btn-info">Chi tiết</a>
                            <a href="{{ route('contact.delete', $item->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xoá?')">Xoá</a>
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

    @if(isset($selectedItem))
        <hr>
        <div class="card mt-4">
            <div class="card-header bg-info text-white">
                <strong>Chi tiết liên hệ</strong>
            </div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $selectedItem->id }}</p>
                <p><strong>Họ tên:</strong> {{ $selectedItem->name }}</p>
                <p><strong>Email:</strong> {{ $selectedItem->email }}</p>
                <p><strong>Nội dung:</strong></p>
                <div class="border rounded p-3 bg-light">{{ $selectedItem->message }}</div>
                <p class="mt-3"><strong>Thời gian gửi:</strong> {{ $selectedItem->created_at->format('d/m/Y H:i') }}</p>
                <a href="{{ route('contact.index') }}" class="btn btn-secondary mt-3">Ẩn chi tiết</a>
            </div>
        </div>
    @endif

    <!-- Địa chỉ trung tâm và bản đồ -->
    <hr>
    <div class="mt-5">
        <h5>Địa chỉ trung tâm</h5>
        <p><strong>Email:</strong> support@yourcenter.com</p>

        <!-- Hiển thị địa chỉ và nút sửa -->
        <p id="addressDisplay">
            <span id="currentAddress">778/10 Đ. Nguyễn Kiệm, Phường 3, Phú Nhuận, Hồ Chí Minh 700990, Vietnam</span>
            <button class="btn btn-sm btn-warning ms-2" onclick="enableEdit()">Sửa</button>
        </p>

        <!-- Chỉnh sửa địa chỉ -->
        <div id="addressEdit" class="d-none">
            <input type="text" id="mapAddress" class="form-control"
                   value="778/10 Đ. Nguyễn Kiệm, Phường 3, Phú Nhuận, Hồ Chí Minh 700990, Vietnam" />
            <button class="btn btn-sm btn-success mt-2" onclick="updateMap()">Cập nhật</button>
        </div>

        <div class="ratio ratio-16x9 mt-3">
            <iframe id="mapFrame"
                    src="https://www.google.com/maps?q=778/10 Đ. Nguyễn Kiệm, Phường 3, Phú Nhuận, Hồ Chí Minh 700990, Vietnam&output=embed"
                    width="600" height="450" style="border:0;" allowfullscreen=""
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</div>

<!-- Script xử lý cập nhật bản đồ -->
<script>
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

        // Cập nhật iframe
        mapFrame.src = newMapSrc;

        // Cập nhật hiển thị địa chỉ
        currentAddress.textContent = newAddress;

        // Ẩn form chỉnh sửa
        addressEdit.classList.add('d-none');
        addressDisplay.classList.remove('d-none');
    }
</script>

</body>
</html>
