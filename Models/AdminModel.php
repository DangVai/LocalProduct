<?php
class AdminModel extends BaseModel
{
    protected $table_name = "products";


    public function __construct()
    {
        parent::__construct('products');
    }




    // Lấy tất cả sản phẩm
    public function getAll() {
        $sql = "SELECT * FROM products ORDER BY product_view_at DESC";
        $result = $this->connect->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Thêm sản phẩm vào cơ sở dữ liệu
    public function create($data) {
        $query = "INSERT INTO products (name, category, image_id, quantity, type, price, description, size) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Chuẩn bị câu lệnh SQL
        $stmt = $this->connect->prepare($query);

        if (!$stmt) {
            die("Lỗi chuẩn bị SQL: " . $this->connect->error);
        }

        // Bind dữ liệu vào câu lệnh
        $stmt->bind_param(
            'siisidss', 
            $data['name'],
            $data['category'], 
            $data['image_id'], 
            $data['quantity'], 
            $data['type'], 
            $data['price'], 
            $data['description'], 
            $data['size']
        );

        // Thực thi và trả về kết quả
        return $stmt->execute();
    }
}
?>