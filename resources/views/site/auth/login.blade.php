@extends('site.layout')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center" 
     style="min-height: 100vh; background-color: #fffcf4;">

    {{-- Form --}}
    <div class="card shadow border-0" 
         style="width: 420px; border-radius: 15px; background-color: #ffffff;">
        <div class="card-body p-4">
            <h3 class="text-center mb-4 fw-bold" style="color: #f8a13c;">
                Đăng Nhập
            </h3>

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="mb-3">  
                    <label for="username" class="form-label fw-bold" style="color:#f57c00;">Tên đăng ký</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" 
                           class="form-control shadow-sm" 
                           style="border-radius: 12px; border: 2px solid #ffe0b2;"
                           placeholder="Tên đăng nhập">
                    @error('username')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-bold" style="color: #f57c00;">Mật khẩu</label>
                    <input type="password" id="password" name="password" value="{{ old('password') }}" 
                           class="form-control shadow-sm" 
                           style="border-radius: 12px; border: 2px solid #ffe0b2;"
                           placeholder="Nhập mật khẩu">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <div><a href="{{ route('showRegister') }}" class="text-decoration-none text-secondary">Đăng ký</a></div>
                    <div><a href="" class="text-decoration-none text-danger">Quên mật khẩu</a></div>
                </div>

                <button type="submit" 
                        class="btn w-100 fw-bold shadow-sm"
                        style="background-color: #f8a13c; 
                               color: white; 
                               border-radius: 50px; 
                               padding: 10px; 
                               font-size: 16px; 
                               transition: all 0.3s ease;">
                    Đăng Nhập
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Hiệu ứng hover nút --}}
<style>
    button.btn:hover {
        background-color: #f57c00 !important;
        transform: translateY(-2px);
        box-shadow: 0px 4px 12px rgba(245, 124, 0, 0.4);
    }
</style>
@endsection
