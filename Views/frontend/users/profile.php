<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="/LocalProduct/public/css/profile.css">
</head>

<body>
    <?php
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?controller=auth&action=login");
        exit();
    }

    $user = $_SESSION['user'];
    ?>
    <div class="wrapper">
        <!-- User Avatar -->
        <div class="profile-sidebar">
            <ul class="avatar">
                <img src="/LocalProduct/<?= htmlspecialchars($user['avata']) ?>" alt="User Avatar">
                <h1>User Profile</h1>
                <p><span>Name:</span> <?= htmlspecialchars($user['Name']) ?></p>
                <p><span>Email:</span> <?= htmlspecialchars($user['email']) ?></p>
                <p><span>Phone:</span> <?= htmlspecialchars($user['phone']) ?></p>
                <p><span>Address:</span> <?= htmlspecialchars($user['user_address']) ?></p>
            </ul>
            <a href="#" class="update-profile" onclick="showUpdateForm()">Update Profile</a>
            <a href="#" class="update-profile" onclick="showChangePasswordForm()">Change Password</a>
        </div>
        <!-- User Profile Information -->
        <div class="profile-content" id="profile-content">
        </div>
    </div>

    <h1>Order Tracking</h1>
    <div class="order_list">
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <div class="order_item">
                    <p>Order ID: <?= htmlspecialchars($order['order_id']) ?></p>
                    <p>Phone: <?= htmlspecialchars($order['phone']) ?></p>
                    <p>Address: <?= htmlspecialchars($order['location']) ?></p>
                    <p>Note: <?= htmlspecialchars($order['specific_address']) ?></p>
                    <p>Status: <?= htmlspecialchars($order['status']) ?></p>
                    <p>Total Price:<?= htmlspecialchars($order['total_price']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>
    </div>
    <div class="update-profile-form" id="update-profile-form"></div>
</body>

<script src="/LocalProduct/public/js/profile.js"></script>

</html>