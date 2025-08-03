@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        {{-- Compact Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb breadcrumb-compact">
                <li class="breadcrumb-item">
                    <a href="#"><i class="bi bi-house-door"></i></a>
                </li>
                <li class="breadcrumb-item active">
                    <i class="bi bi-basket me-1"></i>Nguyên liệu
                </li>
            </ol>
        </nav>

        {{-- Compact Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <h4 class="mb-0 me-3">Nguyên liệu</h4>
                <span class="badge bg-primary rounded-pill">{{ $ingredients->total() }}</span>
                <small class="text-muted ms-2">
                    <i class="bi bi-info-circle me-1"></i>Click vào dòng để xem chi tiết
                </small>
            </div>
            <a href="{{ route('ingredients.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus me-1"></i>Thêm mới
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Compact Table --}}
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">#</th>
                            <th>Tên nguyên liệu</th>
                            <th width="70" class="text-center">Đơn vị</th>
                            <th width="70" class="text-center">Protein</th>
                            <th width="70" class="text-center">Carb</th>
                            <th width="70" class="text-center">Fat</th>
                            <th width="80" class="text-center">Calo</th>
                            <th width="110" class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ingredients as $ingredient)
                            <tr class="clickable-row" data-href="{{ route('ingredients.show', $ingredient->id) }}"
                                style="cursor: pointer;">
                                <td class="text-muted small">
                                    {{ $loop->iteration + ($ingredients->currentPage() - 1) * $ingredients->perPage() }}
                                </td>
                                <td class="fw-medium">{{ $ingredient->name }}</td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark small">{{ $ingredient->unit ?: 'g' }}</span>
                                </td>
                                <td class="text-center small">{{ number_format($ingredient->protein, 1) }}</td>
                                <td class="text-center small">{{ number_format($ingredient->carb, 1) }}</td>
                                <td class="text-center small">{{ number_format($ingredient->fat, 1) }}</td>
                                <td class="text-center">
                                    <strong class="text-primary small">{{ number_format($ingredient->calo, 0) }}</strong>
                                </td>
                                <td class="text-center" onclick="event.stopPropagation();">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('ingredients.show', $ingredient->id) }}"
                                            class="btn btn-outline-info btn-sm px-2" title="Xem chi tiết">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('ingredients.edit', $ingredient->id) }}"
                                            class="btn btn-outline-warning btn-sm px-2" title="Sửa">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm px-2"
                                            onclick="confirmDelete({{ $ingredient->id }})" title="Xóa">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $ingredient->id }}" method="POST"
                                        action="{{ route('ingredients.destroy', $ingredient->id) }}" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="bi bi-basket3 fs-3 d-block mb-2"></i>
                                    <p class="mb-2 small">Chưa có nguyên liệu nào</p>
                                    <a href="{{ route('ingredients.create') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus me-1"></i>Thêm nguyên liệu
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Compact Pagination in Footer --}}
            @if ($ingredients->hasPages())
                <div class="card-footer bg-light py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            {{ $ingredients->firstItem() }}-{{ $ingredients->lastItem() }} / {{ $ingredients->total() }}
                        </small>
                        <div class="pagination-sm">
                            {{ $ingredients->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm('Xóa nguyên liệu này?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        // Make table rows clickable
        document.addEventListener('DOMContentLoaded', function() {
            const clickableRows = document.querySelectorAll('.clickable-row');
            clickableRows.forEach(row => {
                row.addEventListener('click', function() {
                    window.location.href = this.dataset.href;
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
