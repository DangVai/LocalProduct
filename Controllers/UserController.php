<?php
require_once __DIR__ . '/../PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// require_once 'path/to/BaseController.php';
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
        $this->view('frontend.users.register', ['noHeaderFooter' => true]);
    }

    // public function storeRegister()
    // {
    //     $username = $_POST['username'] ?? null;
    //     $password = $_POST['password'] ?? null;

    //     if (!$username || !$password) {
    //         die("Username or password cannot be empty!");
    //     }

    //     $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    //     $result = $this->userModel->createUser($username, $hashedPassword);

    //     if ($result) {
    //         $this->view('frontend.users.login',['success' => true]);
    //     } else {
    //         $this->view('frontend.users.login', ['success' => false]);

    //     }
    // }

    // Hiển thị trang đăng nhập
    public function login()
    {
        $this->viewwithlayout("Views/layouts/customlayout.php",'frontend.users.login', ['error' => '1']);
    }

    // Xử lý đăng nhập
    // public function handleLogin()
    // {
    //     $username = $_POST['username'] ?? null;
    //     $password = $_POST['password'] ?? null;

    //     if (!$username || !$password) {
    //         die("Username or password cannot be empty!");
    //     }

    //     $user = $this->userModel->checkLogin($username, $password);

    //     if ($user) {
    //         $_SESSION['user'] = $user;
    //         echo 'Đăng nhập thành công. <a href="index.php?controller=user&action=dashboard">Vào Dashboard</a>';
    //     } else {
    //         die('Sai thông tin đăng nhập.');
    //     }
    // }

    // // Dashboard
    // public function dashboard()
    // {
    //     if (!isset($_SESSION['user'])) {
    //         die('Bạn cần đăng nhập. <a href="index.php?controller=user&action=login">Đăng nhập</a>');
    //     }
    //     $this->view('frontend.users.dashboard', ['user' => $_SESSION['user']]);
    // }

    // Đăng xuất
    public function logout()
    {
        session_destroy();
        echo 'Bạn đã đăng xuất. <a href="index.php?controller=user&action=login">Đăng nhập lại</a>';
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
            $mail->Body = "Your OTP code: <b>$OTP</b>";

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
                    echo "Đăng ký thành công!";
                    unset($_SESSION['email_verification']);
                    header("Location: index.php?controller=user&action=login");
                } else {
                    die("Error while creating user.");
                }
            } else {
                echo "Mã OTP không hợp lệ.";
            }
        }

}
