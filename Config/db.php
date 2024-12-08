<?php
class db
{
    protected $connect;

    public function connect()
    {
        // Cấu hình kết nối cơ sở dữ liệu MySQL
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'localProducts'; // Tên cơ sở dữ liệu của bạn

        // Kết nối đến cơ sở dữ liệu
        $this->connect = new mysqli($host, $username, $password, $dbname);

        // Kiểm tra kết nối
        if ($this->connect->connect_error) {
            die("Connection failed: " . $this->connect->connect_error);
        }

        return $this->connect;
    }
}
