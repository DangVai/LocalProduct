<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/LocalProduct/public/css/header.css">

</head>

<body>
    <div class="header">
        <!-- Logo -->
        <div class="box_logo">

            <img src="/public/images/logo.jpg" alt="logo">

        </div>

        <!-- Navigation Menu -->
        <div class="nav">
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


                    <a href="#"><i class="fas fa-sign-in-alt fa-sm"></i> Log in</a>
                    <a href="#"><i class="fas fa-sign-out-alt fa-sm"></i> Log out</a>



                </div>
            </div>
        </div>
    </div>
</body>

</html>