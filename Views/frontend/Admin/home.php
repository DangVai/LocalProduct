<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Home</title>
  <link rel="stylesheet" href="/public/css/adminHome.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <!-- Thanh điều hướng trên cùng -->
  <div class="navbar">
    <h1>WELLCOME TO BRU-PA CÔ ADMIN</h1>
    <div class="icons">
         <i class="fa fa-bell">
            <img src="/public/images/bell icon.png" alt="">
        </i> <!-- Chuông thông báo -->
        <i class="fa fa-user">
            <img src="/public/images/admin icon.png" alt="">
            <p>Admin</p>    
        </i> 
    </div>
  </div>

  <!-- Menu bên trái -->
  <div class="sidebar">
    <img src="/public/images/logo.jpg" alt="logo">
    <a href="#">Home</a>
    <a href="#">User Management</a>
    <a href="#">Product Management</a>
    <a href="#">Order Tracking</a>
    <a href="#">Logout</a>
  </div>












  <!-- Nội dung chính -->
  <div class="content">
        
        <!-- Container chứa cả 2 biểu đồ -->
        <div class="chart-container">
            <!-- Biểu đồ số lượng sản phẩm -->
            <div class="chart">
            <canvas id="productChart"></canvas>
            </div>
        </div>

        <script>
            // === Biểu đồ số lượng sản phẩm theo danh mục ===
            const categories = ["Dress", "Shirt", "accessory", "Musical Instrument", "Food", "House items"];
            const productCounts = [50, 70, 30, 20, 40, 30];

            const productCtx = document.getElementById('productChart').getContext('2d');
            const productChart = new Chart(productCtx, {
            type: 'bar',
            data: {
                labels: categories,
                datasets: [{
                label: 'Số lượng sản phẩm',
                data: productCounts,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                ],
                borderWidth: 1
                }]
            },
            options: {
                scales: {
                y: {
                    beginAtZero: true
                }
                },
                plugins: {
                legend: {
                    display: true,
                    position: 'top',
                }
                }
            }
            });
            </script>
  </div>
    
    
</body>
</html>
