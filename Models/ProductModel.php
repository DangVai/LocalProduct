<?php
class ProductModel extends BaseModel
{

    const TABLE_NAME = 'products';
    public function __construct() {
        parent::__construct(self::TABLE_NAME);
    }

// Mảng chứa các sản phẩm
    public function getAll()
    {
        return $this->all();
    }

    public function findProduct($id)
    {
        
    }
    public function deleteProduct($id)
    {
        return true;
    }
    public function getById($id)
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE id = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();  // Trả về sản phẩm nếu tìm thấy, hoặc null nếu không
    }


}