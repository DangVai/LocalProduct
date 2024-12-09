<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
</head>
<?php
// include $_SERVER['DOCUMENT_ROOT'] . '/localProducts/Views/layouts/header.php';?>
<body>
    <h1>Đăng Ký Tài Khoản</h1>
    <form action="index.php?controller=user&action=storeRegister" method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <br>
    <button type="submit">Register</button>
</form>
<?php // Đường dẫn tuyệt đối
// include $_SERVER['DOCUMENT_ROOT'] . '/localProducts/Views/layouts/footer.php';
?>
</body>

</html>