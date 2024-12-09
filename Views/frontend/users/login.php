<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="index.php?controller=user&action=handleLogin">
        <h2>Đăng Nhập</h2>
        <input type="text" name="username" placeholder="Tên người dùng" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit">Đăng Nhập</button>
    </form>
    <a href="index.php?controller=user&action=register">Chưa có tài khoản? Đăng ký</a>
    
</body>
</html>