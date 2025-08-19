@extends('site.layout')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center" 
     style="min-height: 100vh; background-color: #fffcf4;">

    {{-- Form --}}
    <div class="card shadow border-0" 
         style="width: 450px; border-radius: 15px; background-color: #ffffff;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <i class="bi bi-shield-lock-fill" style="font-size: 3rem; color: #f8a13c;"></i>
                <h3 class="mt-3 fw-bold" style="color: #f8a13c;">
                    Đặt Lại Mật Khẩu
                </h3>
                <p class="text-muted">Tạo mật khẩu mới cho tài khoản của bạn</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                {{-- Email Display --}}
                <div class="mb-3">
                    <label class="form-label fw-bold" style="color: #f57c00;">
                        <i class="bi bi-envelope-fill me-2"></i>Email
                    </label>
                    <input type="email" 
                           value="{{ $email }}" 
                           class="form-control shadow-sm" 
                           style="border-radius: 12px; border: 2px solid #ffe0b2; padding: 12px 16px; background-color: #f8f9fa;"
                           readonly>
                </div>

                {{-- New Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold" style="color: #f57c00;">
                        <i class="bi bi-lock-fill me-2"></i>Mật khẩu mới
                    </label>
                    <div class="input-group">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="form-control shadow-sm @error('password') is-invalid @enderror" 
                               style="border-radius: 12px 0 0 12px; border: 2px solid #ffe0b2; padding: 12px 16px;"
                               placeholder="Nhập mật khẩu mới"
                               required>
                        <button class="btn" 
                                type="button" 
                                style="background-color: #ffe0b2; border: 2px solid #ffe0b2; border-radius: 0 12px 12px 0;"
                                onclick="togglePassword('password')">
                            <i class="bi bi-eye-fill" id="password-toggle"></i>
                        </button>
                    </div>
                    @error('password') 
                        <div class="text-danger fw-bold mt-2">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-bold" style="color: #f57c00;">
                        <i class="bi bi-lock-fill me-2"></i>Xác nhận mật khẩu
                    </label>
                    <div class="input-group">
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="form-control shadow-sm" 
                               style="border-radius: 12px 0 0 12px; border: 2px solid #ffe0b2; padding: 12px 16px;"
                               placeholder="Nhập lại mật khẩu mới"
                               required>
                        <button class="btn" 
                                type="button" 
                                style="background-color: #ffe0b2; border: 2px solid #ffe0b2; border-radius: 0 12px 12px 0;"
                                onclick="togglePassword('password_confirmation')">
                            <i class="bi bi-eye-fill" id="password_confirmation-toggle"></i>
                        </button>
                    </div>
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
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Đặt Lại Mật Khẩu
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

{{-- JavaScript & Styles --}}
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

    .input-group-text:hover {
        background-color: #ffd54f !important;
        cursor: pointer;
    }
</style>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const toggle = document.getElementById(inputId + '-toggle');
    
    if (input.type === 'password') {
        input.type = 'text';
        toggle.className = 'bi bi-eye-slash-fill';
    } else {
        input.type = 'password';
        toggle.className = 'bi bi-eye-fill';
    }
}
</script>
@endsection