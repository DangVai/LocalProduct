<?php
require_once __DIR__ . '/../PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        session_start();
        $this->loadModel('UserModel');
        $this->userModel = new UserModel();
    }

    // Hiển thị trang đăng nhập
    public function login()
    {
        $this->viewwithlayout("Views/layouts/customlayout.php", 'frontend.users.login', ['error' => '1']);
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


    // Hiển thị trang quên mật khẩu
    public function forgot_password()
    {
        $this->view('frontend.users.forgot_password');
    }

    // Xử lý quên mật khẩu
    // Xử lý quên mật khẩu
    public function forgotPassword()
    {
        error_log("Forgot Password method called."); // Ghi log để kiểm tra
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            error_log("Email entered: " . $email); // Ghi log email

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->view('frontend.users.forgot_password', ['error' => 'Invalid email format.']);
                return;
            }

            $user = $this->userModel->findUserByEmail($email);
            error_log("User found: ". print_r($user, true)); // Ghi log thông tin người dùng

            if ($user) {
                $resetCode = bin2hex(random_bytes(8));
                $expiryTime = time() + 3600; // Mã có hiệu lực trong 1 giờ
                $this->userModel->saveResetCode($email, $resetCode, $expiryTime);
                error_log("Reset code generated: " . $resetCode); // Ghi log mã reset

                if ($this->sendResetEmail($email, $resetCode)) {
                    $_SESSION['reset_code'] = $resetCode;
                    $_SESSION['reset_email'] = $email;
                    header('Location: index.php?controller=user&action=resetPasswordForm');
                    exit;
                } else {
                    $this->view('frontend.users.forgot_password', ['error' => 'Failed to send email. Please try again.======']);
                }
            } else {
                $this->view('frontend.users.forgot_password', ['error' => 'Email not found========.']);
            }
        }
    }

    // Gửi email với mã reset
    private function sendResetEmail($email, $resetCode)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Hoặc máy chủ SMTP của bạn
            $mail->SMTPAuth = true;
            $mail->Username = 'dangvai30@gmail.com';
            $mail->Password = 'vhjz fvwk huze xbqs';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('dangvai30@gmail.com', 'Your Website');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Code';
            $mail->Body = "Use the following code to reset your password: <b>$resetCode</b>";

            $mail->send();
            return true; // Gửi thành công
        } catch (Exception $e) {
            error_log('Email could not be sent. Mailer Error: ' . $mail->ErrorInfo); // Ghi log lỗi
            return false; // Gửi thất bại
        }
    }

    // Hiển thị form nhập mật khẩu mới
    public function resetPasswordForm()
    {
        if (!isset($_SESSION['reset_code'])) {
            echo "Invalid request.";
            exit;
        }

        $this->view('frontend.users.reset_password');
    }

    public function resetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $newPassword = htmlspecialchars($_POST['newPassword'] ?? '', ENT_QUOTES, 'UTF-8'); // Đảm bảo tên tham số chính xác

            if (empty($newPassword)) { // Kiểm tra mật khẩu
                echo "Password cannot be empty.";
                return;
            }

            $email = $_SESSION['reset_email'] ?? null; // Lấy email từ session
            if (is_null($email)) {
                echo "Email is not set in the session.";
                return;
            }

            $result = $this->userModel->updatePassword($email, $newPassword); // Cập nhật mật khẩu

            if ($result) {
                unset($_SESSION['reset_code'], $_SESSION['reset_email']); // Xóa session
                // Chuyển hướng đến trang đăng nhập
                header('Location: index.php?controller=user&action=login');
                exit;
            } else {
                echo "Failed to reset password. Please try again.";
            }
        }
    }
}