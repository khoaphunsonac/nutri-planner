@extends('site.layout')

@section('title', 'Liên hệ') {{-- nếu layout có @yield("title") --}}

@section('content')
<div class="container py-4">

    {{-- Breadcrumb (tuỳ chọn) --}}
    {{-- <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
        </ol>
    </nav> --}}

    <h2 class="mb-3">Liên hệ với chúng tôi</h2>

    {{-- Flash thành công --}}
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    {{-- Lỗi validate --}}
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contact.store') }}" method="POST" novalidate>
        @csrf

        <div class="mb-3">
            <label for="contact-name" class="form-label">Họ tên</label>
            <input
                id="contact-name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Nguyễn Văn A">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="contact-email" class="form-label">Email</label>
            <input
                id="contact-email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="email@domain.com">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="contact-message" class="form-label">Nội dung</label>
            <textarea
                id="contact-message"
                name="message"
                rows="4"
                class="form-control @error('message') is-invalid @enderror"
                placeholder="Bạn muốn trao đổi điều gì?">{{ old('message') }}</textarea>
            @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Gửi</button>
    </form>
</div>
@endsection
