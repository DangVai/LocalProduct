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
//Home featured productsproducts
 public function getFeaturedProducts($limit) {
        $sql = "SELECT id, name, price, image FROM products WHERE is_featured = 1 LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();

        return $products;
    }

    public function __destruct() {
        $this->conn->close();
    }
    //end feateured productsproducts
}