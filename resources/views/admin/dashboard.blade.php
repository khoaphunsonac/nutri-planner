@extends('admin.layout')

@section('content')

<!-- main content -->
  <h2 class="overview text-light"><i class="bi bi-egg-fried me-2"></i> <span style="font-size:35px;">Tổng quan hệ thống</span></h2>

  <div class="container-fluid">

<div class="row mt-4 text-center">
  {{-- Món ăn --}}
  <div class="col-md-3 mb-3">
    <a href="{{ route('meals.index') }}" class="text-decoration-none">
      <div class="dashboard-card">
        <div class="icon-circle" style="background-color: #ffe3e3;">
          <i class="bi bi-basket-fill text-danger"></i>
        </div>
        <div class="dashboard-text">Món ăn</div>
      </div>
    </a>
  </div>

  {{-- Nguyên liệu --}}
  <div class="col-md-3 mb-3">
    <a href="{{ route('ingredients.index') }}" class="text-decoration-none">
      <div class="dashboard-card">
        <div class="icon-circle" style="background-color: #fff4db;">
          <i class="bi bi-egg-fill text-warning"></i>
        </div>
        <div class="dashboard-text">Nguyên liệu</div>
      </div>
    </a>
  </div>

  {{-- Tag - Chế độ ăn --}}
  <div class="col-md-3 mb-3">
    <a href="{{ route('tags.index') }}" class="text-decoration-none">
      <div class="dashboard-card">
        <div class="icon-circle" style="background-color: #dbf0ff;">
          <i class="bi bi-tags-fill text-info"></i>
        </div>
        <div class="dashboard-text">Loại chế độ ăn</div>
      </div>
    </a>
  </div>

  {{-- Người dùng --}}
  <div class="col-md-3 mb-3">
    <a href="{{ route('users.index') }}" class="text-decoration-none">
      <div class="dashboard-card">
        <div class="icon-circle" style="background-color: #dbffe4;">
          <i class="bi bi-people-fill text-success"></i>
        </div>
        <div class="dashboard-text">Người dùng</div>
      </div>
    </a>
  </div>
</div>

  <div class="row">
      <!-- cards -->
  <div class="col-md-5">
  <div class="row g-4">
    @php
      $cards = [
        ['label' => 'Tổng món ăn', 'value' => $mealsCount ?? 0, 'icon' => 'bi-basket-fill', 'color' => ['#ff8f85', '#fc4811']],
        ['label' => 'Người dùng', 'value' => $user ?? 0, 'icon' => 'bi-people-fill', 'color' => ['#77c2ff', '#1976D2']],
        ['label' => 'Feedbacks', 'value' => $feedbacks ?? 0, 'icon' => 'bi-chat-dots-fill', 'color' => ['#ffc085', '#ff8c00']],
        ['label' => 'Liên hệ', 'value' => $contacts ?? 0, 'icon' => 'bi-envelope-fill', 'color' => ['#ef93ff', '#8b23a8']],
      ];
    @endphp
  {{-- lặp --}}
    @foreach ($cards as $card)
      <div class="col-md-6">
        <div class="card text-white shadow-sm border-0" style="background: linear-gradient(135deg, {{ $card['color'][0] }}, {{ $card['color'][1] }}); border-radius: 16px; transition: all 0.3s ease;">
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                <i class="bi {{ $card['icon'] }} text-dark fs-5"></i>
              </div>
              <h6 class="card-title fw-semibold mb-0">{{ $card['label'] }}</h6>
            </div>
            <hr class="border-white opacity-75">
            <h3 class="fw-bold mb-0">{{ $card['value'] }}</h3>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  </div>
      <!-- món ăn theo chế độ ăn -->
      <div class="col-md-7">
  <div class="card shadow-sm border-0 h-100" style="border-radius: 10px;">
    <div class="card-body">
      <h5 class="card-title fw-bold mb-3 text-center" 
        style="background-color: rgb(255, 169, 30); 
              color: #fffcfc; border-radius: 7px;
              font-size: 23px ">
        </i>Món ăn theo chế độ ăn
      </h5>
      <div style="height: 260px;">
        <canvas id="dietTypeChart"></canvas>
      </div>
    </div>
  </div>
</div>

    </div>

{{-- tính % user sử dụng vào web sử dụng --}}
@php
  $user = $user ?? 3; # data mặc định sẽ = 3 để thấy rõ dữ liệu đổi màu
  $max = 100; # max là 100% full cây user
  $userPercent = round(($user / $max) * 100); # làm tron từ số thứ 2
