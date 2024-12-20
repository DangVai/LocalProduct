<?php
class UserModel extends BaseModel
{
    protected $table_name = "users";

    public function __construct()
    {
        parent::__construct('users');
    }




    // Tìm người dùng theo username
    public function findByUsername($fullName, $email)
    {
        $query = "SELECT * FROM {$this->table_name} WHERE Name = ? or email = ?";

        if ($stmt = $this->connect->prepare($query)) {
            // Gắn 2 tham số vào câu lệnh
            $stmt->bind_param("ss", $fullName, $email); // 'ss' nghĩa là 2 tham số kiểu chuỗi
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return false; // Không tìm thấy người dùng
            }
        } else {
            // Ghi log hoặc xử lý lỗi
            error_log("Error preparing the query for finding user by username.");
            return false;
        }
    }

    public function storeotp($fullName, $email, $phone, $hashedPassword, $OTP)
    {
        $stmt = $this->connect->prepare("INSERT INTO saveotp (Name, email, phone, password, OTP_code) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param('sssss', $fullName, $email, $phone, $hashedPassword, $OTP);
            if (!$stmt->execute()) {
                error_log("Database execution error: " . $stmt->error);
                die("Error executing query: " . $stmt->error); // Hiển thị lỗi trực tiếp để dễ debug
            }
            return true;
        } else {
            error_log("SQL Prepare Error: " . $this->connect->error);
            die("SQL prepare error: " . $this->connect->error); // Hiển thị lỗi khi prepare query
        }
    }




    public function createUser($fullName, $email, $phone, $hashedPassword)
    {
        $stmt = $this->connect->prepare("INSERT INTO users (Name, email, phone, password) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            error_log("Error preparing the statement for user creation.");
            return false;
        }
        $stmt->bind_param('ssss', $fullName, $email, $phone, $hashedPassword);

        if (!$stmt->execute()) {
            echo ("Error executing the statement: " . $stmt->error);
            return false;
        }
        return true;
    }



    //Sử dụng MySQLi nha
    public function findByEmail($email)
    {
        $query = "SELECT * FROM " . "saveotp" . " WHERE email = ?";
        if ($stmt = $this->connect->prepare($query)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }
        }
        return false;
    }


    public function checkOTP($email, $inputOTP)
    {
        $stmt = $this->connect->prepare("SELECT OTP_code FROM saveotp WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['OTP_code'] === $inputOTP;
        }
        return false;
    }

    public function deleteTempUser($email)
    {
        $query = "DELETE FROM saveotp WHERE email = ?";
        if ($stmt = $this->connect->prepare($query)) {
            $stmt->bind_param("s", $email);
            return $stmt->execute();
        } else {
            error_log("Error preparing the statement for deleting temp user.");
            return false;
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





    // Tìm người dùng theo username
   public function findusername($username) {
        $query = "SELECT * FROM users WHERE Name = ?";
        $stmt = $this->connect->prepare($query); // Sử dụng kết nối từ BaseModel
        if (!$stmt) {
            die("Database error: " . $this->connect->error);
        }
        $stmt->bind_param("s", $username); // Ràng buộc tham số
        $stmt->execute();//thực hiện truy vấn
        $result = $stmt->get_result();
        echo "$query";

        return $result->num_rows > 0 ? $result->fetch_assoc() : false;
    }

//Kiểm tra ng dùng khi đăng nhập
      public function checkLogin($username, $password) {
        $user = $this->findusername($username);
        if ($user) {
            // Mã hóa mật khẩu đầu vào bằng MD5 để so sánh
            if ($user['password'] === md5($password)) {
                return $user; // Mật khẩu khớp, trả về thông tin người dùng
            } else {
                echo "Mật khẩu không đúng.";
            }
        } else {
            echo "Không tìm thấy người dùng.";
        }
        return false;
    }


}