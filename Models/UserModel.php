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
        // Prepare the SQL query
        $query = "SELECT * FROM users WHERE Name = ?";

        // Check if the query is prepared correctly
        if ($stmt = $this->connect->prepare($query)) {  // Thay $this->db thành $this->connect
            // Bind parameters
            $stmt->bind_param("s", $username); // Assuming 'username' is a string

            // Execute the statement
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Return the user data
                return $result->fetch_assoc();
            } else {
                return false; // No user found
            }

            // Close the statement
            $stmt->close();
        } else {
            // If prepare fails, return false
            return false;
        }
    }

    public function createUser($username, $hashedPassword)
    {
        $stmt = $this->connect->prepare("INSERT INTO users (Name, password) VALUES (?, ?)");
        $stmt->bind_param('ss', $username, $hashedPassword);

        return $stmt->execute();
    }

    // Kiểm tra thông tin đăng nhập
    public function checkLogin($username, $password)
    {
        $user = $this->findByUsername($username); // Tìm người dùng theo username
        var_dump($user); // Xem thông tin người dùng lấy từ cơ sở dữ liệu

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


}
