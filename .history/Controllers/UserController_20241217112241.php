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
        // session_start();
        $this->loadModel('UserModel');
        $this->userModel = new UserModel();
    }

    public function introduction()
    {
        include 'Views/frontend/introduction.php';
        // $this->view("frontend.introduction");
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










    // Hiển thị trang đăng ký
    public function register()
    {
        // $this->view('frontend.users.register', ['noHeaderFooter' => true]);
        require('Views/frontend/users/register.php');

    }

    public function storeRegister()
    {
        $fullName = $_POST['full-name'] ?? null;
        $email = $_POST['email'] ?? null;
        $phone = $_POST['phone'] ?? null;
        $password = $_POST['password'] ?? null;
        $confirmPassword = $_POST['confirm-password'] ?? null;
        $OTP = rand(100000, 999999);

        // Debug: Ghi log thông tin
        error_log("Register data: fullName=$fullName, email=$email, phone=$phone");

        // Kiểm tra đầu vào
        if (!$fullName || !$email || !$phone || !$password || !$confirmPassword) {
            die("You have not entered enough fields!");
        }

        if ($password !== $confirmPassword) {
            die("Passwords do not match!");
            
        }

        $hashedPassword = md5($password);

        // Kiểm tra xem email hoặc tên người dùng đã tồn tại hay chưa
        if ($this->userModel->findByUsername($fullName, $email)) {
            header('Location: index.php?controller=user&action=register&error=' . urlencode('User with this username or email already exists!Please choose another username or email!'));
        exit;
        }

        // Lưu thông tin người dùng vào cơ sở dữ liệu
        $result = $this->userModel->storeotp($fullName, $email, $phone, $hashedPassword, $OTP);

        if ($result) {
            error_log("User information stored successfully.");
            if ($this->sendEmail($email, $OTP)) {
                error_log("OTP email sent successfully to: $email");
                $_SESSION['email_verification'] = $email;
                header("Location: index.php?controller=user&action=register&success=ok");
                exit;
            } else {
                 header('Location: index.php?controller=user&action=register&error=' . urlencode('Failed to send OTP email.'));
            exit;
            }
        } else {
            error_log("Failed to store user information into saveotp table.");
            die("Your registration failed.");
        }
    }


    public function OTP()
    {
        $email = $_SESSION['email_verification'] ?? null;

        if (!$email) {
            header("Location: index.php?controller=user&action=register".urlencode('OTP have been send.'));
            exit;
        }

        $this->view('frontend.users.otp', ['noHeaderFooter' => true, 'email' => $email]);
    }



    public function sendEmail($email, $OTP)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'on.ho26@student.passerellesnumeriques.org'; // Email của bạn
            $mail->Password = 'jriaycnpewjpslnu'; // Mật khẩu ứng dụng
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('on.ho26@student.passerellesnumeriques.org', 'Your Website');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'OTP verification code';
            $mail->Body = "Your OTP code:<b>$OTP</b>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log('Mailer Error: ' . $mail->ErrorInfo);
            return false;
        }
    }

    public function verifyOTP()
    {
        $email = $_SESSION['email_verification'] ?? null;
        $inputOTP = $_POST['OTP'] ?? null;

        if (!$email || !$inputOTP) {
            die("Invalid request.");
        }

        if ($this->userModel->checkOTP($email, $inputOTP)) {
            // Nếu OTP hợp lệ, chuyển dữ liệu sang bảng `users`
            $userData = $this->userModel->findByEmail($email);
            if (!$userData) {
                die("Email not found in saveotp table.");
            }

            if ($this->userModel->createUser($userData['Name'], $userData['email'], $userData['phone'], $userData['password'])) {
                echo "Registration successfully!";
                unset($_SESSION['email_verification']);
                header("Location: index.php?controller=user&action=login".urlencode('Login page.'));
            } else {
                die("Error while creating user.");
            }
        } else {
            echo "Invalid OTP code.";
        }
    } 



    
       // Hiển thị trang đăng nhập
    public function login() {
        include "Views/frontend/users/login.php"; // Đường dẫn đến view
    }

    // Xử lý đăng nhập
    public function handleLogin() {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        if (!$username || !$password) {
            $error = "Not enough.";
            header('Location: index.php?controller=user&action=login&error=' . urlencode('Please enter enough all fieldss!'));
        exit;
        }

        $user = $this->userModel->checkLogin($username, $password); // Kiểm tra đăng nhập
        if ($user) {
            $_SESSION['user'] = $user; // Lưu thông tin người dùng vào session
            header("Location: index.php?controller=user&action=home");
            exit; // Điều hướng tới home.
        } 
    else {
           $error = "invalid your infomationinfomation";
        header('Location: index.php?controller=user&action=login&error=' . urlencode('Please enter right your information!'));
        exit;
    }
    }
public function 
    // Hiển thị trang đăng nhập (tuỳ chọn)
    public function showLoginPage() {
        include "Views/frontend/users/login.php"; // Đường dẫn tới view
    }
}