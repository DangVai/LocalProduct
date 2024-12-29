<?php
session_start();

if (!isset($_SESSION['user'])) {
    echo '<p>You must be logged in to update your profile.</p>';
    exit();
}

$user = $_SESSION['user'];
?>
<div class="user-details">
    <h1>Update Profile</h1>
    <form class="profile-form" action="index.php?controller=user&action=updateProfile" method="POST"
        enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
        <p><span>Name:</span> <input type="text" name="Name" value="<?= htmlspecialchars($user['Name']) ?>"></p>
        <p><span>Email:</span> <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"></p>
        <p><span>Phone:</span> <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>"></p>
        <p><span>Address:</span> <input type="text" name="user_address"
                value="<?= htmlspecialchars($user['user_address']) ?>"></p>
        <p><span>Avatar:</span> <input type="file" name="avata"></p>
        <button type="submit">Update Profile</button>
    </form>
</div>