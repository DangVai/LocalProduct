<?php
class UserModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct('users');
    }

    // Tìm người dùng theo username
    public function findByUsername($username)
    {
        $query = "SELECT * FROM users WHERE Name = ?";

        if ($stmt = $this->connect->prepare($query)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return false; // No user found
            }
        } else {
            // Log or handle the error (you can also throw an exception here)
            error_log("Error preparing the query for finding user by username.");
            return false;
        }
    }

    public function createUser($username, $hashedPassword)
    {
        $stmt = $this->connect->prepare("INSERT INTO users (Name, password) VALUES (?, ?)");
        if ($stmt === false) {
            // Log or handle the error
            error_log("Error preparing the statement for user creation.");
            return false;
        }
        $stmt->bind_param('ss', $username, $hashedPassword);

        return $stmt->execute();
    }

    // Kiểm tra thông tin đăng nhập
    public function checkLogin($username, $password)
    {
        $user = $this->findByUsername($username);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                return $user; // Đăng nhập thành công
            } else {
                return false; // Mật khẩu không khớp
            }
        } else {
            return false; // Không tìm thấy người dùng
        }
    }

    // Tìm người dùng theo email
    public function findByEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = ?";

        if ($stmt = $this->connect->prepare($query)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return false;
            }
        } else {
            // Log or handle the error
            error_log("Error preparing the query for finding user by email.");
            return false;
        }
    }

    // Cập nhật mật khẩu mới
    public function updatePassword($email, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $query = "UPDATE users SET password = ? WHERE email = ?";

        if ($stmt = $this->connect->prepare($query)) {
            $stmt->bind_param("ss", $hashedPassword, $email);
            return $stmt->execute();
        } else {
            // Log or handle the error
            error_log("Error preparing the statement for updating password.");
            return false;
        }
    }

    public function saveResetToken($email, $token)
    {
        $query = "UPDATE users SET reset_token = ? WHERE email = ?";

        if ($stmt = $this->connect->prepare($query)) {
            $stmt->bind_param("ss", $token, $email);
            return $stmt->execute();
        } else {
            return false; // Return false if the query fails
        }
    }
}
