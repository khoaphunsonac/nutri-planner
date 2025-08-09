@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        {{-- Compact Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb breadcrumb-compact">
                <li class="breadcrumb-item">
                    <a href="#"><i class="bi bi-house-door"></i></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('meals.index') }}">Món ăn</a>
                </li>
                <li class="breadcrumb-item active">
                    Danh sách
                </li>
            </ol>
        </nav>

        {{-- Compact Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <h4 class="mb-0 me-3">Quản lý món ăn</h4>
                <span class="badge bg-primary rounded-pill">{{ $meals->total() }}</span>
                <small class="text-muted ms-2">
                    <i class="bi bi-info-circle me-1"></i>Click vào dòng để xem chi tiết
                </small>
            </div>
            <a href="{{ route('meals.add') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus me-1"></i>Thêm món ăn
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close pb-1" data-bs-dismiss="alert" style="font-size: 0.7rem;"></button>
            </div>
        @endif

        {{-- Dashboard summary --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h4>{{ $totalMeals ?? 0 }}</h4>
                        <p class="text-muted mb-0">Tổng món ăn</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h4>{{ $activeMeals ?? 0 }}</h4>
                        <p class="text-muted mb-0">Đang hoạt động</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h4>{{ $usageRate ?? 0 }}</h4>
                        <p class="text-muted mb-0">Tỷ lệ sử dụng</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search form --}}
        <form action="" method="GET" class="row g-2 align-items-center mb-4">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm món ăn..."
                    value="{{ $search ?? old('search') }}">
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary w-100" type="submit">Tìm kiếm</button>
            </div>
        </form>

        {{-- Meals Table --}}
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Danh sách món ăn</h5>
                <small>
                    {{--  Tổng số món ăn thỏa query tìm kiếm --}}
                    @if ($meals->total() > 0)
                        Tổng: {{ $meals->total() }} mục
                    @else
                        Không có kết quả nào
                    @endif
                </small>
            </div>
            <div class="card-body text-center">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Tên món ăn</th>
                            <th width="120" class="text-center">Loại bữa ăn</th>
                            <th width="120" class="text-center">Chế độ ăn</th>
                            <th width="80" class="text-center">Thẻ</th>
                            <th width="120" class="text-center">Nguyên liệu</th>
                            <th width="80" class="text-center">Calo</th>
                            <th width="130" class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($meals as $meal)
                            <tr class="meal-row" style="cursor: pointer;" data-url="{{ route('meals.show', $meal->id) }}">
                                <td class="text-muted small">
                                    {{ $loop->iteration + ($meals->currentPage() - 1) * $meals->perPage() }}
                                </td>
                                <td class="fw-medium">
                                    {{ $meal->name }}
                                    @if ($meal->image_url)
                                        <small class="text-muted"><i class="bi bi-image"></i></small>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info small">{{ $meal->mealType->name ?? 'N/A' }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success small">{{ $meal->dietType->name ?? 'N/A' }}</span>
                                </td>
                                <td class="text-center small">
                                    <span class="badge bg-secondary">{{ $meal->tags->count() }}</span>
                                </td>
                                <td class="text-center small">
                                    <span class="badge bg-warning text-dark">{{ $meal->recipeIngredients->count() }}</span>
                                </td>
                                <td class="text-center">
                                    <strong
                                        class="text-primary small">{{ number_format($meal->total_calories ?? 0, 0) }}</strong>
                                </td>
                                <td class="text-center" onclick="event.stopPropagation();">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('meals.show', $meal->id) }}"
                                            class="btn btn-outline-info btn-sm px-2" title="Xem chi tiết">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('meals.form', $meal->id) }}"
                                            class="btn btn-outline-warning btn-sm px-2" title="Sửa">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm px-2"
                                            onclick="confirmDelete({{ $meal->id }})" title="Xóa">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $meal->id }}" method="POST"
                                        action="{{ route('meals.delete', $meal->id) }}" class="d-none">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="bi bi-egg-fried fs-3 d-block mb-2"></i>
                                    <p class="mb-2 small">Chưa có món ăn nào</p>
                                    <a href="{{ route('meals.add') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus me-1"></i>Thêm món ăn
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($meals->hasPages())
                <div class="card-footer bg-light py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            {{ $meals->firstItem() }}-{{ $meals->lastItem() }} / {{ $meals->total() }}
                        </small>
                        <div class="pagination-sm">
                            {{ $meals->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm('Xóa món ăn này?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        // Make table rows clickable
        document.addEventListener('DOMContentLoaded', function() {
            const mealRows = document.querySelectorAll('.meal-row');
            mealRows.forEach(row => {
                row.addEventListener('click', function() {
                    window.location.href = this.dataset.url;
                });

                // Add hover effect
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = 'rgba(23, 162, 184, 0.1)';
                });

                row.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });
        });
    </script>
@endsection
