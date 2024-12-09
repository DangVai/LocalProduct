<!DOCTYPE html>
<html>

<head>
    <title>Đặt lại mật khẩu</title>
</head>

<body>
    <h1>Đặt lại mật khẩu</h1>
    <form action="?controller=user&action=updatePassword" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
        <label for="new_password">Mật khẩu mới:</label>
        <input type="password" id="new_password" name="new_password" required>
        <label for="confirm_password">Xác nhận mật khẩu:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <button type="submit">Đặt lại mật khẩu</button>
    </form>
</body>

</html>