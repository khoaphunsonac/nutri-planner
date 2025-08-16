@extends('site.layout')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center" 
     style="min-height: 100vh; background-color: rgb(255, 253, 244);">

    {{-- Form --}}
    <div class="card shadow-lg border-0" style="width: 420px; border-radius: 10px; background-color: #fdfdfd;">
        <div class="card-body p-4">
            <h3 class="text-center mb-4" style="font-weight: 700; color: #ed4e3c;">
                Đăng ký tài khoản
            </h3>

            <form action="{{ route('register.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label fw-bold" style="color:#ef6c00 ;">Tên đăng ký</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" 
                           class="form-control border-0 shadow-sm" 
                           style="border-radius: 10px;"
                           placeholder="Nhập tên đăng ký">
                    @error('username')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold" style="color: #ef6c00;">Email</label>
                    <input type="text" id="email" name="email" value="{{ old('email') }}" 
                           class="form-control border-0 shadow-sm" 
                           style="border-radius: 10px;"
                           placeholder="Nhập email">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-bold" style="color: #ef6c00;">Mật khẩu</label>
                    <input type="password" id="password" name="password" value="{{ old('password') }}" 
                           class="form-control border-0 shadow-sm" 
                           style="border-radius: 10px;"
                           placeholder="Nhập mật khẩu">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
<<<<<<< HEAD
            
=======

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label fw-bold" style="color: #ef6c00;">Nhập lại mật khẩu</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-control border-0 shadow-sm" 
                        style="border-radius: 10px;"
                        placeholder="Nhập lại mật khẩu">
                    @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


>>>>>>> bd505a3daf6d0fa5cb74af9e9981d0c3606c106c
                <button type="submit" 
                        class="btn w-100 shadow-sm"
                        style="background-color: #ed4e3c; 
                               color: white; 
                               font-weight: 600; 
                               border-radius: 10px; 
                               padding: 10px; 
                               border: none;
                               transition: all 0.3s ease;">
                    Đăng ký
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Hiệu ứng hover nút --}}
<style>
    button.btn:hover {
        background-color: #f4511e !important;
        transform: translateY(-2px);
        box-shadow: 0px 4px 10px rgba(244, 81, 30, 0.4);
    }
</style>
@endsection
