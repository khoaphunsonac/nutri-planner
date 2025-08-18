@extends('site.layout')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center" 
     style="min-height: 100vh; background-color: #fffcf4;">

    {{-- Form --}}
    <div class="card shadow border-0" 
         style="width: 420px; border-radius: 15px; background-color: #ffffff;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h3 class="mt-3 fw-bold" style="color: #f8a13c;">
                    Quên Mật Khẩu
                </h3>
                <p class="text-muted">Nhập email để nhận link đặt lại mật khẩu</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success border-0 shadow-sm" 
                     style="border-radius: 12px; background-color: #d4edda; color: #155724;">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold" style="color: #f57c00;">
                        <i class="bi bi-envelope-fill me-2"></i>Email
                    </label>
                    <input type="text" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="form-control shadow-sm @error('email') is-invalid @enderror" 
                           style="border-radius: 12px; border: 2px solid #ffe0b2; padding: 12px 16px;"
                           placeholder="Nhập địa chỉ email của bạn"
                           required>
                    @error('email') 
                        <div class="invalid-feedback fw-bold">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" 
                        class="btn w-100 fw-bold shadow-sm mb-3"
                        style="background-color: #f8a13c; 
                               color: white; 
                               border-radius: 50px; 
                               padding: 12px; 
                               font-size: 16px; 
                               transition: all 0.3s ease;
                               border: none;">
                    {{-- <i class="bi bi-send-fill me-2"></i> --}}
                    Gửi Link Đặt Lại
                </button>

                <div class="text-center">
                    <a href="{{ route('login') }}" 
                       class="text-decoration-none fw-bold"
                       style="color: #f57c00;">
                        <i class="bi bi-arrow-left me-2"></i>
                        Quay lại đăng nhập
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Hiệu ứng hover --}}
<style>
    button.btn:hover {
        background-color: #f57c00 !important;
        transform: translateY(-2px);
        box-shadow: 0px 4px 12px rgba(245, 124, 0, 0.4);
    }

    .form-control:focus {
        border-color: #f8a13c !important;
        box-shadow: 0 0 0 0.2rem rgba(248, 161, 60, 0.25) !important;
    }

    a:hover {
        color: #e65100 !important;
        text-decoration: underline !important;
    }
</style>
@endsection