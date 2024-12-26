<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <link rel="stylesheet" href="/LocalProduct/public/css/userManagement.css">
</head>
<body>
    <h1>User List</h1>
    <table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Avatar</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['user_id'] ?></td>
                    <td><?= $user['Name'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['phone'] ?></td>
                    <td> <?php if ($user['avata']): ?>
                        <img src="<?= $user['avata'] ?>" alt="Avatar" width="50" height="50" />
                    <?php else: ?>
                        <img src="uploads/User_Avata/default.png" alt="No Avatar" width="50" height="50" />
                    <?php endif; ?></td>
                    <td><?= $user['status'] ?></td>
                    <td>
                        <button><a href="index.php?controller=admin&action=updateUser&id=<?= $user['user_id'] ?>">Edit</a></button>
                        <form action="index.php?controller=admin&action=lockUser" method="POST">
                            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>" />
                            <button type="submit" name="confirm_lock" onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?');">Block</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Không có người dùng nào để hiển thị.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
