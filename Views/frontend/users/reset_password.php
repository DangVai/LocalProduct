<!DOCTYPE html>
<html>

<head>
    <title>Đặt lại mật khẩu</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="bg-light py-3 py-md-5">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-11 col-lg-8 col-xl-7 col-xxl-6">
                    <div class="bg-white p-4 p-md-5 rounded shadow-sm">
                        <h2 class="text-center">Đặt lại mật khẩu</h2>
                        <form action="index.php?controller=user&action=resetPassword" method="POST">
                            <div class="mb-3">
                                <label for="resetCode" class="form-label">Mã xác thực</label>
                                <input type="text" class="form-control" id="resetCode" name="resetCode" required>
                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Đặt lại mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>