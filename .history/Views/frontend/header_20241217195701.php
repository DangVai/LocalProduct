<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header Example</title>
    <!-- Thêm link đến Font Awesome cho các biểu tượng (nếu chưa có) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Một số style cơ bản cho header */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #333;
            color: white;
        }
        .box_logo img {
            height: 50px;
        }
        .nav p {
            display: inline-block;
            margin: 0 15px;
            cursor: pointer;
            color: white;
        }
        .nav p:hover {
            text-decoration: underline;
        }
        .account .box-account {
            cursor: pointer;
            margin-right: 10px;
        }
        .name-user p {
            display: inline;
            margin-right: 10px;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: white;
            color: black;
            border-radius: 5px;
            margin-top: 10px;
            padding: 10px;
        }
        .name-user:hover .dropdown-menu {
            display: block;
        }
        .dropdown-menu a {
            display: block;
            color: black;
            text-decoration: none;
            padding: 5px 0;
        }
        .dropdown-menu a:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<div class="header">
    <!-- Logo -->
    <div class="box_logo">
        <img src="/public/images/logo.jpg" alt="logo">
    </div>

    <!-- Navigation Menu -->
    <div class="nav">
        <p><b>Home</b></p>
        <p><b>Thời Trang</b></p>
        <p><b>Ẩm thực</b></p>
        <p><b>Khác</b></p>
    </div>
    
    <!-- User Account -->
    <div class="account">
        <div class="box-account">
            <i class="fa-regular fa-user"></i>
        </div>
    </div>

    <!-- User Name and Dropdown Menu -->
    <div class="name-user">
        <p>
            <?php echo ($userName) ?>
        </p>
        <div class="dropdown-menu" id="account-menu">
            <div>
                <a href="../public/profile.php"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile</a>
            </div>
            <div>
                <a href=""><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Settings</a>
            </div>
            <div>
                <a href=""><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log</a>
            </div>
            <div>
                <a href="public/login.php"><i class="fas fa-sign-in-alt fa-sm fa-fw mr-2 text-gray-400"></i> Log in</a>
            </div>
            <div>
                <a href="controllers/logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Log out</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
<!-- <div class="header">
    <div class="box_logo">
        <img src="/public/images/logo.jpg" alt="logo">
    </div>
    <div class="nav">
        <p><b>Home</b></p>
        <p><b>Thời Trang</b></p>
        <p><b>Ẩm thực</b></p>
         <p><b>Khác</b></p>
    </div>
    
    <div class="account">
        <div class="box-account">
            <i class="fa-regular fa-user"></i>
        </div>
    </div>
    <div class="name-user">
        <p>
        
        </p>
        <div class="dropdown-menu" id="account-menu">
            <div>
                <a href="../public/profile.php"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile</a>
            </div>
            <div>
                <a href=""><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Settings</a>
            </div>
            <div>
                <a href=""><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log</a>
            </div>
            <div>
                <a href="public/login.php"><i class="fas fa-sign-in-alt fa-sm fa-fw mr-2 text-gray-400"></i> Log in</a>
            </div>
            <div>
                <a href="controllers/logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Log out</a>
            </div>
        </div>
    </div>
</div> -->