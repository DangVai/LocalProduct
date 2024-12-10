<h2 class="text-center">Quên mật khẩu</h2>
<?php if (isset($error)): ?>
  <div class="alert alert-danger" role="alert">
    <?php echo htmlspecialchars($error); ?>
  </div>
<?php endif; ?>
<!DOCTYPE html>
<html>

<head>
  <title>Quên mật khẩu</title>
  <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
  <div class="bg-light py-3 py-md-5">
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-12 col-md-11 col-lg-8 col-xl-7 col-xxl-6">
          <div class="bg-white p-4 p-md-5 rounded shadow-sm">
            <h2 class="text-center">Quên mật khẩu</h2>
            <form action="index.php?controller=user&action=forgotPassword" method="POST">
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <button type="submit" class="btn btn-primary btn-lg">Gửi mã xác thực</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>