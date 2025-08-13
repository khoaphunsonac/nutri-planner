@extends('site.layout')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-4 p-4 bg-dark text-light form-wrapper">
        <h3 class="mb-4 text-center fw-bold text-primary-custom"> Gửi phản hồi của bạn</h3>

        <form method="POST" action="{{ route('feedbacks.store') }}">
            @csrf

            {{-- Thông báo lỗi tổng --}}
            @if ($errors->any())
                <div class="alert alert-danger rounded-3 shadow-sm p-3 mb-4" style="animation: fadeIn 0.5s;">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Đánh giá sao --}}
            <div class="mb-4 text-center">
                <label class="form-label fw-semibold fs-5 mb-2">Đánh giá</label>
                <div class="star-rating justify-content-center">
                    @for($i = 1; $i <= 5; $i++)
                        <span data-value="{{ $i }}">☆</span>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating" value="{{ old('rating') }}">
                @error('rating') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Nội dung --}}
            <div class="mb-4">
                <label class="form-label fw-semibold fs-5">Nội dung phản hồi</label>
                <textarea name="comment" rows="4" class="form-control rounded-3 shadow-sm bg-light text-dark" placeholder="Hãy chia sẻ cảm nhận của bạn..." required>{{ old('comment') }}</textarea>
                @error('comment') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Nút hành động --}}
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-main flex-grow-1">
                     Gửi phản hồi
                </button>
                <a href="/" class="btn btn-outline-cancel flex-grow-1">Hủy</a>
            </div>
        </form>
    </div>
</div>

{{-- CSS --}}
<style>
    body {
        background: #121212;
        font-family: 'Segoe UI', sans-serif;
    }

    .form-wrapper {
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(20px);}
        to {opacity: 1; transform: translateY(0);}
    }

    /* Tiêu đề */
    .text-primary-custom {
        color: #eb3131;
        letter-spacing: 1px;
    }

    /* Star rating */
    .star-rating {
        display: flex;
        gap: 10px;
        font-size: 2.5rem;
        color: #555;
        cursor: pointer;
        user-select: none;
    }
    .star-rating span {
        transition: transform 0.25s ease, color 0.25s ease;
    }
    .star-rating span:hover {
        transform: scale(1.25);
        color: #ffd700;
        text-shadow: 0 0 10px rgba(255,215,0,0.8);
    }

    /* Nút gửi */
    .btn-main {
        background-color: #eb3131;
        border: none;
        color: white;
        font-weight: bold;
        padding: 10px 0;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .btn-main:hover {
        background-color: #eb3131;
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 6px 20px rgba(255,75,43,0.4);
    }

    /* Nút hủy */
    .btn-outline-cancel {
        border: 2px solid #eb3131;
        color: #eb3131;
        font-weight: bold;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .btn-outline-cancel:hover {
        background: #eb3131;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(255,75,43,0.3);
    }

    /* Inputs & textarea */
    .form-control {
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #eb3131;
        box-shadow: 0 0 8px rgba(255,75,43,0.4);
    }
</style>

{{-- Script chọn sao --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star-rating span');
        const ratingInput = document.getElementById('rating');

        function highlightStars(rating) {
            stars.forEach((star, index) => {
                star.textContent = index < rating ? '★' : '☆';
                star.style.color = index < rating ? '#ffd700' : '#555';
            });
        }

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const rating = this.getAttribute('data-value');
                ratingInput.value = rating;
                highlightStars(rating);
            });

            star.addEventListener('mouseover', function () {
                highlightStars(this.getAttribute('data-value'));
            });

            star.addEventListener('mouseout', function () {
                highlightStars(ratingInput.value || 0);
            });
        });

        highlightStars(ratingInput.value || 0);
    });
</script>
@endsection
