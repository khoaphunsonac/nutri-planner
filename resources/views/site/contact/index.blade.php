@extends('site.layout')

@section('title','Liên hệ')

@push('styles')
<style>
  /* Hero & nền nhẹ */
  .contact-hero{
    background:
      radial-gradient(1000px 400px at 10% 0%, rgba(13,110,253,.12), transparent),
      radial-gradient(800px 300px at 90% 10%, rgba(111,66,193,.12), transparent);
    border-radius: 1.25rem;
  }
  .card-glass{
    backdrop-filter: blur(6px);
    background: rgba(255,255,255,.92);
    border: 1px solid rgba(0,0,0,.06);
    border-radius: 1rem;
    box-shadow: 0 10px 24px rgba(0,0,0,.06);
  }
  .form-control:focus,.form-select:focus{
    box-shadow: 0 0 0 .25rem rgba(13,110,253,.15);
    border-color: rgba(13,110,253,.45);
  }
  .contact-label{font-weight:600;}
  .tiny-muted{font-size:.875rem;color:#6c757d;}
  .btn-rounded{border-radius:.75rem;}
</style>
@endpush

@section('content')
<div class="container-fluid py-5" style="height: 100vh">

  {{-- Hero --}}
  <div class="contact-hero p-4 p-md-5 mb-4">
    <div class="d-flex align-items-center gap-3">
      <div class="rounded-circle d-flex align-items-center justify-content-center"
           style="width:56px;height:56px;background:#0d6efd1a;">
        <i class="bi bi-chat-dots fs-3 text-primary"></i>
      </div>
      <div>
        <h1 class="h3 mb-1">Liên hệ với chúng tôi</h1>
        <p class="mb-0 tiny-muted">Gửi thắc mắc, góp ý hoặc hợp tác — chúng tôi sẽ phản hồi sớm nhất có thể.</p>
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
      <div class="card card-glass border-0">
        <div class="card-body p-4 p-md-5">

          {{-- giữ nguyên logic: route + fields + csrf --}}
          <form action="{{ route('contacts.store') }}" method="POST" id="contactForm" novalidate>
            @csrf

            {{-- Họ tên --}}
            <div class="mb-3">
              <label for="contact-name" class="form-label contact-label">Họ tên</label>
              <input
                id="contact-name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Nguyễn Văn A"
                autocomplete="name">
              <div class="tiny-muted mt-1">Nhập họ và tên của bạn.</div>
              @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
              <label for="contact-email" class="form-label contact-label">Email</label>
              <input
                id="contact-email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="email@domain.com"
                inputmode="email"
                autocomplete="email">
              <div class="tiny-muted mt-1">Chúng tôi sẽ phản hồi qua địa chỉ này.</div>
              @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Nội dung --}}
            <div class="mb-3">
              <label for="contact-message" class="form-label contact-label">Nội dung</label>
              <textarea
                id="contact-message"
                name="message"
                rows="6"
                maxlength="1000"
                class="form-control @error('message') is-invalid @enderror"
                placeholder="Bạn muốn trao đổi điều gì?">{{ old('message') }}</textarea>
              @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
              <div class="d-flex justify-content-end mt-1 tiny-muted">
                <span id="message-counter">0</span>/1000
              </div>
            </div>

            {{-- Buttons --}}
            <div class="d-grid d-sm-flex gap-2 mt-4">
              <button type="submit" class="btn btn-primary btn-rounded" id="submitBtn">
                <i class="bi bi-send me-2"></i>Gửi
              </button>
              <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-rounded">Hủy</a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  (function(){
    // đếm ký tự
    const ta=document.getElementById('contact-message');
    const counter=document.getElementById('message-counter');
    if(ta&&counter){
      const update=()=>counter.textContent=ta.value.length;
      ta.addEventListener('input',update); update();
    }
    // chống submit 2 lần
    const form=document.getElementById('contactForm');
    const btn=document.getElementById('submitBtn');
    if(form&&btn){
      form.addEventListener('submit',function(){
        btn.disabled=true;
        btn.innerHTML='<span class="spinner-border spinner-border-sm me-2"></span>Đang gửi...';
      });
    }
  })();
</script>
@endpush
@endsection
