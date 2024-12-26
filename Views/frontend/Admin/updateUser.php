<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật thông tin người dùng</title>
    <link rel="stylesheet" href="/LocalProduct/public/css/updateUser.css">

</head>
<body>
    <h1>Update User Infor</h1>
    <form method="POST" action="index.php?controller=admin&action=updateUser" enctype="multipart/form-data">
    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>" />

    <div>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?= $user['Name'] ?>" required>
    </div>

    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= $user['email'] ?>" required>
    </div>

    <div>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" value="<?= $user['phone'] ?>" required>
    </div>

    <div>
        <label for="avatar">Avatar:</label>
        <!-- Hiển thị avatar hiện tại nếu có -->
        <?php if ($user['avata']): ?>
            <div>
                <img src="public/images/User_Avata/<?= $user['avata'] ?>" alt="Current Avatar" width="100" />
            </div>
        <?php else: ?>
            <p>No avatar</p>
        <?php endif; ?>

        <input type="file" name="avatar" id="avatar">
        <input type="hidden" name="old_avatar" value="<?= $user['avata'] ?>"> <!-- Giữ ảnh cũ nếu không thay đổi -->
    </div>


    <div>
        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>>Active</option>
            <option value="locked" <?= $user['status'] === 'locked' ? 'selected' : '' ?>>Locked</option>
        </select>
    </div>

    <button type="submit">Update</button>
</form>

</body>
</html>
