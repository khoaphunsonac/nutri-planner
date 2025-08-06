<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Fitfood Admin</title>

    <!-- Bootstrap, Icons, Font -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Noto+Sans&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/ingredients.css') }}">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm bg-dash px-3 py-2">
        <div class="container-fluid d-flex justify-content-between">
            <button class="btn btn-outline-light d-lg-none" onclick="toggleSidebar()">☰</button>
            <a class="navbar-brand text-light" href="#">Fitfood Admin</a>
            <a href="#" class="me-4">
                <img src="{{ asset('assets/admin/img/avatar/default.jpg') }}" alt="admin" width="30"
                    class="d-block rounded-circle">
            </a>
        </div>
    </nav>

    <!-- Overlay for mobile -->
    <div class="overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>


    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <a href="" class="text-decoration-none text-dark">
            <div class="sidebar-header p-3">
                <h5 class="m-0">🍴 Fitfood</h5>
                <small>Fitfood Panel</small>
            </div>
        </a>
        {{-- hiện vãn chưa có link được nha anh em test link bên anh em đi --}}
        <a href=""><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="{{ route('meals.index') }}"><i class="bi bi-egg-fried"></i> Meals</a>
        <a href="{{ route('ingredients.index') }}"><i class="bi bi-basket"></i> Ingredients</a>
        <a href=""><i class="bi bi-people"></i> Users</a>
        <a href="{{ route('tags.index') }}"><i class="bi bi-tags"></i> Tags</a>
        <a href=""><i class="bi bi-envelope"></i> Contacts</a>
        <a href=""><i class="bi bi-chat-dots"></i> Feedbacks</a>
        <a href=""><i class="bi bi-list-ul"></i> Diet Types</a>
        <a href=""><i class="bi bi-grid"></i> Meal Types</a>
    </aside>

    <!-- Main content mọi content kế thừa của anh em sẽ vô đây -->
    <div class="content-wrapper">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
