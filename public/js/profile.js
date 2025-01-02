function showUpdateForm() {
    const profileContent = document.getElementById('profile-content');

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/LocalProduct/Views/frontend/users/updateProfile.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            profileContent.innerHTML = xhr.responseText;
        } else {
            profileContent.innerHTML = '<p>Unable to load the update form. Please try again later.</p>';
        }
    };
    xhr.onerror = function () {
        profileContent.innerHTML = '<p>An error occurred. Please try again later.</p>';
    };
    xhr.send('action=updateProfile'); // Truyền thêm dữ liệu nếu cần
}

function showChangePasswordForm() {
    const profileContent = document.getElementById('profile-content');

    // Nội dung form thay đổi mật khẩu
    profileContent.innerHTML = `
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
    `;
}

// Gọi mặc định form đổi mật khẩu khi tải trang
document.addEventListener('DOMContentLoaded', function () {
    showChangePasswordForm();
});