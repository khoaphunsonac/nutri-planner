@extends('site.layout')


{{-- Optional: style nhẹ nhàng cho trang liên hệ --}}

<style>
    .contact-hero {
        background: radial-gradient(1000px 400px at 10% 0%, rgba(13,110,253,.12), transparent),
                    radial-gradient(800px 300px at 90% 10%, rgba(111,66,193,.12), transparent);
        border-radius: 1.25rem;
    }
    .card-glass {
        backdrop-filter: blur(6px);
        background: rgba(255,255,255,.85);
        border: 1px solid rgba(0,0,0,.05);
    }
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 .25rem rgba(13,110,253,.15);
        border-color: rgba(13,110,253,.45);
    }
    .contact-label {
        font-weight: 600;
    }
    .tiny-muted {
        font-size: .85rem;
        color: #6c757d;
    }
</style>

@section('content')
<div class="container-fluid py-5">

    {{-- Hero --}}
    <div class="contacts-hero p-4 p-md-5 mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center"
                 style="width:56px;height:56px;background:#0d6efd1a;">
                <i class="bi bi-chat-dots fs-3 text-primary"></i>
            </div>
            <div>
                <h1 class="h3 mb-1">Liên hệ với chúng tôi</h1>
                <p class="mb-0 tiny-muted">Gửi thắc mắc, góp ý hoặc hợp tác – chúng tôi sẽ phản hồi sớm nhất có thể.</p>
            </div>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>Vui lòng kiểm tra lại thông tin:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-glass shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">

                    <form action="{{ route('site.store') }}" method="POST" novalidate>
                        @csrf

                        {{-- Họ tên --}}
                        <div class="mb-3">
                            <label for="contact-name" class="form-label contact-label">Họ tên</label>
                            <div class="input-group">
                                <input
                                    id="contact-name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Nguyễn Văn A"
                                    autocomplete="name">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="tiny-muted mt-1">Nhập họ và tên của bạn</div>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="contact-email" class="form-label contact-label">Email</label>
                            <div class="input-group">
                                <input
                                    id="contact-email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="email@domain.com"
                                    inputmode="email"
                                    autocomplete="email">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="tiny-muted mt-1">Chúng tôi sẽ phản hồi qua địa chỉ này.</div>
                        </div>

                        {{-- Nội dung --}}
                        <div class="mb-3">
                            <label for="contact-message" class="form-label contact-label">Nội dung</label>
                            <div class="position-relative">
                                <textarea
                                    id="contact-message"
                                    name="message"
                                    rows="5"
                                    maxlength="1000"
                                    class="form-control @error('message') is-invalid @enderror"
                                    placeholder="Bạn muốn trao đổi điều gì?">{{ old('message') }}</textarea>
                                @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="tiny-muted mt-1 d-flex justify-content-end">
                                    <span id="message-counter">0</span>/1000
                                </div>
                            </div>
                        </div>

                        {{-- Nút gửi --}}
                        <div class="d-grid d-sm-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-send me-2"></i>Gửi
                            </button>
                           
                        </div>
                  </form>

                </div>
            </div>

            {{-- Info box nhỏ (tùy chọn) --}}
          
        </div>
    </div>
</div>
<script>
    (function () {
        const textarea = document.getElementById('contact-message');
        const counter = document.getElementById('message-counter');
        if (textarea && counter) {
            const update = () => { counter.textContent = textarea.value.length; };
            textarea.addEventListener('input', update);
            update();
        }
    })();
</script>

@endsection


