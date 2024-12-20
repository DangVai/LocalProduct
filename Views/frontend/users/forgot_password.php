
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="/LocalProduct/public/css/ForgotPassword.css">
    <link rel="stylesheet" href="/LocalProduct/public/css/load.css">
    <script src="/LocalProduct/public/js/load.js"></script>
</head>
    <script src="/LocalProduct/public/js/ForgotPassword.js"></script>
<body>
                  <div id="loading" class="loading-overlay">
                <div class="spinner"></div>
                <p>Loading...</p>
            </div>
  <div class="logo-container">
    <img class="logo" src="/LocalProduct/public/images/logo.jpg" alt="">
    <img class="logo" src="/LocalProduct/public/images/sao.jpg" alt="">
  </div>
    <h1>Forgot Password</h1>

  <div class="forgot-password-container">
    <!-- Carousel Section -->
    <div class="carousel-wrapper">
      <div id="carouselExample" class="custom-carousel">
          <!-- Slide 1 -->
          <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
              <img src="https://media-cdn-v2.laodong.vn/Storage/NewsPortal/2023/3/10/1156158/Anh-5.JPG" alt="First Slide">
            </div>
            <!-- Slide 2 -->
            <div class="carousel-item">
              <img src="https://image.tienphong.vn/w1000/Uploaded/2024/nushaosyh-haosyhnbui/2023_03_08/tp-6-7775.jpg" alt="Second Slide">
            </div>
            <!-- Slide 3 -->
            <div class="carousel-item">
              <img src="https://cdnmedia.baotintuc.vn/Upload/rGkvwNpj74Z1EcpzQ6ltA/files/2023/11/tuan1/phap3-81123.jpg" alt="Third Slide">
            </div>
        </div>

        <button class="carousel-control-prev" onclick="prevSlide()"><</button>
        <button class="carousel-control-next" onclick="nextSlide()">></button>
      </div>
    </div>

    <div class="line"></div>
    
    <!-- Form Section -->
    <div class="form-section">
      <form id="forgot-password-form" action="index.php?controller=user&action=forgotPassword" method="POST">
        <p>Please enter your email address to search for your account.</p>
        <label for="email" class="form-label-custom">Email</label>
        <input type="email" id="email" name="email" class="form-control" required>
        <button type="submit" class="btn btn-custom" id="send-code-btn" onclick="showAdditionalFields()">Send Code</button>
      </form>
        <!-- Hidden Fields -->
        <div id="additional-fields" class="hidden">
          <form action="index.php?controller=user&action=resetPassword" method="POST" onsubmit="return validatePasswords(event)">
            <div class="mb-3">
                <label for="resetCode" class="form-label">Authentication code</label>
                <input type="text" class="form-control" id="resetCode" name="resetCode" required>
            </div>
            <div class="mb-3">
                <label for="newPassword" class="form-label">New password</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Re-enter the new password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="togglePasswords" onclick="togglePasswordsVisibility()">
                <label for="togglePasswords" class="form-check-label">Show password</label>
            </div>
            <button type="submit" class="btn btn-custom">Reset password</button>
        </form>

        </div>
        <div>
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
          <p class="link"><a  href="index.php?controller=user&action=login">Sign in now</a><span class="distance"></span><a  href="index.php?controller=user&action=register">Register now</a></p>
        </div>
    </div>
  </div>
</body>
</body>

</html>