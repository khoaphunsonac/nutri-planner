@extends('admin.layout')

@section('content')
    <form action="" method="post">
        @csrf
            <div>
                <label for="username">Tên đăng nhập</label>
                <input type="text" id="username" value="{{ $item->username ?? old($item->username) }}" name="username">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" value="{{ $item->email ?? old($item->email) }}" id="email">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
            </div>
            {{-- tạm thời tính chỉ cho admin thấy role này vì là quản trị
            còn người dùng thì luôn mặc định là user --}}
            <div>
                <div>
                    <label>Vai trò</label>
                    <label><input type="radio" name="role" value="user" {{ isset($item) && $item->role === 'user' ? 'checked' : '' }}>User</label>
                    <label><input type="radio" name="role" value="admin" {{ isset($item) && $item->role === 'admin' ? 'checked' : '' }}>Admin</label>
                </div>
            {{-- thêm 1 form cho khoá tài khoản --}}
            {{-- Chỗ hiển thị trạng thái tài khoản --}}
            @if(!empty($item))          
                <p>Trạng thái: <strong>{{ $item->status === 'active' ? 'Đang hoạt động' : 'Đã khoá' }}</strong></p>

                {{-- FORM KHÓA/MỞ --}}

                <form action="{{ route($shareUser.'status') }}" method="POST" style="margin-top: 10px;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <button type="submit">
            {{ $item->status === 'active' ? 'Khoá tài khoản' : 'Mở tài khoản' }}
                    </button>
                </form>
            @endif
       </div>
        <button type="submit">{{ $btn }}</button>
    </form>
@endsection