<!-- Biểu đồ doanh thu ngày trong tháng -->
<div class="row g-3 align-items-center">
    <div class="col-auto" style="padding: 0px">
        <label for="dailyMonthSelect" class="col-form-label">Thống kê doanh thu từng ngày:</label>
    </div>
    <div class="col-auto">
        <select id="dailyMonthSelect" class="form-control">
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ $i == $selectedDayliMonth ? 'selected' : '' }}>
                    Tháng {{ $i }}
                </option>
            @endfor
        </select>
    </div>
    <div class="col-auto" style="padding: 0px">
        <label for="dailyYearSelect" class="col-form-label">Năm:</label>
    </div>
    <div class="col-auto">
        <select id="dailyYearSelect" class="form-control">
            @foreach ($availableYears as $year)
                <option value="{{ $year }}" {{ $year == $selectedDayliYear ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-auto">
        <button id="updateChart" class="btn btn-primary">Lọc dữ liệu</button>
    </div>
</div>
<div class="col-sm-12 mb-4 mt-4">
    <canvas id="daylyRevenueChart" width="400" height="200"></canvas>
</div>

<script>
    document.getElementById('updateChart').addEventListener('click', function() {
        const selectedMonth = document.getElementById('dailyMonthSelect').value;
        const selectedYear = document.getElementById('dailyYearSelect').value;

        const queryParams = new URLSearchParams(window.location.search);
        queryParams.set('daily_month', selectedMonth);
        queryParams.set('daily_year', selectedYear);

        // Chuyển hướng đến URL mới khi nhấn Submit
        window.location.href = `?${queryParams.toString()}`;
    });
    // Dữ liệu biểu đồ
    var ctx = document.getElementById('daylyRevenueChart').getContext('2d');
    var colors = [
        'rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)', 'rgba(255, 206, 86, 0.6)',
        'rgba(75, 192, 192, 0.6)', 'rgba(153, 102, 255, 0.6)', 'rgba(255, 159, 64, 0.6)',
        'rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)', 'rgba(255, 206, 86, 0.6)',
        'rgba(75, 192, 192, 0.6)', 'rgba(153, 102, 255, 0.6)', 'rgba(255, 159, 64, 0.6)'
    ];

    var daylyRevenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labelsDailyRevenue), // Nhãn là các ngày trong tháng
            datasets: [{
                label: `Doanh thu theo các ngày trong tháng ${@json($selectedDayliMonth)} năm ${@json($selectedDayliYear)} (VND)`,
                data: @json($dataDailyRevenue), // Dữ liệu doanh thu theo ngày
                backgroundColor: colors,
            }]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            // Lấy ngày từ nhãn (label) của cột
                            const day = context[0].label;
                            // Tạo chuỗi hiển thị
                            return `Ngày ${day} tháng ${@json($selectedDayliMonth)} năm ${@json($selectedDayliYear)}`;
                        },
                        label: function(context) {
                            const total = context.raw;
                            return `Doanh thu: ${total.toLocaleString('vi-VN')} VND`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Doanh thu (VND)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Ngày trong tháng'
                    }
                }
            }
        }
    });
</script>
