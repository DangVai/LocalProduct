<?php

class UserController extends BaseController
{
    public function __construct()
    {
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
        // Lấy dữ liệu từ form
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        // Kiểm tra dữ liệu hợp lệ
        if (!$username || !$password) {
            die("Username or password cannot be empty!");
        }

        // Mã hóa mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Sử dụng model UserModel để lưu dữ liệu vào cơ sở dữ liệu
        $this->loadModel('UserModel');
        $userModel = new UserModel();
        $result = $userModel->createUser($username, $hashedPassword);

        if ($result) {
            echo "Registration successful!";
        } else {
            echo "Failed to register. Please try again.";
        }
    }


    // Hiển thị trang đăng nhập
    public function login()
    {
        $this->view('frontend.users.login'); // Ensure you show the login form view here
    }

    // Xử lý đăng nhập
    public function handleLogin()
    {
        // Lấy dữ liệu từ form
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        // Kiểm tra dữ liệu hợp lệ
        if (!$username || !$password) {
            die("Username or password cannot be empty!");
        }

        // Gọi phương thức xử lý đăng nhập
        $user = $this->userModel->checkLogin($username, $password);

        if ($user) {
            session_start();
            $_SESSION['user'] = $user;
            echo 'Đăng nhập thành công. <a href="index.php?controller=user&action=dashboard">Vào Dashboard</a>';
        } else {
            die('Sai thông tin đăng nhập.');
        }
    }


    // Dashboard (Trang chính sau khi đăng nhập)
    public function dashboard()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            die('Bạn cần đăng nhập. <a href="index.php?controller=user&action=login">Đăng nhập</a>');
        }
        $this->view('users.dashboard', ['user' => $_SESSION['user']]);
    }

    // Đăng xuất
    public function logout()
    {
        session_start();
        session_destroy();
        echo 'Bạn đã đăng xuất. <a href="index.php?controller=user&action=login">Đăng nhập lại</a>';
    }
}
