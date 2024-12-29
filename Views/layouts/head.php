<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Thêm link đến Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/LocalProduct/public/css/header.css">


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
                <a href="index.php?controller=product&action=fashion"><b>Thời Trang</b></a>
                <a href="index.php?controller=product&action=food"><b>Ẩm thực</b></a>
                <a href="index.php?controller=product&action=another"><b>Khác</b></a>
            </div>

            <!-- Search -->
            <form id="search-form" action="index.php?controller=product&action=search" method="GET">
                <div class="searchHome">
                    <input type="hidden" name="controller" value="product">
                    <input type="hidden" name="action" value="search">
                    <input type="text" name="keyword" id="search-keyword" placeholder="Tìm kiếm..." class="searchInput"
                        required>
                    <button type="submit" class="searchButton">🔍</button>
                </div>
                <!-- <input type="hidden" name="action" value="search"> -->
            </form>
            <div class="cart">
                <div class="box-cart">
                    <a href="index.php?controller=cart&action=viewCart">
                        <b><i class="fas fa-shopping-cart"></i></b>
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
                        <a href="index.php?controller=user&action=logout"><i class="fas fa-sign-out-alt fa-sm"></i> Log out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
</script>
</html>