<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Un</title>
    <link rel="stylesheet" href="/LocalProduct/public/css/signUp.css">
    <link rel="stylesheet" href="/LocalProduct/public/css/load.css">
    <script src="/LocalProduct/public/js/signUp.js"></script>
    <script src="/LocalProduct/public/js/load.js"></script>

</head>
 <body>
                <div id="loading" class="loading-overlay">
                <div class="spinner"></div>
                <p>Loading...</p>
            </div>
     <?php
          // Kiểm tra lỗi hoặc thông báo thành công từ URL
          if (isset($_GET['error'])) {
            echo '<p style="color: red;">' . htmlspecialchars($_GET['error']) . '</p>';
          }
          if (isset($_GET['success'])) {
            echo '<p style="color: green;">' . htmlspecialchars($_GET['success']) . '</p>';
            echo "<script>showAdditionalFields();</script>";
          }

    ?>
    <!-- Phần 1: Logo, tiêu đề, và hình ảnh trang phục -->
    <div class="header-section">
        <img src="/LocalProduct/public/images/logo.jpg" alt="Logo" class="logo">
        <img src="/LocalProduct/public/images/sao.jpg" alt="Logo" class="logo">
    </div>

    <!-- <h1>Sign Up</h1> -->

    <!-- Phần 2: Chia thành left-content và right-content -->
    <div class="content-section">
        <h1>Sign Up</h1>
        <!-- Left Content: Form đăng ký -->
        <div class="left-content">
            <form id="registration-form" action="index.php?controller=user&action=storeRegister" method="POST" onsubmit="return validatePasswords(event)" >

                 <label for="name">User Name:</label>
                <input type ="name" name="full-name" id="full-name" required>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>

                <label for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" required>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>

                <label for="confirm-password">Re-enter Password:</label>
                <input type="password" name="confirm-password" id="confirm-password" required>

                <button type="submit">Sign in</button>
            </form>
            <?php 
            if (isset($_GET['success']) && $_GET['success'] === 'ok') {
                echo '<div id="otp-form-container">
                    <form id="otp-form" action="index.php?controller=user&action=verifyOTP" method="POST">
                        <label for="OTP">Enter OTP</label>
                        <input type="text" id="OTP" name="OTP" required>
                        <button type="submit">Verify</button>
                    </form>
                </div>';
            } else {
                echo '<div id="otp-form-container" style="display: none;"></div>';
            }
        ?>
        </div>


            <!-- Thanh dọc phân cách -->
        <div class="vertical-divider"></div>

        <!-- Right Content: Nút đăng nhập Google và Facebook -->
        <div class="right-content">
            <div class="slider">
                <div class="slides">
                    <!-- Các hình ảnh -->
                    <div class="slide"><img src="/LocalProduct/public/images/VânKieu.jpg" alt="Clothes 1"></div>
                    <div class="slide"><img src="/LocalProduct/public/images/canuong 1.jpg" alt="Clothes 3"></div>
                    <div class="slide"><img src="/LocalProduct/public/images/COM LAM 1.jpg" alt="Clothes 3"></div>
                    <div class="slide"><img src="/LocalProduct/public/images/trangphuc.webp" alt="Clothes 3"></div>
                </div>
            </div>

        </div>
    </div>

    <!-- Phần cuối: Đường dẫn đến trang đăng nhập -->
    <div class="last">
        Have you been an account? <a href="index.php?controller=user&action=login">log in</a>
    </div>
</body>

</html>
