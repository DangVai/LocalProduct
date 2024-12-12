<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page with Slider</title>
    <link rel="stylesheet" href="/LocalProduct/public/css/signin.css">
</head>

<body>
    <div class="login_container">
        <img src="/LocalProduct/public/imgs//image.png" alt="Logo Left" class="logo-top-left">
        <img src="/LocalProduct/public/imgs/image 14.png" alt="Logo Right" class="logo-top-right">
        <div class="login">
            <h2 class="form-title">Login</h2>
            <div class="body_signin">
                <div class="anh">
                    <div class="slider">
                        <div class="slides-container">
                            <img src="/LocalProduct/public/imgs/R.jpg" class="slide" alt="Slide Clone Last">
                            <img src="/LocalProduct/public/imgs/slide2.jpg" class="slide" alt="Slide 1">
                            <img src="/LocalProduct/public/imgs/slide3.jpg" class="slide" alt="Slide 2">
                            <img src="/LocalProduct/public/imgs/R.jpg" class="slide" alt="Slide 3">
                            <img src="/LocalProduct/public/imgs/image 14.png" class="slide" alt="Slide Clone First">
                        </div>
                    </div>
               
                </div>
                <div class="divider"></div>
                <form method="POST" action="index.php?controller=user&action=handleLogin">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Sign In</button>
                    <a href="index.php?controller=user&action=register">Forgot Password?</a>
                </form>
            </div>
            <a href="index.php?controller=user&action=register" class="register-link">Don't have an account? Register</a>
        </div>
    </div>

    <script src="/LocalProduct/public/js/signin.js"></script>
</body>

</html>