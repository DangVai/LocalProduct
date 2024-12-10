<?php
class BaseModel extends db
{
    protected $table_name;

    public function __construct(string $table_name)
    {
        parent::__construct(); // Gọi constructor của class db
        $this->table_name = $table_name;
    }

    public function all()
    {
        $result = $this->connect->query("SELECT * FROM $this->table_name");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->connect->prepare("SELECT * FROM $this->table_name WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function findByUsername($username)
    {
        $stmt = $this->connect->prepare("SELECT * FROM $this->table_name WHERE Name = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function store($columns, $values)
    {
        $columns_str = implode(',', $columns);
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $types = str_repeat('s', count($values)); // Giả sử tất cả đều là chuỗi, chỉnh sửa nếu cần

        $stmt = $this->connect->prepare("INSERT INTO $this->table_name ($columns_str) VALUES ($placeholders)");
        $stmt->bind_param($types, ...$values);
        return $stmt->execute();
    }
}