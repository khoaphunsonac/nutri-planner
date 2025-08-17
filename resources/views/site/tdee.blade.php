{{-- filepath: c:\laragon\www\nutri-planner\resources\views\site\tdee.blade.php --}}
@extends('site.layout')

@section('content')
@php
    // màu theme hiện đại hơn
    $dark = '#111111';
    $muted = '#6C757D';
    $light = '#ADB5BD';
    $accent = '#E83850';
    $accent2 = '#17A2B8';
    $success = '#28A745';
    $warning = '#FFC107';
@endphp

<style>
    :root {
        --dark: {{ $dark }};
        --muted: {{ $muted }};
        --light: {{ $light }};
        --accent: {{ $accent }};
        --accent2: {{ $accent2 }};
        --success: {{ $success }};
        --warning: {{ $warning }};
        --gradient-primary: linear-gradient(135deg, {{ $accent }}, {{ $accent2 }});
        --gradient-dark: linear-gradient(135deg, {{ $dark }}, #495057);
        --gradient-success: linear-gradient(135deg, {{ $success }}, #20C997);
        --gradient-warning: linear-gradient(135deg, {{ $warning }}, #FD7E14);
        --shadow-sm: 0 2px 10px rgba(0,0,0,0.08);
        --shadow-md: 0 4px 20px rgba(0,0,0,0.12);
        --shadow-lg: 0 8px 30px rgba(0,0,0,0.15);
        --border-radius: 16px;
        --border-radius-lg: 24px;
    }

    body {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* Header modernized */
    .tdee-header {
        background: var(--gradient-dark);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
        border: none;
    }

    .tdee-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 100%);
        pointer-events: none;
    }

    .tdee-header .card-body {
        position: relative;
        z-index: 1;
        padding: 2.5rem;
    }

    .tdee-header h3 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #fff, #f8f9fa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Modern cards */
    .modern-card {
        background: white;
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .modern-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .modern-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
    }

    /* Form styling */
    .form-label {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 1rem;
        font-size: 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
        background: white;
        position: relative;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--accent2);
        box-shadow: 0 0 0 4px rgba(23, 162, 184, 0.1);
        transform: translateY(-1px);
    }

    .form-control:invalid {
        border-color: #dc3545;
    }

    .form-control:valid {
        border-color: var(--success);
    }

    /* Input groups with icons */
    .input-icon {
        position: relative;
    }

    .input-icon i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        z-index: 10;
    }

    .input-icon .form-control,
    .input-icon .form-select {
        padding-left: 3rem;
    }

    /* Modern buttons */
    .btn-modern {
        border-radius: 50px;
        padding: 1rem 2.5rem;
        font-weight: 700;
        font-size: 1.1rem;
        border: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn-modern:hover::before {
        left: 100%;
    }

    .btn-accent2 {
        background: var(--gradient-primary);
        color: white;
        box-shadow: var(--shadow-md);
    }

    .btn-accent2:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 25px rgba(23, 162, 184, 0.4);
    }

    /* Result cards */
    .result-section {
        display: none;
        animation: slideInUp 0.6s ease;
    }

    .result-card {
        background: linear-gradient(135deg, white, #f8f9fa);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .result-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: var(--gradient-success);
    }

    .metric-card {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .metric-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        transition: all 0.3s ease;
    }

    .metric-card.bmr::before {
        background: var(--gradient-primary);
    }

    .metric-card.tdee::before {
        background: var(--gradient-success);
    }

    .metric-card.lose::before {
        background: linear-gradient(135deg, #dc3545, #e83850);
    }

    .metric-card.gain::before {
        background: var(--gradient-warning);
    }

    .metric-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
        border-color: var(--accent2);
    }

    .metric-value {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0.5rem 0;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .metric-label {
        font-size: 1rem;
        font-weight: 600;
        color: var(--dark);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .metric-subtitle {
        font-size: 0.9rem;
        color: var(--muted);
        margin-top: 0.5rem;
    }

    /* Activity levels styling */
    .activity-option {
        padding: 1rem;
        border-radius: 12px;
        background: white;
        border: 2px solid #e9ecef;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 0.5rem;
    }

    .activity-option:hover {
        border-color: var(--accent2);
        background: rgba(23, 162, 184, 0.05);
    }

    .activity-option.active {
        border-color: var(--accent2);
        background: rgba(23, 162, 184, 0.1);
    }

    /* Loading animation */
    .calculating {
        position: relative;
        pointer-events: none;
    }

    .calculating::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 30px;
        height: 30px;
        margin: -15px 0 0 -15px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid var(--accent);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes slideInUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .pulse {
        animation: pulse 2s infinite;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .tdee-header .card-body {
            padding: 2rem 1.5rem;
        }
        
        .tdee-header h3 {
            font-size: 2rem;
        }

        .metric-value {
            font-size: 2rem;
        }

        .btn-modern {
            padding: 0.875rem 2rem;
            font-size: 1rem;
        }
    }

    /* Progress bar */
    .progress-modern {
        height: 8px;
        border-radius: 10px;
        background: #e9ecef;
        overflow: hidden;
        margin: 1rem 0;
    }

    .progress-bar-modern {
        height: 100%;
        background: var(--gradient-primary);
        border-radius: 10px;
        transition: width 0.6s ease;
    }

    /* Tooltips */
    .tooltip-icon {
        color: var(--muted);
        cursor: help;
        font-size: 0.9rem;
        margin-left: 0.5rem;
    }

    .tooltip-icon:hover {
        color: var(--accent2);
    }
</style>

<div class="container my-5">
    <!-- Modern Header -->
    <div class="tdee-header mb-5">
        <div class="card-body text-center">
            <h3 class="mb-3">🔥 TDEE Calculator</h3>
            <p class="mb-0 text-white-50 fs-5">
                Tính toán lượng calo tiêu hao hàng ngày dựa trên chỉ số cơ thể và mức độ hoạt động
            </p>
            <div class="progress-modern mt-3">
                <div class="progress-bar-modern" id="formProgress" style="width: 0%"></div>
            </div>
        </div>
    </div>

    <!-- Calculator Form -->
    <div class="modern-card mb-5">
        <div class="card-body p-4">
            <form id="tdeeForm" onsubmit="calculateTDEE(event)">
                <div class="row g-4">
                    <!-- Gender Selection -->
                    <div class="col-lg-6">
                        <label class="form-label">
                            <i class="bi bi-person-fill text-primary"></i>
                            Giới tính
                            <i class="bi bi-info-circle tooltip-icon" title="Chọn giới tính để tính BMR chính xác"></i>
                        </label>
                        <div class="input-icon">
                            <i class="bi bi-gender-ambiguous"></i>
                            <select id="gender" class="form-select" required onchange="updateProgress()">
                                <option value="">-- Chọn giới tính --</option>
                                <option value="male">👨 Nam</option>
                                <option value="female">👩 Nữ</option>
                            </select>
                        </div>
                    </div>

                    <!-- Age -->
                    <div class="col-lg-6">
                        <label class="form-label">
                            <i class="bi bi-calendar text-success"></i>
                            Tuổi
                            <i class="bi bi-info-circle tooltip-icon" title="Tuổi từ 10-100"></i>
                        </label>
                        <div class="input-icon">
                            <i class="bi bi-hash"></i>
                            <input type="number" id="age" class="form-control" min="10" max="100" 
                                   placeholder="Nhập tuổi của bạn" required onchange="updateProgress()">
                        </div>
                    </div>

                    <!-- Height -->
                    <div class="col-lg-6">
                        <label class="form-label">
                            <i class="bi bi-rulers text-info"></i>
                            Chiều cao (cm)
                            <i class="bi bi-info-circle tooltip-icon" title="Chiều cao từ 50-250cm"></i>
                        </label>
                        <div class="input-icon">
                            <i class="bi bi-arrow-up"></i>
                            <input type="number" id="height" class="form-control" min="50" max="250" 
                                   placeholder="Ví dụ: 170" required onchange="updateProgress()">
                        </div>
                    </div>

                    <!-- Weight -->
                    <div class="col-lg-6">
                        <label class="form-label">
                            <i class="bi bi-speedometer text-warning"></i>
                            Cân nặng (kg)
                            <i class="bi bi-info-circle tooltip-icon" title="Cân nặng từ 20-200kg"></i>
                        </label>
                        <div class="input-icon">
                            <i class="bi bi-weight"></i>
                            <input type="number" id="weight" class="form-control" min="20" max="200" step="0.1" 
                                   placeholder="Ví dụ: 65.5" required onchange="updateProgress()">
                        </div>
                    </div>

                    <!-- Activity Level -->
                    <div class="col-12">
                        <label class="form-label">
                            <i class="bi bi-activity text-danger"></i>
                            Mức độ hoạt động
                            <i class="bi bi-info-circle tooltip-icon" title="Chọn mức độ phù hợp với lối sống của bạn"></i>
                        </label>
                        <div class="input-icon">
                            <i class="bi bi-lightning"></i>
                            <select id="activity" class="form-select" required onchange="updateProgress()">
                                <option value="">-- Chọn mức độ hoạt động --</option>
                                <option value="1.2">🪑 Ít vận động - Ngồi nhiều, ít hoạt động thể chất</option>
                                <option value="1.375">🚶 Hoạt động nhẹ - Tập thể dục 1-3 ngày/tuần</option>
                                <option value="1.55">🏃 Hoạt động vừa - Tập thể dục 3-5 ngày/tuần</option>
                                <option value="1.725">💪 Hoạt động cao - Tập thể dục 6-7 ngày/tuần</option>
                                <option value="1.9">🏋️ Vận động rất cao - Tập luyện chuyên nghiệp</option>
                            </select>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-center mt-5">
                        <button type="submit" class="btn btn-accent2 btn-modern" id="calculateBtn">
                            <i class="bi bi-calculator me-2"></i>
                            Tính toán TDEE
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Section -->
    <div id="resultSection" class="result-section">
        <div class="result-card mb-4">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h4 class="mb-2">
                        <i class="bi bi-trophy text-warning"></i>
                        Kết quả tính toán TDEE
                    </h4>
                    <p class="text-muted">Dựa trên thông tin cá nhân và mức độ hoạt động của bạn</p>
                </div>

                <div class="row g-4">
                    <!-- BMR Card -->
                    <div class="col-md-6">
                        <div class="metric-card bmr">
                            <i class="bi bi-heart-pulse fs-1 text-primary mb-3"></i>
                            <div class="metric-label">BMR</div>
                            <div class="metric-value" id="bmrValue">0</div>
                            <div class="metric-subtitle">kcal/ngày</div>
                            <small class="text-muted">Tỷ lệ trao đổi chất cơ bản</small>
                        </div>
                    </div>

                    <!-- TDEE Card -->
                    <div class="col-md-6">
                        <div class="metric-card tdee">
                            <i class="bi bi-fire fs-1 text-success mb-3"></i>
                            <div class="metric-label">TDEE</div>
                            <div class="metric-value" id="tdeeValue">0</div>
                            <div class="metric-subtitle">kcal/ngày</div>
                            <small class="text-muted">Tổng năng lượng tiêu hao hàng ngày</small>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row g-4">
                    <!-- Weight Loss -->
                    <div class="col-md-6">
                        <div class="metric-card lose">
                            <i class="bi bi-arrow-down-circle fs-1 text-danger mb-3"></i>
                            <div class="metric-label">Giảm cân</div>
                            <div class="metric-value" id="loseWeight">0</div>
                            <div class="metric-subtitle">kcal/ngày</div>
                            <small class="text-muted">Deficit 500 kcal (~0.5kg/tuần)</small>
                        </div>
                    </div>

                    <!-- Weight Gain -->
                    <div class="col-md-6">
                        <div class="metric-card gain">
                            <i class="bi bi-arrow-up-circle fs-1 text-warning mb-3"></i>
                            <div class="metric-label">Tăng cân</div>
                            <div class="metric-value" id="gainWeight">0</div>
                            <div class="metric-subtitle">kcal/ngày</div>
                            <small class="text-muted">Surplus 500 kcal (~0.5kg/tuần)</small>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="mt-4 p-3 bg-light rounded">
                    <h6 class="mb-2">
                        <i class="bi bi-lightbulb text-warning me-2"></i>
                        Lưu ý quan trọng:
                    </h6>
                    <ul class="mb-0 small text-muted">
                        <li>Kết quả chỉ mang tính chất tham khảo</li>
                        <li>Nên tham khảo ý kiến chuyên gia dinh dưỡng</li>
                        <li>Điều chỉnh dần dần theo phản ứng của cơ thể</li>
                        <li>Kết hợp với chế độ ăn uống và tập luyện phù hợp</li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="text-center mt-4">
                    <button class="btn btn-outline-primary me-2" onclick="resetForm()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Tính lại
                    </button>
                    <button class="btn btn-success" onclick="saveResults()">
                        <i class="bi bi-bookmark me-2"></i>Lưu kết quả
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let formData = {
        gender: false,
        age: false,
        height: false,
        weight: false,
        activity: false
    };

    function updateProgress() {
        const inputs = ['gender', 'age', 'height', 'weight', 'activity'];
        let completed = 0;
        
        inputs.forEach(input => {
            const value = document.getElementById(input).value;
            if (value && value !== '') {
                formData[input] = true;
                completed++;
            } else {
                formData[input] = false;
            }
        });
        
        const progress = (completed / inputs.length) * 100;
        document.getElementById('formProgress').style.width = progress + '%';
        
        // Enable submit button when all fields are filled
        const submitBtn = document.getElementById('calculateBtn');
        if (completed === inputs.length) {
            submitBtn.disabled = false;
            submitBtn.classList.add('pulse');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.remove('pulse');
        }
    }

    function calculateTDEE(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('calculateBtn');
        submitBtn.classList.add('calculating');
        submitBtn.disabled = true;

        // Simulate calculation delay for better UX
        setTimeout(() => {
            performCalculation();
            submitBtn.classList.remove('calculating');
            submitBtn.disabled = false;
        }, 1500);
    }

    function performCalculation() {
        let gender = document.getElementById('gender').value;
        let age = parseInt(document.getElementById('age').value);
        let height = parseFloat(document.getElementById('height').value);
        let weight = parseFloat(document.getElementById('weight').value);
        let activity = parseFloat(document.getElementById('activity').value);

        if (!gender || !age || !height || !weight || !activity) {
            showToast('Vui lòng điền đầy đủ thông tin!', 'error');
            return;
        }

        // Validation
        if (age < 10 || age > 100) {
            showToast('Tuổi phải từ 10-100!', 'error');
            return;
        }

        if (height < 50 || height > 250) {
            showToast('Chiều cao phải từ 50-250cm!', 'error');
            return;
        }

        if (weight < 20 || weight > 200) {
            showToast('Cân nặng phải từ 20-200kg!', 'error');
            return;
        }

        // Công thức Mifflin-St Jeor (chính xác hơn Harris-Benedict)
        let bmr;
        if (gender === 'male') {
            bmr = 10 * weight + 6.25 * height - 5 * age + 5;
        } else {
            bmr = 10 * weight + 6.25 * height - 5 * age - 161;
        }

        let tdee = bmr * activity;
        let lose = Math.max(tdee - 500, bmr * 1.2); // Không dưới 20% TDEE
        let gain = tdee + 500;

        // Animate numbers
        animateValue('bmrValue', 0, bmr, 1000, 0);
        animateValue('tdeeValue', 0, tdee, 1200, 0);
        animateValue('loseWeight', 0, lose, 1400, 0);
        animateValue('gainWeight', 0, gain, 1600, 0);

        // Show results with animation
        const resultSection = document.getElementById('resultSection');
        resultSection.style.display = 'block';
        
        setTimeout(() => {
            resultSection.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }, 500);

        showToast('Tính toán TDEE thành công!', 'success');
    }

    function animateValue(elementId, start, end, duration, decimals = 0) {
        const element = document.getElementById(elementId);
        const range = end - start;
        const increment = range / (duration / 16);
        let current = start;
        
        const timer = setInterval(() => {
            current += increment;
            if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
                current = end;
                clearInterval(timer);
            }
            element.textContent = current.toFixed(decimals);
        }, 16);
    }

    function resetForm() {
        document.getElementById('tdeeForm').reset();
        document.getElementById('resultSection').style.display = 'none';
        document.getElementById('formProgress').style.width = '0%';
        formData = { gender: false, age: false, height: false, weight: false, activity: false };
        updateProgress();
        
        window.scrollTo({ 
            top: 0, 
            behavior: 'smooth' 
        });
        
        showToast('Đã reset form thành công!', 'info');
    }

    function saveResults() {
        const results = {
            timestamp: new Date().toISOString(),
            gender: document.getElementById('gender').value,
            age: document.getElementById('age').value,
            height: document.getElementById('height').value,
            weight: document.getElementById('weight').value,
            activity: document.getElementById('activity').value,
            bmr: document.getElementById('bmrValue').textContent,
            tdee: document.getElementById('tdeeValue').textContent,
            lose: document.getElementById('loseWeight').textContent,
            gain: document.getElementById('gainWeight').textContent
        };

        // Save to localStorage
        const savedResults = JSON.parse(localStorage.getItem('tdeeResults') || '[]');
        savedResults.push(results);
        localStorage.setItem('tdeeResults', JSON.stringify(savedResults));

        // Export to Excel (CSV)
        const headers = [
            'Thời gian', 'Giới tính', 'Tuổi', 'Chiều cao (cm)', 'Cân nặng (kg)', 'Hoạt động', 'BMR', 'TDEE', 'Giảm cân', 'Tăng cân'
        ];
        const values = [
            results.timestamp,
            results.gender,
            results.age,
            results.height,
            results.weight,
            results.activity,
            results.bmr,
            results.tdee,
            results.lose,
            results.gain
        ];

        // Add UTF-8 BOM for proper Vietnamese encoding
        let csvContent = '\uFEFF' + headers.join(',') + '\n' + values.map(v => `"${v}"`).join(',');

        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        const filename = `tdee-results-${new Date().toISOString().slice(0,10)}.csv`;

        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        a.remove();
        URL.revokeObjectURL(url);

        showToast('Đã lưu kết quả thành công!', 'success');
    }

    function showToast(message, type = 'info') {
        const toastContainer = getOrCreateToastContainer();
        
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${getBootstrapColor(type)} border-0 show`;
        toast.style.minWidth = '300px';
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi ${getToastIcon(type)} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="this.parentElement.parentElement.remove()"></button>
            </div>
        `;
        
        toastContainer.appendChild(toast);
        
        setTimeout(() => {
            if (toast.parentElement) {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }
        }, 4000);
    }

    function getOrCreateToastContainer() {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast-container position-fixed top-0 end-0 p-3';
            container.style.zIndex = '9999';
            document.body.appendChild(container);
        }
        return container;
    }

    function getBootstrapColor(type) {
        const colors = { 'success': 'success', 'error': 'danger', 'warning': 'warning', 'info': 'info' };
        return colors[type] || 'info';
    }

    function getToastIcon(type) {
        const icons = { 'success': 'bi-check-circle-fill', 'error': 'bi-x-circle-fill', 'warning': 'bi-exclamation-triangle-fill', 'info': 'bi-info-circle-fill' };
        return icons[type] || 'bi-info-circle-fill';
    }

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap tooltips if available
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
        
        updateProgress();
    });
</script>
@endsection