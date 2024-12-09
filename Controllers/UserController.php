<?php
class UserController extends BaseController
{
    private $userModel;
    public function __construct()
    {
        session_start(); // Start session for every method
        $this->loadModel('UserModel');
        $this->userModel = new UserModel();
    }

    // Hiển thị trang đăng ký
    public function register()
    {
        $this->view('frontend.users.register');
    }

    public function storeRegister()
    {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        if (!$username || !$password) {
            die("Username or password cannot be empty!");
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $result = $this->userModel->createUser($username, $hashedPassword);

        if ($result) {
            echo "Registration successful!";
        } else {
            echo "Failed to register. Please try again.";
        }
    }

    // Hiển thị trang đăng nhập
    public function login()
    {
        $this->view('frontend.users.login');
    }

    // Xử lý đăng nhập
    public function handleLogin()
    {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        if (!$username || !$password) {
            die("Username or password cannot be empty!");
        }

        $user = $this->userModel->checkLogin($username, $password);

        if ($user) {
            $_SESSION['user'] = $user;
            echo 'Đăng nhập thành công. <a href="index.php?controller=user&action=dashboard">Vào Dashboard</a>';
        } else {
            die('Sai thông tin đăng nhập.');
        }
    }

    // Dashboard
    public function dashboard()
    {
        if (!isset($_SESSION['user'])) {
            die('Bạn cần đăng nhập. <a href="index.php?controller=user&action=login">Đăng nhập</a>');
        }
        $this->view('frontend.users.dashboard', ['user' => $_SESSION['user']]);
    }

    // Đăng xuất
    public function logout()
    {
        session_destroy();
        echo 'Bạn đã đăng xuất. <a href="index.php?controller=user&action=login">Đăng nhập lại</a>';
    }

    // Hiển thị trang quên mật khẩu
    public function forgotPassword()
    {
        $this->view('frontend.users.forgot_password');
    }

    // Xử lý quên mật khẩu
    public function handleForgotPassword()
    {
        $email = $_POST['email'] ?? null;

        if (!$email) {
            die("Email không được để trống!");
        }

        $user = $this->userModel->findByEmail($email);

        if ($user) {
            $this->sendResetEmail($email);
            echo "Một email đã được gửi để đặt lại mật khẩu của bạn.";
        } else {
            echo "Không tìm thấy tài khoản với email này.";
        }
    }

    // Gửi email thay đổi mật khẩu
    private function sendResetEmail($email)
    {
        $token = bin2hex(random_bytes(50));
        $resetLink = "http://localhost/reset-password.php?token=" . $token;

        // Save token to the database
        $this->userModel->saveResetToken($email, $token);

        $subject = "Đặt lại mật khẩu của bạn";
        $message = "Click vào đường link sau để thay đổi mật khẩu của bạn: " . $resetLink;
        mail($email, $subject, $message);
    }

    // Hiển thị trang thay đổi mật khẩu
    public function resetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleResetPassword();
        } else {
            $this->view('frontend.users.reset_password');
        }
    }


    // Xử lý thay đổi mật khẩu
    public function handleResetPassword()
    {
        $token = $_POST['token'] ?? null;
        $newPassword = $_POST['new_password'] ?? null;

        if (!$token || !$newPassword) {
            die("Cần điền đủ thông tin.");
        }

        $user = $this->userModel->findByToken($token);
        if ($user) {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            if ($this->userModel->updatePassword($user['email'], $hashedPassword)) {
                echo "Mật khẩu đã được thay đổi thành công!";
            } else {
                die("Có lỗi xảy ra, vui lòng thử lại.");
            }
        } else {
            die("Token không hợp lệ.");
        }
    }

}
