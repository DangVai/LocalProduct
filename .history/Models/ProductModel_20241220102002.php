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
    // Lấy sản phẩm nổi bật theo số lượng
    public function getFeaturedProductsByQuantity()
    {
        $query = "SELECT p.product_id, p.name, p.category, p.price, p.quantity, i.img AS image_url
                  FROM products p
                  LEFT JOIN image i ON p.product_id = i.product_id
                  ORDER BY p.quantity DESC 
                  LIMIT 10"; // Lấy 10 sản phẩm có số lượng lớn nhất
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($product_id, $quantity)
    {
        // Code xử lý thêm vào giỏ hàng, ví dụ lưu vào session hoặc bảng giỏ hàng
    }

    // Lưu sản phẩm yêu thích
    public function toggleFavorite($product_id)
    {
        // Cập nhật cột `is_favorite` của sản phẩm
        $query = "UPDATE products SET is_favorite = NOT is_favorite WHERE product_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$product_id]);
    }
}
    //end feateured products
}