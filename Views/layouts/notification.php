<?php
// Kiểm tra và hiển thị thông báo thành công
if (isset($_SESSION['success'])) {
    echo '<div class="notification success">
            <div class="icon">
                <i class="fa fa-check-circle"></i>
            </div>
            <div class="message">' . $_SESSION['success'] . '</div>
          </div>';
    unset($_SESSION['success']); // Xóa thông báo sau khi hiển thị
}

// Kiểm tra và hiển thị thông báo lỗi
if (isset($_SESSION['error'])) {
    echo '<div class="notification error">
            <div class="icon">
                <i class="fa fa-times-circle"></i>
            </div>
            <div class="message">' . $_SESSION['error'] . '</div>
          </div>';
    unset($_SESSION['error']); // Xóa thông báo sau khi hiển thị
}
?>

<style>
    /* CSS cho thông báo */
    .notification {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 300px;
        padding: 20px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 15px;
        text-align: left;
        font-size: 16px;
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        opacity: 0;
        animation: fadeIn 0.5s forwards, fadeOut 0.5s 2.5s forwards;
    }

    .notification .icon {
        font-size: 24px;
    }

    .notification.success {
        background: linear-gradient(135deg, #28a745, #218838);
    }

    .notification.error {
        background: linear-gradient(135deg, #dc3545, #c82333);
    }

    .notification.success .icon {
        color: #d4edda;
    }

    .notification.error .icon {
        color: #f8d7da;
    }

    /* Hiệu ứng fade-in và fade-out */
    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translate(-50%, -60%);
        }

        100% {
            opacity: 1;
            transform: translate(-50%, -50%);
        }
    }

    @keyframes fadeOut {
        0% {
            opacity: 1;
        }

        100% {
            opacity: 0;
        }
    }
</style>

<script>
    // Sử dụng JavaScript để ẩn thông báo sau 3 giây
    setTimeout(function () {
        const notification = document.querySelector('.notification');
        if (notification) {
            notification.remove(); // Xóa thông báo khỏi DOM
        }
    }, 3000); // 3 giây
</script>

<!-- Đừng quên thêm Font Awesome để sử dụng icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">