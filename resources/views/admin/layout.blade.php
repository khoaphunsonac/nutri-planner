<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- bootstrap, icons, font chữ -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Noto+Sans&display=swap" rel="stylesheet">

  {{-- css --}}
  <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">

  <title>Fitfood Admin</title>
</head>
<body>
  <!-- navbar -->
<nav class="navbar navbar-expand-lg shadow-sm bg-dash px-3 py-2">
  <div class="container-fluid d-flex justify-content-between">
    <button class="btn btn-outline-light d-lg-none" onclick="toggleSidebar()">☰</button>
    <a class="navbar-brand text-light" href="#">Fitfood Admin</a>
    <a href="" class="me-4">
        {{-- sau logout --}}
      <img src="{{ asset('img/avatar/default.jpg') }}" alt="admin" width="30" class="d-block rounded-circle">
    </a>
  </div>
</nav>

<!-- gọi hàm overlay để hiện khi co nhỏ -->
<div class="overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- side3 -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-header p-3">
    <h5 class="m-0">🍴 Fitfood</h5>
    <small>Fitfood Panel</small>
  </div>
  <a href="/admin/dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a>
  <a href="/admin/meals"><i class="bi bi-egg-fried"></i> Meals</a>
  <a href="/admin/ingredients"><i class="bi bi-basket"></i> Ingredients</a>
  <a href="/admin/users"><i class="bi bi-people"></i> Users</a>
  <a href="/admin/contacts"><i class="bi bi-envelope"></i> Contacts</a>
  <a href="/admin/feedbacks"><i class="bi bi-chat-dots"></i> Feedbacks</a>
</aside>

  {{-- nội dung từ file dashboard --}}
  @yield('content')


<!-- sidebar -->
<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    sidebar.classList.toggle('show');
    overlay.classList.toggle('show');
  }
</script>
</body>
</html>


{{-- thay đổi --}}