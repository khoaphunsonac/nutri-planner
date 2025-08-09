    @extends('Admin.layout')

    @section('content')
    <div class="container">
        <h3 class="mb-4">Chi tiết phản hồi</h3>

        <div class="card">
            <div class="card-body">
                <p><strong>Người dùng:</strong> {{ $feedback->account->username ?? 'Khách' }}</p>
                <p><strong>Email:</strong> {{ $feedback->account->email ?? 'Không có' }}</p>
                <p><strong>Đánh giá:</strong> {!! str_repeat('★', $feedback->rating) . str_repeat('☆', 5 - $feedback->rating) !!}</p>
                <p><strong>Nội dung:</strong></p>
                <div class="border p-3 bg-light">{{ $feedback->comment }}</div>
                <p class="mt-3"><strong>Ngày gửi:</strong> {{ $feedback->created_at->format('d/m/Y H:i') }}</p>
               
                @if($feedback->status == 'pending')
                <form action="{{ route('feedbacks.updateStatus', $feedback->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-success">Đánh dấu là đã xử lý</button>
                </form>
                @endif

                <a href="{{ route('feedbacks.index') }}" class="btn btn-secondary mt-3">← Quay lại</a>
            </div>
        </div>
    </div>
    @endsection
