<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
}

.container {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin: 100px auto;
    width: 80%;
    background-color: #fff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    padding: 20px;
}

.container-right {
    width: 30%;
    background-color: #e3f2fd;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border-radius: 10px;
    padding: 20px;
}

.container-left {
    width: 65%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    padding: 20px;
}

.list img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 3px solid #4caf50;
    margin-bottom: 20px;
}

.profile-info {
    display: flex;
    flex-direction: column;
    gap: 15px;
    width: 100%;
}

.profile-info h1 {
    font-size: 28px;
    color: #333;
    margin-bottom: 20px;
}

.profile-info p {
    font-size: 16px;
    color: #555;
    margin: 5px 0;
}

.profile-info span {
    font-weight: bold;
    color: #333;
}

form {
    width: 100%;
}

form p {
    margin: 10px 0;
}

form input[type="text"],
form input[type="email"],
form input[type="file"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

form button {
    width: 100%;
    padding: 12px;
    background-color: #4caf50;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 20px;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #45a049;
}

</style>

<body>
<?php
if (!isset($_SESSION['user'])) {
    header("Location: index.php?controller=auth&action=login");
    exit();
}

$user = $_SESSION['user'];
?>
<body>
<div class="container">
    <!-- User Avatar -->
    <div class="container-right">
        <ul class="list">
            <img src="/LocalProduct/<?= htmlspecialchars($user['avata']) ?>" alt="User Avatar">
            <h1>User Profile</h1>
            <p><span>Name:</span> <?= htmlspecialchars($user['Name']) ?></p>
            <p><span>Email:</span> <?= htmlspecialchars($user['email']) ?></p>
            <p><span>Phone:</span> <?= htmlspecialchars($user['phone']) ?></p>
            <p><span>Address:</span> <?= htmlspecialchars($user['user_address']) ?></p>
        </ul>
    </div>
    <!-- User Profile Information -->
    <div class="container-left">
        <div class="profile-info">
            <h1>Update Profile</h1>
            <form action="index.php?controller=user&action=updateProfile" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                <p><span>Name:</span> <input type="text" name="Name" value="<?= htmlspecialchars($user['Name']) ?>"></p>
                <p><span>Email:</span> <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"></p>
                <p><span>Phone:</span> <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>"></p>
                <p><span>Address:</span> <input type="text" name="user_address" value="<?= htmlspecialchars($user['user_address']) ?>"></p>
                <p><span>Avatar:</span> <input type="file" name="avata"></p>
                <button type="submit">Update Profile</button>
            </form>
        </div>
    </div>
</div>
</body>


</html>