@endphp
 <div class="row mt-3">
  <!-- biểu đồ -->
  <div class="col-md-6 d-flex align-items-stretch mb-4">
    <div class="card shadow-lg border-0 p-3 w-100" style="background-color: #ffffff">
      <h5 class="text-center mb-3" style="font-size: 25px;">
        <span class="chart">
          <i class="bi bi-bar-chart-line-fill me-2 text-primary"></i>Tỉ lệ Người dùng</span>
      </h5>
      <div class="row align-items-center">
        <div class="col-md-6 d-flex justify-content-center" >
          {{-- kích cỡ biểu đồ --}}
          <div style="position: relative; width: 100%; height: 220px;">
            <canvas id="userGaugeChart"></canvas>
            <div style="
              position: absolute; top: 50%; left: 50%;
              transform: translate(-50%, -40%);
              font-size: 35px;
              font-weight: bold;
              color: #d70c0c;
              margin-top: 10%;">
              <i class="bi bi-person-fill-add"></i> +{{ $userPercent }}%
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <p class="mb-0 text-center text-md-start" style="18px; width: 80%; margin-left: 12px;">
            Phân tích người dùng theo thời gian cho thấy lượng người dùng đã
            <span class="fw-bold text-danger">tăng {{ $userPercent }}%</span><br>
            kể từ <span class="fw-semibold text-primary">{{ $lastDay }}</span>.
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- bản đồ -->
  <div class="col-md-6 d-flex align-items-stretch mb-4">
    <div class="card shadow-lg border-0 p-3 w-100" style="background-color: #ffffff">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0" style="font-size: 25px;">
          <i class="bi bi-geo-alt-fill text-success me-1"></i> Địa chỉ Fitfood
        </h5>
        {{-- link đến chức năng chỉnh sửa --}}
        <a href="" class="btn btn-outline-secondary btn-sm">Chỉnh sửa</a>
      </div>
      <div class="ratio ratio-16x9" style="height: 220px;">
        <iframe
          src="https://www.google.com/maps?q=778/10 Đ. Nguyễn Kiệm, Phường 3, Phú Nhuận, Hồ Chí Minh 700990, Vietnam&output=embed"
          width="100%" height="100%" style="border:0;" allowfullscreen=""
          loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>
  </div>
</div>
    <!-- Top nổi bật NẾU sau thêm -->

{{-- nhúng chart để dùng biểu đồ user và món ăn theo chế độ ăn --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('userGaugeChart').getContext('2d'); // vẽ 2d với ctx
  new Chart(ctx, { // ctx
    type: 'doughnut', // tròn rỗng
    data: {
      labels: ['Người dùng', 'còn trống'],
      datasets: [{
        data: [{{ $userPercent }}, {{ 100 - $userPercent }}],
        backgroundColor: ['#FFCA28', '#eed'],
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      rotation: -90,
      circumference: 180,
      cutout: '60%',
      plugins: {
        legend: {
          display: true,
          position: 'top', // Đưa legend lên
          labels: {
            font: {
              size: 17 // cỡ chữ
            }
          }
        }
      }
    }
  });
</script>
{{-- ve cho mốn ăn theo chế độ --}}
<script>
const labels = {!! json_encode($DietTypeCount->pluck('name')) !!};
const data = {!! json_encode($DietTypeCount->pluck('meals_count')) !!};

// Lấy top 3 giá trị lớn nhất và index của chúng
const sorted = [...data].map((val, i) => ({ val, i }))
                        .sort((a, b) => b.val - a.val);

const topIndices = sorted.slice(0, 3).map(obj => obj.i);

// màu theo vị trí: top 1, 2, 3
const backgroundColors = data.map((val, index) => {
  if (index === topIndices[0]) return '#FF7043'; // Top 1 - đỏ cam
  if (index === topIndices[1]) return '#FFD54F'; // Top 2 - vàng
  if (index === topIndices[2]) return '#4FC3F7'; // Top 3 - xanh dương
  return '#81C784'; // còn lại - xanh ngọc
});

const borderColors = backgroundColors.map(color => color);

const dietCtx = document.getElementById('dietTypeChart').getContext('2d');
new Chart(dietCtx, {
  type: 'bar',
  data: {
    labels: labels,
    datasets: [{
      label: 'Số món ăn',
      data: data,
      backgroundColor: backgroundColors,
      borderColor: borderColors,
      borderWidth: 1,
      borderRadius: 5,
      barThickness: 28
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: true,
        labels: {
          font: {
          size: 15 
          },
          generateLabels: function() {
            return [
              { text: 'Top nhiều món nhất', fillStyle: '#FF7043' },
              { text: 'Top 2', fillStyle: '#FFD54F' },
              { text: 'Top 3', fillStyle: '#4FC3F7' },
              { text: 'Khác', fillStyle: '#81C784' }
            ];
          }
        }
      },
      tooltip: {
        callbacks: {
          label: function(context) {
            return ` ${context.raw} món ăn`;
          }
        }
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: { stepSize: 1 },
        grid: { color: '#eee' }
      },
      x: {
        ticks: { font: { size: 14 } }
      }
    }
  }
});
</script>

@endsection
