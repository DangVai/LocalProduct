<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Thêm link đến Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/LocalProduct/public/css/header.css">
<?php
session_start();
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) {
    echo "<script>console.log('User is logged in');</script>";
} else {
    echo "<script>console.log('User is not logged in');</script>";
}
?>

</head>
<body>
    <div class="container-H">
        <div class="header">
            <!-- Logo -->
            <div class="box_logo">
                <img src="/LocalProduct/public/images/logo.jpg" alt="logo">
            </div>

            <!-- Navigation Menu -->
            <div class="nav">
                <a href="index.php?controller=home&action=home"><b>Home</b></a>
                <a href="index.php?controller=product&action=fashion"><b>Fashion</b></a>
                <a href="index.php?controller=product&action=food"><b>Cuisin</b></a>
                <a href="index.php?controller=product&action=another"><b>Other</b></a>
                <a href="index.php?controller=home&action=aboutus"><b>About us</b></a>

            </div>

            <!-- Search -->
            <form id="search-form" action="index.php?controller=product&action=search" method="GET">
                <div class="searchHome">
                    <input type="hidden" name="controller" value="product">
                    <input type="hidden" name="action" value="search">
                    <input type="text" name="keyword" id="search-keyword" placeholder="Search..." class="searchInput"
                        required>
                    <button type="submit" class="searchButton">🔍</button>
                </div>
                <!-- <input type="hidden" name="action" value="search"> -->
            </form>
            <div class="cart">
                <div class="box-cart">
                    <a href="#" onclick="checkLogin(event, 'index.php?controller=cart&action=viewCart')">
                        <b><i class="fas fa-shopping-cart"></i></b>
                    </a>
                </div>
            </div>
            <div class="favorite">
                <div class="box-heart">
                    <a href="index.php?controller=favorite&action=showFavorites">
                        <b><i class="fas fa-heart"></i></b>
                    </a>
                </div>
            </div>
            <!-- User Account -->
            <div class="name-user">
                <div class="account">
                    <div class="box-account">
                        <a href="#" onclick="toggleDropdown(event)">
                            <i class="fa-regular fa-user"></i>
                        </a>
                    </div>
                    <div class="dropdown-menu" id="account-menu">
                        <a href="index.php?controller=user&action=profile"><i class="fas fa-user fa-sm"></i> Profile</a>
                        <a href="#"><i class="fas fa-cogs fa-sm"></i> Settings</a>
                        <a href="index.php?controller=user&action=login"><i class="fas fa-sign-in-alt fa-sm"></i> Log
                            in</a>
                        <a href="index.php?controller=user&action=logout"><i class="fas fa-sign-out-alt fa-sm"></i> Log
                            out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" text-run ">
        <span>Welcome to Vân Kiều and Pa Cô fashion store! Explore the unique products today!</span>
    </div>

    <!-- Banner -->
    <div class="banner ">
        <img src="/LocalProduct/public/images/Vân Kiều - Pa Cô.png " alt="Banner ">
    </div>
    <div class="img-sliders ">
        <div class="slider-container ">
            <div class="slides " id="slider1 ">
                <img src="/LocalProduct/public/imgaes/Product_image/tui1.jpg" class="slide " alt="Slide 1 ">
                <img src="/LocalProduct/public/images/slide2.jpg " class="slide " alt="Slide 2 ">
                <img src="/LocalProduct/public/images/slide3.jpg " class="slide " alt="Slide 3 ">
            </div>
        </div>
        <div class="slider-container ">
            <div class="slides " id="slider2 ">
                <img src="/LocalProduct/public/images/slide3.jpg " class="slide " alt="Slide 1 ">
                <img src="/LocalProduct/public/images/R.jpg " class="slide " alt="Slide 2 ">
                <img src="/LocalProduct/public/images/slide2.jpg " class="slide " alt="Slide 3 ">
            </div>
        </div>
        <div class="slider-container ">
            <div class="slides " id="slider3 ">
                <img src="/LocalProduct/public/images/slide2.jpg " class="slide " alt="Slide 1 ">
                <img src="/LocalProduct/public/images/slide3.jpg " class="slide " alt="Slide 2 ">
                <img src="/LocalProduct/public/images/R.jpg " class="slide " alt="Slide 3 ">
            </div>
        </div>
    </div>
    </div>



    <script src="/LocalProduct/public/js/home.js"></script>
</body>
<script>
    function toggleDropdown(event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a>
        const dropdownMenu = document.getElementById('account-menu');
        // Thêm hoặc bỏ lớp 'show' để bật/tắt menu
        dropdownMenu.classList.toggle('show');
    }

    // Đóng menu khi click bên ngoài
    document.addEventListener('click', function(event) {
        const dropdownMenu = document.getElementById('account-menu');
        const accountBox = document.querySelector('.box-account');

        if (!accountBox.contains(event.target)) {
            dropdownMenu.classList.remove('show');
        }
    });

        function checkLogin(event, url) {
        event.preventDefault(); // Ngăn chuyển hướng mặc định

        // Kiểm tra trạng thái đăng nhập từ PHP
       const isLoggedIn = <?php echo isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] ? 'true' : 'false'; ?>;

                if (isLoggedIn) {
                    // Nếu đã đăng nhập, cho phép chuyển hướng
                    window.location.href = url;
                } else {
                    // Nếu chưa đăng nhập, hiển thị thông báo với tùy chọn
                    const userChoice = confirm("Bạn cần đăng nhập để sử dụng tính năng này. Bạn có muốn đăng nhập không?");
                    if (userChoice) {
                        // Chuyển hướng tới trang đăng nhập
                        window.location.href = 'index.php?controller=user&action=login';
                    } else {
                        // Người dùng chọn hủy, không làm gì
                        console.log("Người dùng đã hủy hành động.");
                    }
                }
            }
</script>

</html>