<?php
class BaseModel extends db
{
    protected $connect;
    protected $table_name;

    public function __construct(string $table_name)
    {
        $this->connect = $this->connect();  // Đảm bảo kết nối được thiết lập
        $this->table_name = $table_name;
    }

    public function all()
    {
        return mysqli_fetch_all($this->connect->query("SELECT * FROM $this->table_name"));
    }

    public function find($id)
    {
        return mysqli_fetch_assoc($this->connect->query("SELECT * FROM $this->table_name WHERE id = $id"));
    }

    public function store()
    {
        return mysqli_fetch_assoc($this->connect->query("INSERT INTO $this->table_name VALUES ()"));
    }
}
