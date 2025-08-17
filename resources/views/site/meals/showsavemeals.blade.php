@extends('site.layout')

@section('content')
<style>
    .shadow-text {
        text-shadow: 2px 2px 6px rgba(0,0,0,0.6);
    }

    meal-card {
    transition: all 0.3s ease;
    cursor: pointer;
    border-radius: 12px;
    overflow: hidden;
    position: relative;
    border: none;
    }

    .meal-card img {
        transition: all 0.3s ease;
        width: 100%;
        height: 300px;
        object-fit: cover;
    }

    .meal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.2);
    }

    .meal-card:hover img {
        filter: brightness(75%);
    }

    .favorite-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        padding: 8px;
        border: none;
        transition: 0.3s ease;
    }

    .favorite-btn:hover {
        background: rgba(255, 255, 255, 1);
        transform: scale(1.1);
    }

    .favorite-btn i {
        font-size: 20px;
        color: rgba(0,0,0,0.5);
        transition: color 0.3s ease;
    }

    .favorite-btn.liked i {
        color: red;
    }
        
</style>


    <div class=" meal-header align-items-center text-center" style="background-image: url(https://fitfood.vn/img/2160x900/uploads/menu-16952880378313.jpg); ">
        <div class="container mb-3" style="">
            <h2 class="display-5 fw-bold text-white shadow-text">Kế hoạch món ăn mỗi bữa</h2>
            <div class="scroll-down-icon">
                <i class="fas fa-arrow-down text-white fa-3x animate-bounce"></i>
            </div>
        </div>
    </div>

    <div class="container my-4">
    <h2 class="mb-4 text-center text-info">Món ăn yêu thích</h2>

    @if($meals->count() > 0)
        <div class="row g-4">
            @foreach($meals as $meal)
                <div class="col-md-4">
                    <div class="card meal-card">
                        @php
                            $imageURL = $meal->image_url 
                                ? url("uploads/meals/{$meal->image_url}") 
                                : "https://placehold.co/300x400?text=No+Image";

                            $totalPro = 0;
                            $totalCarbs= 0;
                            $totalFat= 0;
                            $totalKcal= 0;
                            foreach($meal->recipeIngredients as $pri){
                                $ingredient = $pri->ingredient;
                                if($ingredient){
                                    $quantity = $pri->quantity ?? 1; // Lấy quantity từ recipe_ingredients
                                    // Tính P/C/F = (giá trị trong ingredient) * (quantity / 100) 
                                    // Tính toán P/C/F: nếu có quantity thì chia 10, không thì lấy giá trị gốc
                                    $pro = ($ingredient->protein ?? 0) * ($quantity > 1 ? ($quantity/100) : 1);
                                    $carb = ($ingredient->carb ?? 0) * ($quantity > 1 ? ($quantity/100) : 1);
                                    $fat = ($ingredient->fat ?? 0) * ($quantity > 1 ? ($quantity/100) : 1);

                                    $totalPro += $pro;
                                    $totalCarbs += $carb;
                                    $totalFat += $fat;
                                    $totalKcal += $pri->total_calo ?? 0;
                                }
                            }
                            
                            $displayPro = round($totalPro, );
                            $displayCarbs = round($totalCarbs, );
                            $displayFat = round($totalFat, );
                            $displayKcal = round($totalKcal, 1);

                        @endphp

                        <a href="{{ route('meal.show', $meal->id) }}" class="text-decoration-none text-dark">
                            <img src="{{ $imageURL }}" alt="{{ $meal->name }}" class="card-img-top">
                            <div class="card-body">
                                <h4 class="card-title">{{ $meal->name }}</h4>
                                <p class="card-text text-muted">{{ Str::limit($meal->description, 80) }}</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-primary">{{ $displayKcal }} kcal</span>
                                    <span class="badge bg-success">P: {{ $displayPro }}g</span>
                                    <span class="badge bg-warning text-dark">C: {{ $displayCarbs }}g</span>
                                    <span class="badge bg-danger">F: {{ $displayFat }}g</span>
                                </div>
                            </div>
                        </a>
                        <div style="position: absolute; top: 10px; right: 10px; display: inline;"  class="favorite-form">
                            <div class="favorite-btn-container ">
                            <button type="button" 
                                    class="btn btn-favorite {{ auth()->check() && in_array($meal->id, explode('-', auth()->user()->savemeal ?? '')) ? 'liked' : '' }}" 
                                    data-meal-id="{{ $meal->id }}"
                                    style="font-size: 20px; background: rgba(0,0,0,0.1); border: none; cursor: pointer;">
                                <i class="fas fa-heart" style="color: {{ auth()->check() && in_array($meal->id, explode('-', auth()->user()->savemeal ?? '')) ? 'red' : 'gray' }};"></i>
                            </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Bạn chưa lưu món ăn nào.</p>
    @endif
</div>



    <script>
        // document.addEventListener('DOMContentLoaded', function () {
        // document.querySelectorAll('.favorite-form').forEach(function (form) {
        //         form.addEventListener('click', function (event) {
        //             event.stopPropagation(); // Ngăn click lan ra ngoài
        //         });
        //     });
        // });


document.addEventListener('DOMContentLoaded', function() {
    // Hàm hiển thị dialog xác nhận
    function showConfirmDialog(message, callback) {
        if (confirm(message)) {
            callback(true);
        } else {
            callback(false);
        }
    }

    // Xử lý sự kiện click nút tim
    document.querySelectorAll('.btn-favorite').forEach(btn => {
        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const mealId = this.dataset.mealId;
            const icon = this.querySelector('i');
            const isCurrentlyLiked = icon.style.color === 'red';
            
            // Nếu đang liked (màu đỏ) thì hiển thị xác nhận
            if (isCurrentlyLiked) {
                showConfirmDialog('Bạn có chắc muốn bỏ thích món ăn này?', async (confirmed) => {
                    if (confirmed) {
                        await processLikeAction(mealId, icon, false);
                    }
                });
            } else {
                // Nếu đang unliked thì like luôn không cần hỏi
                await processLikeAction(mealId, icon, true);
            }
        });
    });

    // Hàm xử lý like/unlike
    async function processLikeAction(mealId, icon, shouldLike) {
        try {
            const response = await fetch(`/meals/favorite/${mealId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.status === 'success') {
                // 1. Cập nhật icon tim
                icon.style.color = data.saved ? 'red' : 'gray';
                
                // 2. Cập nhật số lượng giỏ hàng
                updateCartCount(data.favoriteCount);
                
                // 3. Nếu bỏ like thì xóa card
                if (!data.saved) {
                    removeMealCard(mealId);
                }
                
                // 4. Hiển thị thông báo
                showToast(data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Có lỗi xảy ra', true);
        }
    }

    // Hàm xóa card
    function removeMealCard(mealId) {
        const card = document.querySelector(`.col-md-4 [data-meal-id="${mealId}"]`)?.closest('.col-md-4');
        if (card) {
            card.remove();
            checkEmptyList();
        }
    }

    // Kiểm tra danh sách trống
    function checkEmptyList() {
        const container = document.querySelector('.row.g-4');
        if (container && container.querySelectorAll('.col-md-4').length === 0) {
            container.innerHTML = `
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Bạn chưa lưu món ăn nào.</p>
                </div>
            `;
        }
    }

    // Hàm cập nhật giỏ hàng
    function updateCartCount(count) {
        const badge = document.getElementById('favoriteCountBadge');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }

    // Hàm hiển thị thông báo đơn giản
    function showToast(message, isError = false) {
        alert(message); // Có thể thay bằng toast đẹp hơn
    }
});
    </script>
@endsection