<?php
class ProductModel extends BaseModel
{

    const TABLE_NAME = 'products';
    public function __construct()
    {
        parent::__construct(self::TABLE_NAME);
    }

    // Mảng chứa các sản phẩm
    public function getAll()
    {
        return $this->all();
    }

    public function findProduct($id) {}
    public function getById($id)
    {
        // Truy vấn lấy thông tin sản phẩm
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE product_id = ?";
        $stmt = $this->connect->prepare($sql);

        if ($stmt === false) {
            die('Prepare failed: ' . $this->connect->error);  // Hiển thị lỗi nếu câu lệnh prepare bị lỗi
        }

        $stmt->bind_param('i', $id);  // Gắn tham số
        $stmt->execute();  // Thực thi câu lệnh SQL
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if (!$product) {
            return null;  // Không tìm thấy sản phẩm
        }

        // Lấy các ảnh của sản phẩm
        $imagesSql = "SELECT img FROM image WHERE product_id = ?";
        $imagesStmt = $this->connect->prepare($imagesSql);

        if ($imagesStmt === false) {
            die('Prepare failed: ' . $this->connect->error);  // In lỗi nếu prepare thất bại
        }

        $imagesStmt->bind_param('i', $product['product_id']);
        $imagesStmt->execute();
        $imagesResult = $imagesStmt->get_result();

        $images = [];
        while ($row = $imagesResult->fetch_assoc()) {
            $images[] = $row['img'];
        }

        // Lấy kích thước của sản phẩm
        $sizesSql = "SELECT size FROM Product_sizes WHERE product_id = ?";
        $sizesStmt = $this->connect->prepare($sizesSql);

        if ($sizesStmt === false) {
            die('Prepare failed: ' . $this->connect->error);  // In lỗi nếu prepare thất bại
        }

        $sizesStmt->bind_param('i', $product['product_id']);
        $sizesStmt->execute();
        $sizesResult = $sizesStmt->get_result();

        $sizes = [];
        while ($row = $sizesResult->fetch_assoc()) {
            $sizes[] = $row['size'];
        }

        // Gắn thông tin vào sản phẩm
        $product['images'] = $images;
        $product['sizes'] = $sizes;

        return $product;
    }


    public function getByCategory($category, $excludeId)
    {
        $sql = "SELECT 
        p.product_id AS product_id,
        p.name AS product_name,
        p.category,
        p.quantity,
        p.type,
        p.price,
        p.product_view_at,
        p.description,
        -- Chỉ lấy một hình ảnh đầu tiên cho mỗi sản phẩm
        MAX(pi.img) AS product_image
    FROM 
        products p
    LEFT JOIN 
        image pi
    ON 
        p.product_id = pi.product_id
    WHERE 
        p.category = ? AND p.product_id != ? AND pi.img IS NOT NULL
    GROUP BY 
        p.product_id"; // Nhóm theo product_id để mỗi sản phẩm xuất hiện một lầnu

        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param("si", $category, $excludeId); // Liên kết cả category và excludeId với câu truy vấn SQL
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            // Debug thông báo nếu không tìm thấy sản phẩm
            error_log("Không tìm thấy sản phẩm nào trong cơ sở dữ liệu.");
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getAllProductsWithImages()
    {
        $sql = "SELECT 
        p.product_id AS product_id,
        p.name AS product_name,
        p.category,
        p.quantity,
        p.type,
        p.price,
        p.product_view_at,
        p.description,
        pi.img AS product_image
    FROM 
        products p
    LEFT JOIN 
        image pi
    ON 
        p.product_id = pi.product_id";  // Không cần WHERE, lấy tất cả sản phẩm

        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            // Debug thông báo nếu không tìm thấy sản phẩm
            error_log("Không tìm thấy sản phẩm nào trong cơ sở dữ liệu.");
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);  // Lấy tất cả sản phẩm trong cơ sở dữ liệu
    }





    // Phương thức lưu đơn hàng vào CSDL
    public function createOrder($orderData)
    {
        $query = "INSERT INTO orders (size, quantity, product_name, product_id, product_price, full_name, phone, location, specific_address, payment_method, user_id, name, total_price) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Chuẩn bị câu lệnh SQL
        $stmt = $this->connect->prepare($query);

        // Liên kết các tham số
        $stmt->bind_param(
            "sisssssssissd",
            $orderData['size'],
            $orderData['quantity'],
            $orderData['product_name'],
            $orderData['product_id'],
            $orderData['product_price'],
            $orderData['full_name'],
            $orderData['phone'],
            $orderData['location'],
            $orderData['specific_address'],
            $orderData['payment_method'],
            $orderData['user_id'],
            $orderData['name'],
            $orderData['total_price']
        );

        // Thực thi và kiểm tra kết quả
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //Home featured productsproducts
    public function getFeaturedProductsByQuantity()
    {
        $query = "SELECT p.product_id, p.name, p.category, p.price, p.quantity, i.img AS image_url
                  FROM products p
                  LEFT JOIN image i ON p.product_id = i.product_id
                  ORDER BY p.quantity DESC
                  LIMIT 10"; // Lấy 10 sản phẩm có số lượng lớn nhất

        $result = $this->connect->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function addToCart($userId, $productId, $size, $quantity)
    {
        $size = $size ?? 'Default Size';  // Nếu không có size, sử dụng 'Default Size'
        $quantity = $quantity ?? 1;       // Nếu không có quantity, sử dụng 1

        // Chuẩn bị câu lệnh SQL để thêm sản phẩm vào giỏ hàng
        $query = "INSERT INTO cart (user_id, product_id, size, quantity) VALUES (?, ?, ?, ?)";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("iisi", $userId, $productId, $size, $quantity); // 'i' cho integer, 's' cho string

        return $stmt->execute();
    }


    //Home featured productsproducts
    public function getFeaturedProductsByQuantity()
    {
        $query = "SELECT p.product_id, p.name, p.category, p.price, p.quantity, i.img AS image_url
                  FROM products p
                  LEFT JOIN image i ON p.product_id = i.product_id
                  ORDER BY p.quantity DESC
                  LIMIT 10"; // Lấy 10 sản phẩm có số lượng lớn nhất

        $result = $this->connect->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
