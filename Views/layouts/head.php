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
                    <input type="text" name="keyword" id="search-keyword" placeholder="Tìm kiếm..." class="searchInput" required>
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
            <div class="account">
                <div class="box-account">
                    <a href="index.php?controller=user&action=profile">
                        <i class="fa-regular fa-user"></i>
                    </a>
                </di>
            </div>


                <!-- User Name and Dropdown Menu -->
                <div class="header-user">
                    <!-- Hiển thị khi người dùng đã đăng nhập -->
                    <div class="name-user" id="user-info"
                        <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']) echo 'style="display: block;"'; ?>>
                        <p class="username"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></p>
                    </div>

                    <!-- Hiển thị khi người dùng chưa đăng nhập -->

                </div>

            </div>
        </div>
</body>

</html>