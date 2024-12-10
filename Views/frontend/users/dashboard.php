<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Chào mừng, <?php echo htmlspecialchars($user['username']); ?></h2>
    <a href="index.php?controller=user&action=logout">Đăng xuất</a>
</body>
</html>