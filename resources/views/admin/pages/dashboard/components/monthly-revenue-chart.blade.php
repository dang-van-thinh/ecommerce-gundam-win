
 <!-- Biểu đồ doanh thu -->
 <div class="col-sm-12 mb-4">
     <canvas id="monthlyRevenueChart" width="400" height="200"></canvas>
 </div>
 <script>


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
                 borderColor: colors.map(color => color.replace('0.6', '1')),
                 borderWidth: 1
             }]
         },
         options: {
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
                         text: 'Tháng'
                     }
                 }
             }
         }
     });
 </script>
