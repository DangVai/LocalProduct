<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page with Slider</title>
    <link rel="stylesheet" href="/LocalProduct/public/css/signin.css">
    <link rel="stylesheet" href="/LocalProduct/public/css/load.css">
    <script src="/LocalProduct/public/js/load.js"></script>
</head>

<body>
    <div id="loading" class="loading-overlay">
        <div class="spinner"></div>
        <p>Loading...</p>
    </div>
    <div class="login_container">
        <img src="/LocalProduct/public/images//logo.jpg" alt="Logo Left" class="logo-top-left">
        <img src="/LocalProduct/public/images/sao.jpg" alt="Logo Right" class="logo-top-right">
        <div class="login">
            <h2 class="form-title">Login</h2>
            <div class="body_signin">
                <div class="anh">
                    <div class="slider">
                        <div class="slides-container">
                            <img src="/LocalProduct/public/images/R.jpg" class="slide" alt="Slide Clone Last">
                            <img src="/LocalProduct/public/images/slide2.jpg" class="slide" alt="Slide 1">
                            <img src="/LocalProduct/public/images/slide3.jpg" class="slide" alt="Slide 2">
                            <!-- <img src="/LocalProduct/public/images/R.jpg" class="slide" alt="Slide 3"> -->
                            <img src="/LocalProduct/public/images/R.jpg" class="slide" alt="Slide Clone First">
                        </div>
                    </div>

                </div>
                <div class="divider"></div>
                <form method="POST" action="index.php?controller=user&action=handleLogin">
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
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <button type="submit">Sign In</button>
                    <a href="index.php?controller=user&action=forgot_password">Forgot Password?</a>
                </form>
            </div>
            <p class="register-link">Don't have an account? <a
                    href="index.php?controller=user&action=register">Register</a></p>
        </div>
    </div>

    <script src="/LocalProduct/public/js/signin.js"></script>
</body>

</html>