<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Home</title>
  <link rel="stylesheet" href="/LocalProduct/public/css/adminHome.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
  <!-- Thanh điều hướng trên cùng -->
  <div class="navbar">
    <h1>WELLCOME TO BRU-PA CÔ ADMIN</h1>
    <div class="icons">
         <i class="fa fa-bell">
            <img src="/LocalProduct/public/images/bell icon.png" alt="">
        </i>
        <i class="fa fa-user">
            <img src="/LocalProduct/public/images/admin icon.png" alt="">
            <p>Admin</p>    
        </i> 
    </div>
  </div>

  <!-- Menu bên trái -->
  <div class="sidebar">
    <img src="/LocalProduct/public/images/logo.jpg" alt="logo">
    <a href="#" id="home-link">Home</a>
    <a href="#" id="user-management-link">User Management</a>
    <a href="#" id="product-management-link">Product Management</a>
    <a href="#" id="order-tracking-link">Order Tracking</a>
    <a href="#" id="logout-link">Logout</a>
  </div>

  <!-- Nội dung chính -->
  <div class="content" id="content">
    <!-- Nội dung mặc định là trang Home -->
    <div id="home-chart">
      <div class="chart-container">
        <div class="chart">
          <canvas id="productChart"></canvas>
        </div>
      </div>
      <script>
  // Hàm thay đổi nội dung `div content` bằng AJAX
  function loadPage(controllerAction) {
    $.ajax({
      url: `index.php?controller=admin&action=${controllerAction}`,
      method: 'GET',
      success: function (response) {
        $('#content').html(response); // Load nội dung mới
        // Lưu lại trang hiện tại vào sessionStorage
        sessionStorage.setItem('currentPage', controllerAction);
      },
      error: function () {
        alert('Không thể tải nội dung. Vui lòng thử lại!');
      },
    });
  }

  // Hàm hiển thị biểu đồ Home Chart
  function renderHomeChart() {
    $('#content').html(`
      <div id="home-chart">
        <div class="chart-container">
          <div class="chart">
            <canvas id="productChart"></canvas>
          </div>
        </div>
      </div>
    `);

    const categories = ['Dress', 'Shirt', 'Accessory', 'Musical Instrument', 'Food', 'House items'];
    const productCounts = [50, 70, 30, 20, 40, 30];

    const productCtx = document.getElementById('productChart').getContext('2d');
    new Chart(productCtx, {
      type: 'bar',
      data: {
        labels: categories,
        datasets: [
          {
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
            borderWidth: 1,
          },
        ],
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
          },
        },
        plugins: {
          legend: {
            display: true,
            position: 'top',
          },
        },
      },
    });

    // Lưu trang Home vào sessionStorage
    sessionStorage.setItem('currentPage', 'home'); 
  }

  // Hàm làm nổi bật menu được chọn
  function highlightActiveMenu(activeLinkId) {
    $('.sidebar a').removeClass('active'); // Xóa class 'active' khỏi tất cả menu
    $(`#${activeLinkId}`).addClass('active'); // Thêm class 'active' vào menu hiện tại
  }

  // Khôi phục trạng thái trang khi load
  $(document).ready(function () {
    const currentPage = sessionStorage.getItem('currentPage');

    if (currentPage) {
      if (currentPage === 'home') {
        renderHomeChart();
        highlightActiveMenu('home-link');
      } else {
        loadPage(currentPage);

        // Tìm và làm nổi bật menu
        const menuMap = {
          index: 'product-management-link',
          showOrders: 'order-tracking-link',
          listUsers: 'user-management-link',
        };
        highlightActiveMenu(menuMap[currentPage]);
      }
    } else {
      // Hiển thị trang Home nếu chưa có trang lưu
      renderHomeChart();
      highlightActiveMenu('home-link');
    }

    // Sự kiện khi click vào từng menu
    $('#home-link').click(function (e) {
      e.preventDefault();
      renderHomeChart();
      highlightActiveMenu('home-link');
    });

    $('#product-management-link').click(function (e) {
      e.preventDefault();
      loadPage('index'); // action=index
      highlightActiveMenu('product-management-link');
    });

    $('#order-tracking-link').click(function (e) {
      e.preventDefault();
      loadPage('showOrders'); // action=showOrders
      highlightActiveMenu('order-tracking-link');
    });

    $('#user-management-link').click(function (e) {
      e.preventDefault();
      loadPage('listUsers'); // action=listUsers
      highlightActiveMenu('user-management-link');
    });

    $('#logout-link').click(function () {
      window.location.href = 'index.php?controller=admin&action=logout'; // Đăng xuất
    });
  });
</script>



</body>
</html>
