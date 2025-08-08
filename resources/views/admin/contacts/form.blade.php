<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết liên hệ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4">Chi tiết liên hệ</h2>

    <div class="row mb-3">
        <div class="col-md-6">
            <label><strong>Họ tên:</strong></label>
            <p>{{ $contact->name }}</p>
        </div>
        <div class="col-md-6">
            <label><strong>Email:</strong></label>
            <p>{{ $contact->email }}</p>
        </div>
    </div>

    <div class="mb-3">
        <label><strong>Nội dung liên hệ:</strong></label>
        <div class="border rounded p-3 bg-light">
            {{ $contact->message }}
        </div>
    </div>

    <a href="{{ route('contact.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách</a>
</div>
</body>
</html>
