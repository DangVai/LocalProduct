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

    public function logOut()
    {
        session_start(); // Bắt đầu phiên làm việc

        // Xóa các giá trị session
        session_unset();

        // Hủy phiên làm việc
        session_destroy();

        // Chuyển hướng người dùng đến trang đăng nhập
        header("Location: /LocalProduct/index.php?controller=user&action=login");
        exit();
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
            $hashedPassword = ($newPassword);

            // Cập nhật mật khẩu
            $result = $this->userModel->updatePassword($email, $hashedPassword);

            if ($result) {
                // Xóa session sau khi đặt lại mật khẩu thành công
                unset($_SESSION['reset_code'], $_SESSION['reset_email']);

                // Chuyển hướng đến trang đăng nhập
                header('Location: index.php?controller=user&action=login&success=' . $sessionResetCode . urlencode('Password reset successful.'));
                exit;
            } else {
                header('Location: index.php?controller=user&action=login&error=' . $sessionResetCode . $resetCode . urlencode('Failed to reset password.'));
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
            header("Location: index.php?controller=user&action=register" . urlencode('OTP have been send.'));
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
                header("Location: index.php?controller=user&action=login");
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
        header('Location: index.php?controller=user&action=login&error=' . urlencode('Please enter all fields!'));
        exit;
    }

        $user = $this->userModel->checkLogin($username, $password); // Kiểm tra đăng nhập
        if ($user) {
            $_SESSION['user_logged_in'] = true; // Đánh dấu đã đăng nhập
            $_SESSION['user'] = $user; // Lưu thông tin người dùng vào session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['Name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_phone'] = $user['phone'];
            $_SESSION['user_avatar'] = $user['avata']; // Nếu có
            $_SESSION['user_address'] = $user['user_address']; // Nếu có
            
            header("Location: index.php?controller=home&action=home");
            exit; // Điều hướng tới home.
        } 
    else {
           $error = "invalid your infomationinfomation";
           header('Location: index.php?controller=user&action=login&error=' . urlencode($error));
        exit;
    }
}




    // Hiển thị trang đăng nhập (tuỳ chọn)
    public function showLoginPage()
    {
        include "Views/frontend/users/login.php"; // Đường dẫn tới view
    }




//===================User Profile====================
public function home()
{
    $this->view('frontend/home');
}

    public function profile()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
            header('Location: index.php?controller=user&action=login');
            exit;
        }

        // Lấy danh sách đơn hàng của người dùng
        $orders = $this->userModel->getOrders($userId);
        // Gửi dữ liệu qua view
        $this->viewWithoutLayout('frontend.users.profile', ['orders' => $orders]);
    }


    // Hiển thị trang chỉnh sửa hồ sơ
public function editProfile()
{
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?controller=auth&action=login");
        exit();
    }

    $user_id = $_SESSION['user']['user_id'];
    $user = $this->userModel->getUserById($user_id);

    if (!$user) {
        die("User not found.");
    }

    $this->view('frontend.users.editProfile', ['user' => $user]);
}

// Xử lý cập nhật hồ sơ
public function updateProfile()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_POST['user_id'] ?? null;
        $name = filter_var($_POST['Name'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
        $address = filter_var($_POST['user_address'], FILTER_SANITIZE_STRING);

        // Avatar ban đầu
        $avata = $_POST['current_avata'] ?? '';

        // Kiểm tra file avatar mới
        if (isset($_FILES['avata']) && $_FILES['avata']['error'] === UPLOAD_ERR_OK) {
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $file_extension = strtolower(pathinfo($_FILES['avata']['name'], PATHINFO_EXTENSION));

            if (!in_array($file_extension, $allowed_extensions)) {
                die("Unsupported file type.");
            }

            $target_dir = "public/images/User_Avata/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $target_file = $target_dir . uniqid() . '.' . $file_extension;
            if (move_uploaded_file($_FILES['avata']['tmp_name'], $target_file)) {
                $avata = $target_file;
            } else {
                die("Error uploading avatar file.");
            }
        }

        // Kiểm tra user_id
        if (!$user_id) {
            die("Invalid User ID.");
        }

        $result = $this->userModel->updateUser($user_id, $name, $email, $phone, $address, $avata);
        if ($result) {
            // Cập nhật session
            $_SESSION['user']['Name'] = $name;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['phone'] = $phone;
            $_SESSION['user']['user_address'] = $address;
            $_SESSION['user']['avata'] = $avata;

            header("Location: index.php?controller=user&action=profile");
            exit();
        } else {
            die("Error updating profile.");
        }
    }
}

    public function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_id']; // Lấy ID người dùng từ session
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            $user = new UserModel();

            // Kiểm tra mật khẩu xác nhận có khớp không
            if ($newPassword !== $confirmPassword) {
                $_SESSION['error'] = "New password and confirmation do not match.";
                header("Location: index.php?controller=user&action=profile");
                exit();
            }

            // Kiểm tra mật khẩu hiện tại
            if (!$user->checkCurrentPassword($userId, $currentPassword)) {
                $_SESSION['error'] = "Current password is incorrect.";
                header("Location: index.php?controller=user&action=profile");
                exit();
            }

            // Thực hiện thay đổi mật khẩu
            if ($user->changePassword($userId, $newPassword)) {
                $_SESSION['success'] = "Password has been changed successfully.";
                header("Location: index.php?controller=user&action=profile");
                exit(); // Chắc chắn dừng script sau khi điều hướng
            } else {
                $_SESSION['error'] = "An error occurred, please try again.";
                header("Location: index.php?controller=user&action=profile");
                exit(); // Chắc chắn dừng script sau khi điều hướng
            }
        } else {
            // Nếu không phải POST, chuyển về trang thay đổi mật khẩu
            require_once 'view/change-password.php';
        }
    }

    // public function showOrders()
    // {
    //     // Kiểm tra nếu có danh sách đã lọc trong session
    //     if (isset($_SESSION['filteredOrders'])) {
    //         $orders = $_SESSION['filteredOrders'];
    //         unset($_SESSION['filteredOrders']); // Xóa sau khi sử dụng để tránh dữ liệu cũ
    //     } else {
    //         // Lấy toàn bộ danh sách nếu không có bộ lọc
    //         $orders = $this->userModel->getOrders();
    //     }

    //     // Xử lý giá trị NULL và thay thế bằng "N/A"
    //     foreach ($orders as &$order) {
    //         foreach ($order as $key => &$value) {
    //             if (is_null($value)) {
    //                 $value = "N/A";
    //             }
    //         }
    //     }

    //     // Trả về View với dữ liệu
    //     $this->viewNoLayt("frontend.Admin.oderTracking", ["orders" => $orders]);
    // }
}