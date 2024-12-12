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

    public function introduction()
    {
        include 'Views/frontend/introduction.php';
        // $this->view("frontend.introduction");
    }
    // Hiển thị trang đăng nhập
    public function login()
    {
        $this->view("frontend.users.login");
    }

    public function handleLogin()
    {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        // Kiểm tra thông tin người dùng trong cơ sở dữ liệu
        $user = $this->userModel->checkLogin($username, $password);

        if ($user) {
            // Nếu mật khẩu đúng, lưu thông tin người dùng vào session
            $_SESSION['user'] = $user;
            header('Location: index.php?controller=user&action=dashboard&success=' . urlencode('Log in successfully!'));
            exit;
        } else {
            // Nếu sai thông tin đăng nhập, hiển thị thông báo lỗi
            header('Location: index.php?controller=user&action=login&error=' . urlencode('Wrong login information.'));
            exit;
        }
    }


    // Hiển thị trang quên mật khẩu
    public function forgot_password()
    {
        require('Views/frontend/users/forgot_password.php');
    }
    // Xử lý quên mật khẩu
    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->view('frontend.users.forgot_password', ['error' => 'Invalid email format.']);
                return;
            }

            $user = $this->userModel->findUserByEmail($email);

            if ($user) {
                $resetCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $expiryTime = time() + 6000;
                $this->userModel->saveResetCode($email, $resetCode, $expiryTime);

                $_SESSION['reset_code'] = $resetCode;
                $_SESSION['reset_email'] = $email;

                if ($this->sendResetEmail($email, $resetCode)) {
                    header('Location: index.php?controller=user&action=forgot_password&success=' . urlencode('The password reset code has been sent to your email.'));
                    exit;
                } else {
                    header('Location: index.php?controller=user&action=forgot_password&error=' . urlencode('Unable to send email. Please try again.'));
                }
            } else {
                header('Location: index.php?controller=user&action=forgot_password&error=' . urlencode('Email does not exist.'));
            }
        }
    }

    // Gửi email với mã reset
    public function sendResetEmail($email, $resetCode)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'dangvai30@gmail.com';
            $mail->Password = 'vhjz fvwk huze xbqs'; // Không nên để thông tin nhạy cảm trong mã nguồn
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('dangvai30@gmail.com', 'Your Website');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Code';
            $mail->Body = "Use the following code to reset your password: <b>$resetCode</b>";

            $mail->send();
            return true;

        } catch (Exception $e) {
            // error_log('Mailer Error: ' . $mail->ErrorInfo);
            return false;
        }
    }



    // Hiển thị form nhập mật khẩu mới

    public function resetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $newPassword = htmlspecialchars($_POST['newPassword'] ?? '', ENT_QUOTES, 'UTF-8');
            $resetCode = htmlspecialchars($_POST['resetCode'] ?? '', ENT_QUOTES, 'UTF-8');

            // Lấy email và mã xác nhận từ session
            $email = $_SESSION['reset_email'] ?? null;
            $sessionResetCode = $_SESSION['reset_code'] ?? null;

            // Kiểm tra email và mã xác nhận trong session
            if (is_null($email) || is_null($sessionResetCode)) {
                header('Location: index.php?controller=user&action=forgot_password&error=' . urlencode('Reset session data is missing'));
                return;
            }

            // So sánh mã xác nhận
            if ($resetCode !== $sessionResetCode) {
                header('Location: index.php?controller=user&action=forgot_password&error=' . urlencode('Verification code is incorrect.'));
                return;
            }

            // Mã hóa mật khẩu mới bằng md5
            $hashedPassword = md5($newPassword);

            // Cập nhật mật khẩu
            $result = $this->userModel->updatePassword($email, $hashedPassword);

            if ($result) {
                // Xóa session sau khi đặt lại mật khẩu thành công
                unset($_SESSION['reset_code'], $_SESSION['reset_email']);

                // Chuyển hướng đến trang đăng nhập
                header('Location: index.php?controller=user&action=login&success='.$sessionResetCode. urlencode('Password reset successful.'));
                exit;
            } else {
                header('Location: index.php?controller=user&action=login&error='. $sessionResetCode . $resetCode. urlencode('Failed to reset password.'));
            }
        }
    }



}