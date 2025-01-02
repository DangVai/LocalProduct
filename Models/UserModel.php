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
    $hashedPassword = md5($password); // Mã hóa mật khẩu bằng md5
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
        $stmt->execute();
        $result = $stmt->get_result();
        echo "$query";

        return $result->num_rows > 0 ? $result->fetch_assoc() : false;
    }


    // Kiểm tra ng dùng khi đăng nhập
public function checkLogin($username, $password) {
    $user = $this->findusername($username);

    if ($user) {
        if ($user['status'] === 'locked') {
            echo "Your account is locked. Cannot login.";
            return false;
        }

        // So sánh mật khẩu đã mã hóa
        if ($user['password'] === md5($password)) {
            return $user; // Đăng nhập thành công
        } else {
            echo "Password is incorrect.";
        }
    } else {
        echo "User not found.";
    }

    return false;
}


//===============User Profile=========================

    // Lấy thông tin người dùng theo user_id
    public function getUserById($user_id)
    {
        $stmt = $this->connect->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Cập nhật thông tin người dùng
    public function updateUser($user_id, $name, $email, $phone, $address, $avata)
    {
        // Kiểm tra kết nối
        if (!$this->connect) {
            die("Database connection failed.");
        }

        // Chuẩn bị truy vấn SQL
        $stmt = $this->connect->prepare(
            "UPDATE users SET Name = ?, email = ?, phone = ?, user_address = ?, avata = ? WHERE user_id = ?"
        );
        if (!$stmt) {
            die("Error preparing statement: " . $this->connect->error);
        }

        // Bind dữ liệu
        $stmt->bind_param("sssssi", $name, $email, $phone, $address, $avata, $user_id);

        // Thực thi truy vấn
        if ($stmt->execute()) {
            return true;
        } else {
            die("Error executing query: " . $stmt->error);
        }
    }

    // Hàm kiểm tra mật khẩu cũ
    // Hàm kiểm tra mật khẩu cũ
    public function checkCurrentPassword($userId, $currentPassword)
    {
        $sql = "SELECT password FROM users WHERE user_id = ?";
        $stmt = $this->connect->prepare($sql);

        // Kiểm tra nếu câu lệnh prepare không thành công
        if (!$stmt) {
            die('Lỗi câu lệnh SQL: ' . $this->connect->error);
        }

        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($password);

        if ($stmt->num_rows > 0) {
            $stmt->fetch();

            // So sánh mật khẩu người dùng nhập vào (đã mã hóa bằng md5) với mật khẩu trong cơ sở dữ liệu
            return md5($currentPassword) === $password; // Kiểm tra mật khẩu cũ đã mã hóa bằng md5
        }
        return false;
    }

    // Hàm thay đổi mật khẩu
    public function changePassword($userId, $newPassword)
    {
        // Mã hóa mật khẩu mới bằng md5
        $hashedPassword = md5($newPassword); // Sử dụng md5 để mã hóa mật khẩu mới

        $sql = "UPDATE users SET password = ? WHERE user_id = ?";
        $stmt = $this->connect->prepare($sql);

        if (!$stmt) {
            die('Lỗi câu lệnh SQL: ' . $this->connect->error);
        }

        $stmt->bind_param('si', $hashedPassword, $userId);
        return $stmt->execute();
    }

    public function getReviewsByProduct($product_id)
    {
        $sql = "SELECT u.user_name, r.content, r.stars, r.review_date 
                FROM reviews r
                JOIN users u ON r.user_id = u.user_id
                WHERE r.product_id = ?
                ORDER BY r.review_date DESC";

        // Chuẩn bị câu lệnh
        if ($stmt = $this->connect->prepare($sql)) {
            $stmt->bind_param("i", $product_id); // Liên kết tham số product_id
            $stmt->execute();
            $result = $stmt->get_result();

            $reviews = [];
            while ($row = $result->fetch_assoc()) {
                $reviews[] = $row;
            }
            $stmt->close();
            return $reviews;
        } else {
            return null;
        }
    }
    public function getOrders($userId)
    {
        $query = "SELECT order_id, user_id, phone,location, specific_address, status
              FROM orderss
              WHERE user_id = ?";

        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("i", $userId); // Gán tham số vào câu truy vấn
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            die("SQL Error: " . $this->connect->error);
        }

        $orders = $result->fetch_all(MYSQLI_ASSOC);
        return $orders;
    }

}