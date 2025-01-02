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


    public function updateQuantity($productId, $quantity)
    {
        // Câu lệnh SQL để cập nhật số lượng sản phẩm trong kho
        $query = "UPDATE products SET quantity = quantity - ? WHERE product_id = ?";

        // Chuẩn bị câu lệnh SQL
        $stmt = $this->connect->prepare($query);

        // Liên kết các tham số
        $stmt->bind_param("ii", $quantity, $productId);

        // Thực thi câu lệnh và kiểm tra kết quả
        if ($stmt->execute()) {
            return true;  // Cập nhật thành công
        } else {
            return false; // Cập nhật thất bại
        }
    }



    public function saveOrder($userInfo, $products)
    {
        // Lấy thông tin người dùng từ dữ liệu gửi lên
        $fullName = $this->connect->real_escape_string($userInfo['full_name']);
        $phone = $this->connect->real_escape_string($userInfo['phone']);
        $location = $this->connect->real_escape_string($userInfo['location']);
        $specificAddress = $this->connect->real_escape_string($userInfo['specific_address']);
        $userId = $this->connect->real_escape_string($userInfo['user_id']);

        // Bắt đầu giao dịch (transaction)
        $this->connect->begin_transaction();

        try {
            // Lưu thông tin đơn hàng vào bảng 'orderss'
            $stmt = $this->connect->prepare("INSERT INTO orderss (user_id, full_name, phone, location, specific_address) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param('issss', $userId, $fullName, $phone, $location, $specificAddress);
            $stmt->execute();
            $orderId = $this->connect->insert_id; // Lấy ID của đơn hàng vừa tạo

            // Lưu thông tin các sản phẩm vào bảng 'order_items'
            foreach ($products as $product) {
                $productId = $this->connect->real_escape_string($product['product_id']);
                $productName = $this->connect->real_escape_string($product['product_name']);
                $size = $this->connect->real_escape_string($product['size']);
                $price = $this->connect->real_escape_string($product['price']);
                $quantity = $this->connect->real_escape_string($product['quantity']);

                // Lưu sản phẩm vào bảng 'order_items'
                $stmt = $this->connect->prepare("INSERT INTO order_items (order_id, product_id, product_name, size, price, quantity) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param('iissdi', $orderId, $productId, $productName, $size, $price, $quantity);
                $stmt->execute();

                // Gọi phương thức updateQuantity để cập nhật số lượng sản phẩm
                $updateResult = $this->updateQuantity($productId, $quantity);
                if (!$updateResult) {
                    throw new Exception("Error updating product quantity");
                }
            }

            $this->connect->commit();
            return true; // Đơn hàng đã được lưu thành công
        } catch (Exception $e) {
            // Nếu có lỗi, rollback giao dịch
            $this->connect->rollback();
            return false; // Đơn hàng không được lưu
        }
    }




    public function addToCart($userId, $productId, $size, $quantity)

    {
        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $checkQuery = "SELECT * FROM cart WHERE user_id = ? AND product_id = ? AND size = ?";
        $stmt = $this->connect->prepare($checkQuery);
        $stmt->bind_param("iis", $userId, $productId, $size); // 'i' cho integer, 's' cho string
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Nếu sản phẩm đã có, chỉ cần cập nhật số lượng
            $updateQuery = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ? AND size = ?";
            $updateStmt = $this->connect->prepare($updateQuery);
            $updateStmt->bind_param("iiis", $quantity, $userId, $productId, $size);
            return $updateStmt->execute();
        } else {
            // Nếu sản phẩm chưa có, thêm mới vào giỏ hàng
            $insertQuery = "INSERT INTO cart (user_id, product_id, size, quantity) VALUES (?, ?, ?, ?)";
            $insertStmt = $this->connect->prepare($insertQuery);
            $insertStmt->bind_param("iisi", $userId, $productId, $size, $quantity);
            return $insertStmt->execute();
        }
    }



    //Home featured productsproducts
    public function getFeaturedProductsByQuantity()
    {
        $query = "SELECT p.product_id, p.name, p.category, p.price, p.quantity, i.img AS image_url
                  FROM products p
                  LEFT JOIN image i ON p.product_id = i.product_id
                  ORDER BY p.quantity DESC
                  ";

        $result = $this->connect->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTopProductsByQuantity()

    {
        $query = "SELECT 
        p.product_id AS product_id,
        p.name AS product_name,
        p.category,
        p.quantity,
        p.type,
        p.price,
        p.product_view_at,
        p.description,
        MAX(pi.img) AS product_image
    FROM 
        products p
    LEFT JOIN 
        image pi
    ON 
        p.product_id = pi.product_id
    GROUP BY p.product_id
    ORDER BY p.quantity DESC
    LIMIT 10
    ";

        $result = $this->connect->query($query);

        // Debug dữ liệu trả về
        if (!$result) {
            die("Lỗi truy vấn: " . $this->connect->error);
        }

        if ($result->num_rows === 0) {
            die("Không tìm thấy sản phẩm nào!");
        }

        // In dữ liệu ra màn hình
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function getCartItems($userId)
    {
        // Lấy danh sách sản phẩm trong giỏ hàng của người dùng
        $cartItems = $this->getCartProductDetails($userId);

        // Tính toán giá theo số lượng cho mỗi sản phẩm trong giỏ hàng
        foreach ($cartItems as &$item) {
            $item['total_price'] = $item['price'] * $item['quantity'];  // Tính tổng giá của sản phẩm
        }

        return $cartItems;
    }


    // Hàm lấy thông tin chi tiết sản phẩm trong giỏ hàng (bao gồm ảnh)
    private function getCartProductDetails($userId)
    {
        // Câu lệnh SQL để lấy sản phẩm và thông tin liên quan (bao gồm cả ảnh)
        $query = "
    SELECT 
        c.cart_id, 
        c.product_id, 
        c.size, 
        c.quantity, 
        p.name AS product_name, 
        p.price,

    p.product_view_at,
     

        i.img AS image_path  -- Lấy đường dẫn ảnh từ trường img trong bảng images
    FROM cart c
    JOIN products p ON c.product_id = p.product_id
    LEFT JOIN image i ON p.product_id = i.product_id
    WHERE c.user_id = ?
    group BY cart_id ASC  -- Sắp xếp để lấy ảnh đầu tiên theo image_id ";

        $stmt = $this->connect->prepare($query);

        // Kiểm tra xem câu lệnh chuẩn bị có thành công không
        if ($stmt === false) {
            die("MySQL prepare error: " . $this->connect->error);
        }

        $stmt->bind_param("i", $userId); // Đảm bảo tham số đúng kiểu

        $stmt->execute();
        $result = $stmt->get_result();
        $cartItems = [];

        // Duyệt qua từng sản phẩm trong giỏ hàng và thêm thông tin vào mảng
        while ($row = $result->fetch_assoc()) {
            // Thêm sản phẩm vào mảng giỏ hàng
            $cartItems[] = [
                'cart_id' => $row['cart_id'],
                'product_id' => $row['product_id'],
                'product_name' => $row['product_name'],
                'size' => $row['size'],
                'quantity' => $row['quantity'],
                'price' => $row['price'],
                'image_path' => $row['image_path'],  // Đường dẫn ảnh sản phẩm
                'product_view_at' => $row['product_view_at']
            ];
        }

        return $cartItems;
    }
    public function deleteItem($productId)
    {
        // Đảm bảo rằng câu lệnh DELETE đang xóa đúng dữ liệu trong bảng `cart`
        $sql = "DELETE FROM cart WHERE cart_id = ?";
        $stmt = $this->connect->prepare($sql);

        // Kiểm tra nếu câu lệnh chuẩn bị thành công
        if ($stmt === false) {
            error_log("Failed to prepare statement for deleting product ID: $productId");
            return false;
        }

        // Bind the productId parameter to the prepared statement
        $stmt->bind_param("i", $productId);  // "i" indicates an integer parameter

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true; // Thành công
        } else {
            // Log lỗi nếu không thành công
            error_log("Failed to delete product ID: $productId");
            return false;
        }
    }

    //XU LY CAC TRANG SAN PHAM
    public function getFashionProducts($priceFilter = '', $typeFilter = '', $keywordFilter = '')
    {
        $conditions = [];
        $params = [];
        // Lọc theo giá
        if (!empty($priceRange)) {
            $ranges = explode('-', $priceRange);
            $conditions[] = "(price >= ? AND price <= ?)";
            $params[] = (int)$ranges[0];
            $params[] = (int)$ranges[1];
        }

        // Lọc theo loại
        if (!empty($types)) {
            $placeholders = implode(',', array_fill(0, count($types), '?'));
            $conditions[] = "type IN ($placeholders)";
            $params = array_merge($params, $types);
        }

        // Lọc theo từ khóa
        if (!empty($keyword)) {
            $conditions[] = "product_name LIKE ?";
            $params[] = "%" . $keyword . "%";
        }

        $sql = ("SELECT p.product_id AS product_id,
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
            p.product_id = pi.product_id 
        WHERE category = 'fashion'");
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
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

    public function getFoodProducts()
    {
        $sql = ("SELECT p.product_id AS product_id,
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
            p.product_id = pi.product_id 
        WHERE category = 'Food'");
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

    public function getAnotherProducts()
    {
        $sql = ("SELECT p.product_id AS product_id,
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
            p.product_id = pi.product_id 
        WHERE category = 'another'");

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

    //LỌC SẢN PHẨM
    public function searchProducts($keyword)
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
                p.product_id = pi.product_id
            WHERE 
                p.name LIKE ? OR p.category LIKE ?";

        $stmt = $this->connect->prepare($sql);
        if (!$stmt) {
            // In ra lỗi nếu không thể chuẩn bị câu truy vấn
            die("Error preparing statement: " . $this->connect->error);
        }
        $searchKeyword = '%' . $keyword . '%';
        $stmt->bind_param("ss", $searchKeyword, $searchKeyword);
        $stmt->execute();
        if (!$stmt->execute()) {
            // In ra lỗi nếu không thể thực thi câu truy vấn
            die("Error executing statement: " . $stmt->error);
        }
        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
    }
    public function addFavorite($userId, $productId)
    {
        $sql = "INSERT INTO favorite (user_id, product_id, favorite_view_at) VALUES (?, ?, NOW())";
        $stmt = $this->connect->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ii", $userId, $productId);
            if ($stmt->execute()) {
                return true;
            } else {
                error_log("Lỗi khi thêm yêu thích: " . $stmt->error);
            }
        } else {
            error_log("Lỗi prepare statement: " . $this->connect->error);
        }

        return false;
    }

    // Thêm sản phẩm vào danh sách yêu thích
    public function getFavoriteItems($userId)
    {
        // Lấy danh sách sản phẩm trong giỏ hàng của người dùng
        $favoriteItems = $this->getFavorites($userId);
        return $favoriteItems;
    }
    public function getFavorites($userId)
    {
        $sql = "SELECT f.favorite_id, f.product_id,
        p.name AS product_name, p.price, p.product_view_at,
        i.img AS image_path  -- Lấy đường dẫn ảnh từ trường img trong bảng images
    FROM favorite f
    JOIN products p ON f.product_id = p.product_id
    LEFT JOIN image i ON p.product_id = i.product_id
    WHERE f.user_id = ?
    group BY favorite_id, ASC";

        $stmt = $this->connect->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                error_log("Lỗi truy vấn: " . $this->connect->error);
                return [];
            }
        } else {
            error_log("Lỗi prepare statement: " . $this->connect->error);
            return [];
        }
    }




    // Xóa sản phẩm khỏi danh sách yêu thích
    public function removeFavorite($favoriteId, $userId)
    {
        $sql = "DELETE FROM favorite WHERE favorite_id = ? AND user_id = ?";
        $stmt = $this->connect->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ii", $favoriteId, $userId); // `i` vì cả hai là số nguyên
            return $stmt->execute();
        } else {
            // Ghi log lỗi nếu prepare thất bại
            error_log("Lỗi prepare: " . $this->connect->error);
            return false;
        }
    }
}
