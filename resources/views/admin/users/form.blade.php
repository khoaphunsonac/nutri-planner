@extends('admin.layout')

@section('content')
    <form action="" method="post">
        @csrf
        <div>
            <label for="username">Tên đăng nhập</label>
            <input type="text" id="username" name="username">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>
        {{-- tạm thời tính chỉ cho admin thấy role này vì là quản trị
        còn người dùng thì luôn mặc định là user --}}
        <div>
            <div>
                <label for="user">User</label>
                <input type="radio" name="user" id="user">
            </div>
            <div>
                <label for="admin">Admin</label>
                <input type="radio" name="admin" id="admin">
            </div>
        </div>
        <button type="submit">{{ $btn }}</button>
    </form>
@endsection