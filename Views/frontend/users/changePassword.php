<?php
if (!isset($_SESSION['user'])) {
    header("Location: index.php?controller=auth&action=login");
    exit();
}

$user = $_SESSION['user'];
?>

<h2 class="change-password-heading">Change Password</h2>
<form action="index.php?controller=user&action=changePassword" method="POST" class="change-password-form">
    <p class="form-group">
        <label for="current_password" class="form-label">Current Password:</label><br>
        <input type="password" id="current_password" name="current_password" class="form-input" required>
    </p>
    <p class="form-group">
        <label for="new_password" class="form-label">New Password:</label><br>
        <input type="password" id="new_password" name="new_password" class="form-input" required>
    </p>
    <p class="form-group">
        <label for="confirm_password" class="form-label">Confirm New Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" class="form-input" required>
    </p>
    <button type="submit" class="btn-submit">Update Password</button>
</form>