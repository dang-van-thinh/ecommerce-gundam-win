<div class="col-sm-12 mb-4">
    <div class="row align-items-center">
        <div class="col-auto" style="padding: 0px">
            <label for="yearSelect" class="col-form-label"> Thống kê doanh thu 12 tháng trong năm:</label>
        </div>
        <div class="col-auto" style="padding: 0px 2px">
            <select id="monthYearSelect" class="form-control">
                @foreach ($availableYears as $year)
                    <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

</div>
<!-- Biểu đồ doanh thu tháng trong năm -->
<div class="col-sm-12 mb-4">
    <canvas id="monthlyRevenueChart" width="400" height="200"></canvas>
</div>
<script>
    const yearSelect = document.getElementById('monthYearSelect');

    yearSelect.addEventListener('change', function() {
        const selectedYear = yearSelect.value;

        // Lấy URL hiện tại và thêm hoặc cập nhật tham số query `year`
        const queryParams = new URLSearchParams(window.location.search);
        queryParams.set('year', selectedYear);

        // Chuyển hướng đến URL mới
        window.location.href = `?${queryParams.toString()}`;
    });
    // Dữ liệu biểu đồ
    var ctx = document.getElementById('monthlyRevenueChart').getContext('2d');
    var colors = [
        'rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)', 'rgba(255, 206, 86, 0.6)',
        'rgba(75, 192, 192, 0.6)', 'rgba(153, 102, 255, 0.6)', 'rgba(255, 159, 64, 0.6)',
        'rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)', 'rgba(255, 206, 86, 0.6)',
        'rgba(75, 192, 192, 0.6)', 'rgba(153, 102, 255, 0.6)', 'rgba(255, 159, 64, 0.6)'
    ];

    var monthlyRevenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labelsMonthlyRevenue), // Nhãn là các tháng trong năm
            datasets: [{
                label: `Doanh thu hàng tháng năm ${@json($selectedYear)} (VND)`,
                data: @json($dataMonthlyRevenue), // Dữ liệu doanh thu tương ứng
                backgroundColor: colors,
            }]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
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
                        text: 'Tháng trong năm'
                    }
                }
            }
        }
    });
</script>
