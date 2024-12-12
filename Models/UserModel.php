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
        try {
            if ($stmt = $this->connect->prepare($query)) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    return $result->fetch_assoc();
                } else {
                    return null; // Không tìm thấy người dùng
                }
            } else {
                throw new Exception("Error preparing the query for finding user by username.");
            }
        } catch (Exception $e) {
            // error_log($e->getMessage());
            return false; // Xử lý lỗi chung
        }
    }


    public function checkLogin($username, $password)
    {
        $user = $this->findByUsername($username);

        if ($user) {
            if (($password) === $user['password']) {
                return $user; // Đăng nhập thành công
            } else {
                // echo "Sai mật khẩu"; // Thông báo lỗi
                return false; // Mật khẩu không khớp
            }
        } else {
            // echo "Không tìm thấy người dùng"; // Thông báo lỗi
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

    public function saveResetCode($email, $resetCode, $expiryTime)
    {
        $sql = "UPDATE {$this->table_name} SET reset_token = ?, reset_token_expiry = ? WHERE email = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param('sis', $resetCode, $expiryTime, $email);
        return $stmt->execute();
    }

    public function updatePassword($email, $password)
{
    $hashedPassword =md5($password); // Mã hóa mật khẩu bằng md5
    $query = "UPDATE {$this->table_name} SET password = ? WHERE email = ?";
    $stmt = $this->connect->prepare($query);
    $stmt->bind_param('ss', $hashedPassword, $email);
    return $stmt->execute(); // Trả về true nếu cập nhật thành công
}

}