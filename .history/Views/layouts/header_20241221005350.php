<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <<<<<<< HEAD
        <title>Header Example</title>
        <!-- Thêm link đến Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="/public/css/header.css">
        =======
        <<<<<<< HEAD
            <!-- Thêm link đến Font Awesome -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <link rel="stylesheet" href="/LocalProduct/public/css/header.css">
            =======
            <title>Website</title>
            <link rel="stylesheet" href="public/css/header.css">
            >>>>>>> 90affc598e2c5a974f565b10a8329f21f3c46880
            >>>>>>> 794774b0252bb8813b9fcf70eb66ffa6241b28b7
</head>

<body>
    <div class="header">
        <!-- Logo -->
        <div class="box_logo">
            <<<<<<< HEAD
                <img src="/public/images/logo.jpg" alt="logo">
                =======
                <img src="/public/images/logo.jpg" alt="logo">
                >>>>>>> 794774b0252bb8813b9fcf70eb66ffa6241b28b7
        </div>

        <!-- Navigation Menu -->
        <div class="nav">
            <<<<<<< HEAD
                <a href="?page=home"><b>Home</b></a>

                <a href="?page=fashion"><b>Thời Trang</b></a>
                <a href="?page=food"><b>Ẩm thực</b></a>
                <a href="?page=others"><b>Khác</b></a>
        </div>

        <!-- Search -->
        <div class="searchHome">
            <input type="text" placeholder="Tìm kiếm..." class="searchInput">
            <button class="searchButton">🔍</button>
        </div>
        <div class="cart">
            <div class="box-cart">
                <i class="fas fa-shopping-cart"></i>

            </div>
        </div>
        <!-- User Account -->
        <div class="account">
            <div class="box-account">
                <i class="fa-regular fa-user"></i>
            </div>


            <!-- User Name and Dropdown Menu -->
            <div class="name-user">
                <p>John Doe</p>
                <div class="dropdown-menu" id="account-menu">
                    <a href="#"><i class="fas fa-user fa-sm"></i> Profile</a>
                    <a href="#"><i class="fas fa-cogs fa-sm"></i> Settings</a>
                    <<<<<<< HEAD
                        <a href="#"><i class="fas fa-sign-in-alt fa-sm"></i> Log in</a>
                        <a href="#"><i class="fas fa-sign-out-alt fa-sm"></i> Log out</a>
                        =======
                        <a href="index.php?controller=user&action=login"><i class="fas fa-sign-in-alt fa-sm"></i> Log in</a>
                        <a href="index.php?controller=user&action=logout"><i class="fas fa-sign-out-alt fa-sm"></i> Log out</a>
                        >>>>>>> 794774b0252bb8813b9fcf70eb66ffa6241b28b7
                </div>
            </div>
        </div>
    </div>
</body>

</html>