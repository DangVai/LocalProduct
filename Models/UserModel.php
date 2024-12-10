<?php
class UserModel extends BaseModel
{
    protected $table_name = "users";

    public function __construct()
    {
        parent::__construct('users');
    }

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

    public function checkLogin($username, $password)
    {
        $user = $this->findByUsername($username);

        if ($user) {
            // So sánh mật khẩu dưới dạng văn bản thuần túy
            if ($password === $user['password']) {
                return $user; // Đăng nhập thành công
            } else {
                return false; // Mật khẩu không khớp
            }
        } else {
            return false; // Không tìm thấy người dùng
        }
    }


    public function findUserByEmail($email)
    {
        $query = "SELECT * FROM {$this->table_name} WHERE email = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Trả về người dùng (hoặc null nếu không có kết quả)
    }

    public function createUser($username, $hashedPassword)
    {
        $stmt = $this->connect->prepare("INSERT INTO $this->table_name (Name, password) VALUES (?, ?)");
        $stmt->bind_param('ss', $username, $hashedPassword);
        return $stmt->execute();
    }

    public function saveResetCode($email, $resetCode, $expiryTime)
    {
        $sql = "UPDATE {$this->table_name} SET reset_token = ?, reset_token_expiry = ? WHERE email = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param('sis', $resetCode, $expiryTime, $email);
        return $stmt->execute();
    }

    public function updatePassword($email, $password)
    {
        $query = "UPDATE {$this->table_name} SET password = ? WHERE email = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param('ss', $password, $email);
        return $stmt->execute(); // Trả về true nếu cập nhật thành công
    }
}