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
        $this->loadModel('UserModel');
        $this->userModel = new UserModel();
    }

    // Hiển thị trang đăng ký
    public function register()
    {
        $this->view('frontend.users.register', ['noHeaderFooter' => true]);
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
                die("All fields are required!");
            }

            if ($password !== $confirmPassword) {
                die("Passwords do not match!");
            }

            $hashedPassword = md5($password);

            // Kiểm tra xem email hoặc tên người dùng đã tồn tại hay chưa
            if ($this->userModel->findByUsername($fullName, $email)) {
                die("User with this username or email already exists!");
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
                    error_log("Failed to send OTP email to: $email");
                    die("Failed to send OTP email.");
                }
            } else {
                error_log("Failed to store user information into saveotp table.");
                die("Failed to register user.");
            }
        }


    public function OTP()
    {
        $email = $_SESSION['email_verification'] ?? null;

        if (!$email) {
            header("Location: index.php?controller=user&action=register");
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
