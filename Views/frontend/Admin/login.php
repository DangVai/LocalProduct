<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="/LocalProduct/public/css/adminLogin.css">
</head>
<body>
    <h2>Admin Login</h2>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'success'): ?>
        <!-- Form xác nhận OTP -->
        <?php $email = htmlspecialchars($_GET['email']); ?>
        <form method="POST" action="index.php?controller=Admin&action=processOTP">
            <input type="hidden" name="email" value="<?= $email ?>">
            <label for="otp">Enter OTP:</label>
            <input type="text" name="otp" id="otp" required>
            <button type="submit">Verify OTP</button>
        </form>
    <?php else: ?>
        <!-- Form login -->
        <form method="POST" action="index.php?controller=Admin&action=sendOTP">
            <?php if (isset($_GET['error']) && $_GET['error'] === 'email_invalid'): ?>
                <p style="color: red;">Email invalid! Please try again.</p>
            <?php endif; ?>
            <label for="email">Email Admin:</label>
            <input type="email" name="email" id="email" required>
            <button type="submit">Login</button>
        </form>
    <?php endif; ?>
</body>
</html>
